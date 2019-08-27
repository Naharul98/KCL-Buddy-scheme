<?php

namespace App\Http\Controllers\User_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Student;
use App\Session;
use Illuminate\Support\Facades\Auth;
/*
|-----------------------------------------------------------------------------------
| Eligible Signup Session Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for displaying sessions to users which they can sign up in
|
*/
class EligibleSignupSessionController extends Controller
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
    * Passes in necessary data to the session choosing view and returns it
    * @return view
    */
	public function showSessionChoices()
	{
		return view('user_area.eligible_sessions_for_signup')
				->with('sessions',$this->getAllEligibleSessionsForSignup());
	}

   /**
    * returns Collection of Sessions that the currently logged in user can sign up to
    * @return Collection of Sessions
    */
	private function getAllEligibleSessionsForSignup()
	{
		return Session::whereNotIn('session_id',$this->getArrayOfSessionIdUserIsAleadyRegisteredIn())->where('is_locked',0)->get();
	}

   /**
    * returns array containing sessions ids of all the
    * sessions the currently logged in user has signed up in
    * @return array of session id (int)
    */
	private function getArrayOfSessionIdUserIsAleadyRegisteredIn()
	{
		return $this->getStudentModel()->getArrayOfSessionIdUserIsAleadyRegisteredIn(Auth::user()->id);
	}

   /**
    * Create an instance of the Student model and returns it
    *
    * @return Student
    */
    protected function getStudentModel()
    {
        return new Student;
    }

}
