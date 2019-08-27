<?php

namespace App\Http\Controllers\Staff_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Junior;
use App\Interest;
use App\Match;

/*
|-----------------------------------------------------------------------------------
| Manual Allocation Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for managing Manual allocations of students
|
*/
class ManualAllocationController extends Controller
{
    /**
     * Create a new controller instance and adds its respective middleware
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware(['auth', 'admin']);
    }

   	/**
     * returns view for browsing a list of eligible seniors that the junior can be allocated to
     * Passes in necessary data to the view
     * @param Request $request, int $junior_id, int $session_id
     * @return view
     */
    public function showEligibleSeniors(Request $request,$junior_id,$session_id)
    {
    	$student = $this->getJuniorDetails($junior_id);
    	$formFilterSelections = $this->getFormFilterSelectionsArray($request);
    	return view('/staff_area/allocations/manual_allocation')
    	->with('junior',$student)
    	->with('interestList',$this->getInterestListOfStudent($this->getStudentIdOfJunior($junior_id)))
    	->with('eligibleSeniors',$this->getEligibleSeniors($formFilterSelections,$session_id,$student->student_id))
    	->with('session_id',$session_id)
    	->with('formFilterSelections', $formFilterSelections);
    }
    
    /**
     * get data filter form prepopulation data for page reload
     * in the form of an associative array
     *
     * @param Request $request
     * @return array
     */
    private function getFormFilterSelectionsArray($request)
    {
    	$formFilterSelections = array("name"=>"","gender"=>"");
    	if($request->isMethod('post'))
    	{	
    		$formFilterSelections['name'] = $request->input('name');
    		$formFilterSelections['gender'] = $request->input('gender');
    	}
    	return $formFilterSelections;
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
     * Create an instance of the Interest model and returns it
     *
     * @return Interest
     */
    protected function getInterestModel()
    {
        return new Interest;
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
     * Takes an id of a junior as input and returns Junior model
     * containing student/user information about the particular junior
     * @return Junior
     * @param int $junior_id 
     */
    private function getJuniorDetails($junior_id)
    {
    	return $this->getJuniorModel()->getJuniorInformation($junior_id);
    }

    /**
     * Takes an id of a student as input and returns collection of Interests
     * corresponding to that student
     * @return Collection of Interest
     * @param int $student_id 
     */
    private function getInterestListOfStudent($student_id)
    {
    	return $this->getInterestModel()->getInterestListOfStudent($student_id);
    }

    /**
     * Takes a junior id as input and returns the corresponding student id 
     * @return student id
     * @param int $junior_id 
     */
    private function getStudentIdOfJunior($junior_id)
    {
		return $this->getJuniorModel()->getStudentIdOfJunior($junior_id);
    }

    /**
     * Takes a sessionID, juniorID, and returns a list of eigible seniors that the junior can be allocated to
     * In addtion, takes a form filter parameter array, and filters the data accordingly
     * @return Collection of Senior
     * @param array $formFilterSelections, int $session_id, int $juniorStudentID
     */
    private function getEligibleSeniors($formFilterSelections,$session_id, $juniorStudentID)
    {	
    	return $this->getMatchModel()->getEligibleSeniors($formFilterSelections,$session_id, $juniorStudentID);
    }

    /**
     * Takes a junior id and senior id and allocates them to each other.
     * In addtion, takes a session id, and redirects to the session page with success message
     * @return redirect
     * @param int $senior_id, int $session_id, int $junior_ID
     */
    public function executeAllocate($junior_id,$senior_id,$session_id)
    {
    	$this->getMatchModel()->insertMatch($junior_id,$senior_id);
    	return redirect('/staff_area/allocations/' .$session_id )->with('success','Allocation done successfully');
    }


}
