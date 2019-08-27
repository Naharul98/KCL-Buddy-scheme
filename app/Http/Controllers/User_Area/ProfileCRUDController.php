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
use App\SessionInterests;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
/*
|-----------------------------------------------------------------------------------
| Eligible Signup Session Controller
|------------------------------------------------------------------------------------
|
| This class models the controllers for Create and update operations on user profile.
|
*/
class ProfileCRUDController extends Controller
{
    /**
     * Returns true if the profile update/create request is for a senior student
     * @param Request $request
     * @return boolean
     */
	protected function isSeniorStudent($request)
	{
		return ($request->input('student_type') == 'senior')?true:false;
	}

   /**
    * Create an instance of the Junior model and returns it
    *
    * @return Junior
    */
    protected function getJuniorModel()
    {
        return new Junior;
    }

   /**
    * Create an instance of the Senior model and returns it
    *
    * @return Senior
    */
    protected function getSeniorModel()
    {
        return new Senior;
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

    /**
     * Removes the student with the studentID provided, from the junior table
     * @param int $studentId
     * @return void
     */
	protected function removeStudentFromJuniorTable($studentId)
	{
		$this->getJuniorModel()->removeStudentFromJuniorTable($studentId);
	}

    /**
     * Removes the student with the studentID provided, from the senior table
     * @param int $studentId
     * @return void
     */
	protected function removeStudentFromSeniorTable($studentId)
	{
		$this->getSeniorModel()->removeStudentFromSeniorTable($studentId);
	}

    /**
     * takes an array of interest IDs and populates StudentInterests table according
     * to studentID provided
     * @param array $arr, int $studentID
     * @return void
     */
	protected function addStudentInterestsToDatabase($arr,$studentID)
	{
		foreach($arr as $interest) 
		{
			$data = array('student_id' => $studentID, 'interest_id' => $interest);
			StudentInterests::insert($data);
		}
	}

    /**
     * gets student profile according to session id and current logged in user id
     * @param int $session_id
     * @return Student
     */
	protected function getLoggedInStudentProfileAccordingToSession($session_id)
	{
		return $this->getStudentModel()->getLoggedInStudentProfileAccordingToSession($session_id, $this->getLoggedInUserID());
	}

    /**
     * @return User id of the current logged in user (int)
     */
	private function getLoggedInUserID()
	{
		return Auth::user()->id;
	}

    /**
     * @return true if student ID corresponds to a senior, false otherwise
     */
	protected function checkIfStudentIDIsOfASenior($studentID)
	{
		return ($this->getSeniorModel()->checkIfStudentIDIsOfASenior($studentID));
	}

    /**
     * @param int session_id
     * @return array of interests corresponding to the given session_id
     */
	protected function getInterestListSpecificToSession($session_id)
	{
		return $this->getSessionInterestsModel()->getInterestListSpecificToSession($session_id);
	}

    /**
     * delete all interests corresponding to the given studentId
     * @param int studentId
     * @return void
     */
	protected function clearStudentInterest($studentId)
	{
		$this->getStudentInterestsModel()->clearStudentInterest($studentId);
	}

   /**
    * Create an instance of the SessionInterests model and returns it
    *
    * @return SessionInterests
    */
    protected function getSessionInterestsModel()
    {
        return new SessionInterests;
    }

   /**
    * Create an instance of the StudentInterests model and returns it
    *
    * @return StudentInterests
    */
    protected function getStudentInterestsModel()
    {
        return new StudentInterests;
    }

}

