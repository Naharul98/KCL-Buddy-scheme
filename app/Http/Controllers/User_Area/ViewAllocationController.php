<?php

namespace App\Http\Controllers\User_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Session;
use App\User;
use App\Junior;
use App\Senior;
use App\Match as Match;
/*
|-----------------------------------------------------------------------------------
| View Allocation Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for displaying respective allocations to students
|
*/
class ViewAllocationController extends Controller
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
    * returns view for the view allocations page according to the given session id
    * In addition, passes in necessary data for the view
    *
    * @param int $session_id
    * @return view
    */
	public function showAllocations($session_id)
	{
		$data=[];
		$user = Auth::user();
		$student = $this->getStudentModel()->getLoggedInStudentProfileAccordingToSession($session_id,$user->id);

		$data['user'] = $user;
		$data['allocations'] = null;
		$data['session'] = Session::find($session_id);

		if($student !==null)
		{
			$data['allocations'] = $this->getAllocatedBuddies($student->student_id);
		}
		return view('user_area.view_allocations')->with($data);
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
    * Create an instance of the Match model and returns it
    *
    * @return Match
    */
    protected function getMatchModel()
    {
        return new Match;
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
    * Create an instance of the Junior model and returns it
    *
    * @return Junior
    */
    protected function getJuniorModel()
    {
        return new Junior;
    }

   /**
    * get collection of allocated buddies for the studentid
    * @param int $student_id
    * @return Match
    */
	private function getAllocatedBuddies($student_id)
	{
		$seniorResult = $this->getSeniorByStudentID($student_id)->first();
		if($this->isSenior($seniorResult))
		{
			return $this->getMatchModel()->getBuddyAloocationsForSenior($seniorResult->senior_id);
		}
		$juniorResult = $this->getJuniorByStudentID($student_id)->first();
		if($this->isJunior($juniorResult))
		{
			return $this->getMatchModel()->getBuddyAllocationForJunior($juniorResult->junior_id);
		}
		return null;
	}

   /**
    * Returns Senior model corresponding to given student ID
    * @param int $student_id
    * @return Senior, null if no senior with the student id exists
    */
	private function getSeniorByStudentID($student_id)
	{
		return $this->getSeniorModel()->getSeniorByStudentID($student_id);
	}

   /**
    * Returns Junior model corresponding to given student ID
    * @param int $student_id
    * @return Junior, null if no Junior with the student id exists
    */
	private function getJuniorByStudentID($student_id)
	{
		return $this->getJuniorModel()->getJuniorByStudentID($student_id);
	}

   /**
    * Returns true if object is a senior
    * @param Senior $seniorResult
    * @return boolean - true if parameter is a senior indeed
    */
	public function isSenior($seniorResult)
	{
		return ($seniorResult !==null);
	}

   /**
    * Returns true if object is a Junior
    * @param Junior $juniorResult
    * @return boolean - true if parameter is a junior indeed
    */
	public function isJunior($juniorResult)
	{
		return ($juniorResult !== null);
	}

}
