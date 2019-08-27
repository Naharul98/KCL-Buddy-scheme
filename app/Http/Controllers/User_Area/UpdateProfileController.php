<?php

namespace App\Http\Controllers\User_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Session;
use App\Interest;
use App\Student;
use App\Junior;
use App\Senior;
use App\StudentInterests;
use DB;
/*
|-----------------------------------------------------------------------------------
| Update Profile Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for handling update of info in user profile
|
*/
class UpdateProfileController extends ProfileCRUDController
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
    * returns view for the update profile page with a particular session id -  name preselected
    * In addition, passes in necessary data for the view
    *
    * @param int $session_id
    * @return view
    */
	public function showUpdateProfileForm($session_id)
	{
		$student = parent::getLoggedInStudentProfileAccordingToSession($session_id);

		return view('user_area.update_profile')
		->with('data', $this->getPrepopulateProfileFormData($student))
		->with('session', Session::find($session_id))
		->with('interests',parent::getInterestListSpecificToSession($session_id));

	}

   /**
    * Updates the profile for the student according to the request
    * and populates its respective junior/senior and interests table
    * In the end, it returns view with appropriate success message
    *
    * @param Request $request
    * @return redirect
    */
	public function updateProfile(Request $request)
	{
		$studentID = parent::getLoggedInStudentProfileAccordingToSession($request->input('session'))->student_id;
		$this->updateStudentRecordAccordingToProfile($request, $studentID);
		if(parent::isSeniorStudent($request))
		{
			parent::removeStudentFromJuniorTable($studentID);
			Senior::updateOrCreate(['student_id' => $studentID],
				['max_juniors' => $request->input('max_number_of_buddies'),]);
		}
		else
		{
			parent::removeStudentFromSeniorTable($studentID);
			Junior::updateOrCreate(['student_id' => $studentID],[]);
		}

		parent::clearStudentInterest($studentID);
		if($request->input('interest_choices') != null)
		{
			parent::addStudentInterestsToDatabase($request->input('interest_choices'),$studentID);
		}

		return redirect('/user_area/view_allocation/' . $request->input('session'))
				->with('success','Profile Updated');
	}

   /**
    * updates student profile according to student ID in the database and according to the request
    *
    * @param Request $request, int $studentID
    */
	private function updateStudentRecordAccordingToProfile($request, $studentID)
	{
		$student = Student::find($studentID);
		$student->gender = $request->input('gender');
		$student->contact = $request->input('contact');
		$student->priority_information = $request->input('priority_information');
		$student->need_priority = $request->input('need_priority');
		$student->profile_description = $request->input('profile_description');
		if(parent::isSeniorStudent($request) == false)
		{
			$student->same_gender_preference = $request->input('same_gender_preference');
		}
		else
		{
			$student->same_gender_preference = '0';
		}
		$student->save();
	}

   /**
    * get interest ids associated with the student as an array of interest ids
    * @return array of student interest ids
    * @param Student $student
    */
	private function getInterestChoicesOfStudentAsArray($student)
	{
		return parent::getStudentInterestsModel()->getInterestChoicesOfStudentAsArray($student);
	}

   /**
    * an associative array containing prepopulation form data for a particular student
    * @return assciative array containing prepopulation data for the profile update form
    * @param Student $student
    */
	private function getPrepopulateProfileFormData($student)
	{
		$data = [];
		$data["session"] = $student->session_id;
		$data["gender"] = $student->gender;
		$data["same_gender_preference"] = $student->same_gender_preference;
		$data["profile_description"] = $student->profile_description;
		$data["priority_information"] = $student->priority_information;
		$data["need_priority"] = $student->need_priority;
		$data["contact"] = $student->contact;
		if(parent::checkIfStudentIDIsOfASenior($student->student_id))
		{
			$data["student_type"] = "senior";
			$data["max_number_of_buddies"] = Senior::where('student_id',$student->student_id)->first()->max_juniors;
		}
		else
		{
			$data["student_type"] = "junior";
			$data["max_number_of_buddies"] = "1";
		}

		$data["interest_choices"] = $this->getInterestChoicesOfStudentAsArray($student);
		return $data;

	}

}
