<?php

namespace App\Http\Controllers\User_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers;
use App\Session;
use App\Interest;
use App\Student;
use App\Junior;
use App\Senior;
use App\SessionInterests;
use App\StudentInterests;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

/*
|-----------------------------------------------------------------------------------
| Create Profile Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for handling creation of user profile
|
*/
class CreateProfileController extends ProfileCRUDController
{
    /**
     * Create a new controller instance and adds its respective middleware
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

   /**
    * returns view for the create profile page with particular session id name preselected
    * In addition, passes in necessary data for the view
    *
    * @param int $session_id
    * @return view
    */
	public function showCreateProfileView($session_id)
	{
		return view('user_area.create_profile')
		->with('session', Session::find($session_id))
		->with('interests',parent::getInterestListSpecificToSession($session_id));
	}

   /**
    * Creates a new profile for the student according to the request
    * and populates its respective junior/senior and interests table
    * In the end, it returns view with appropriate success message
    *
    * @param Request $request
    * @return redirect
    */
	public function createProfile(Request $request)
	{
		$studentID = $this->insertNewStudentInDatabaseAndReturnInsertedID($request);
		if(parent::isSeniorStudent($request))
		{
			Senior::create(['student_id' => $studentID, 'max_juniors'=> $request->input('max_number_of_buddies')]);
		}
		else
		{
			Junior::create(['student_id' => $studentID]);
		}
		if($request->input('interest_choices') != null)
		{
			parent::addStudentInterestsToDatabase($request->input('interest_choices'),$studentID);
		}
		return redirect('/user_area/index')->with('success','Profile Created');
	}

   /**
    * Inserts a student in the database according to the request
    * and returns the newly inserted student's ID
    *
    * @param Request $request
    * @return student ID of the newly inserted student
    */
	private function insertNewStudentInDatabaseAndReturnInsertedID($request)
	{
		$student = new Student;
		$student->gender = $request->input('gender');
		$student->session_id = $request->input('session');
		$student->contact = $request->input('contact');
		$student->priority_information = $request->input('priority_information');
		$student->need_priority = $request->input('need_priority');
		$student->profile_description = $request->input('profile_description');
		$student->user_id = Auth::user()->id;
		if(parent::isSeniorStudent($request) == false)
		{
			$student->same_gender_preference = $request->input('same_gender_preference');
		}
		else
		{
			$student->same_gender_preference = '0';
		}
		$student->save();
		return $student->student_id;
	}





}
