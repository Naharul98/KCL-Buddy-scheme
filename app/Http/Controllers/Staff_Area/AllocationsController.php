<?php

namespace App\Http\Controllers\Staff_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Session;
use App\Match as Match;
use App\Email as Email;
use Auth;
use Illuminate\Support\Facades\DB;

/*
|-----------------------------------------------------------------------------------
| Allocations Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for handling allocations for the sessions/schemes
| It faciliates functionality for viewing current allocations, and viewing unallocated
| juniors, also enables the admin to finalize matches for the session.
|
*/

class AllocationsController extends Controller
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
     * Create an instance of the Match model and returns it
     *
     * @return Match
     */
    protected function getMatchModel()
    {
    	return new Match;
    }

    /**
     * takes a session ID, and returns the view for displaying matches and unallocated
     * juniors for that session
     *
     * @param int $session_id
     * @return void
     */
    public function displayAllocations($session_id)
    {
    	return view('staff_area/allocations/view_allocation')
    	->with('matches',$this->getMatchesInSession($session_id))
    	->with('session',$this->getSessionByID($session_id))
    	->with('unallocatedJuniors',$this->getVerifiedUnallocatedJuniors($session_id));
    }

    /**
     * takes a session ID, and returns the session corresponding to that ID
     *
     * @param int $session_id
     * @return Session
     */
    private function getSessionByID($session_id)
    {
    	return Session::find($session_id);
    }

    /**
     * takes a session ID, and returns the matches for the corresponding session
     *
     * @param int $session_id
     * @return Match
     */
    private function getMatchesInSession($session_id)
    {
    	return $this->getMatchModel()->getMatchesInSession($session_id);
    }

    /**
     * takes a senior id, session id, and junior id and deallocates 
     * the particular junior with the senior
     *
     * @param int $senior_id int $junior_id int $session_id
     * @return Redirect
     */
    public function deallocate($senior_id, $junior_id, $session_id)
    {
    	$this->deleteMatch($senior_id, $junior_id);
    	return redirect('staff_area/allocations/' . $session_id)->with('success','Deallocated successfully');
    }

    /**
     * Deletes matchess with given junior and senior id pair in order to deallocate them
     *
     * @param int $senior_id int $junior_id
     * @return void
     */
    private function deleteMatch($senior_id, $junior_id)
    {
    	$this->getMatchModel()->deleteMatch($senior_id, $junior_id);
    }

    /**
     * Takes a session ID and deallocates all unfinalized matches for that session
     *
     * @param int $sessionid
     * @return redirect
     */
    public function resetNonFinalizedMatches($session_id)
    {
    	$this->getMatchModel()->resetNonFinalizedMatches($session_id);
    	return redirect('staff_area/allocations/' . $session_id)->with('success','Non-Finalized Matches cleared successfully');
    }

    /**
     * Takes a session Id and returns unallocated juniors who are verified for that session
     *
     * @param int $sessionid
     * @return Match
     */
    private function getVerifiedUnallocatedJuniors($session_id)
    {
    	return $this->getMatchModel()->getVerifiedUnallocatedJuniors($session_id);
    }

    /**
     * Takes a session Id and finalizes matches for that session
     * and sends out emails to students who could not be allocated a match
     * and lastly, redirects them with appropriate success message
     *
     * @param int $sessionid
     * @return Match
     */
    public function finalizeMatches($session_id)
    {
    	$this->emailAllocatedStudents($session_id);
    	$this->getMatchModel()->finalizeMatchesForSession($session_id);
    	return redirect('staff_area/allocations/' . $session_id)->with('success','Matches finalized');
    }

    /**
     * Create an instance of the Email model and returns it
     *
     * @return Email model
     */
    private function getEmailModel()
    {
    	return new Email;
    }

    /**
     * Takes a session Id and sends an email to all students who have been allocated
     * a match, informing them that they have received the allocation
     * and finally, redirects them with appropriate success or error message
     *
     * @param int $sessionid
     * @return redirect
     */
    private function emailAllocatedStudents($session_id)
    {
    	$students = $this->getMatchModel()->getAllocatedSeniorsListWithKNumbersOnly($session_id)->merge($this->getMatchModel()->getAllocatedJuniorsListWithKNumbersOnly($session_id));

    	return ($this->getEmailModel()->sendAllocatedStudentEmailAndReturnStatus($students)) ?
    	 redirect('staff_area/allocations/' . $session_id)->with('success','Allocated students have been informed by email.') 
    	 : 
    	 redirect('staff_area/allocations/' . $session_id)->with('error','Something went wrong while sending emails to allocated students.');
    }

    /**
     * Takes a session Id and sends an apology email to all students 
     * who could NOT be allocated a match
     * and finally, redirects them with appropriate success or error message
     *
     * @param int $sessionid
     * @return redirect
     */
    public function emailUnallocatedStudents($session_id)
    {
    	$students = $this->getMatchModel()->getUnallocatedSeniorsListWithKNumbersOnly($session_id)->merge($this->getMatchModel()->getUnallocatedJuniorsListWithKNumbersOnly($session_id));

    	return ($this->getEmailModel()->sendUnallocatedStudentEmailAndReturnStatus($students)) ?
    	 redirect('staff_area/allocations/' . $session_id)->with('success','Unallocated students have been informed by email.') 
    	 : 
    	 redirect('staff_area/allocations/' . $session_id)->with('error','Something went wrong while sending emails to unallocated students.');
    }

}
