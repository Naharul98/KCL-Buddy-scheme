<?php

namespace App\Http\Controllers\Staff_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Email;
use App\Http\Controllers;

/*
|-----------------------------------------------------------------------------------
| Feedback Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for the feedback area of the application
|
*/
class FeedbackController extends Controller
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
     * Returns the view for the feedback page
     *
     * @return view
     */
    public function feedback()
    {
    	return view('staff_area.feedback');
    }

    private function getStudentListWithKNumbersOnly()
    {
    	return $this->getUserModel()->getStudentListWithKNumbersOnly();
    }

	/**
     * Attempt to send feedback email to students 
     * and redirect to appropriate page with appropriate success/error message
     * @return redirect
     */
	public function emailParticipants()
	{
		return ($this->getEmailModel()->sendFeedbackEmailAndReturnStatus($this->getStudentListWithKNumbersOnly())) ? 
		redirect('/staff_area/feedback')->with('success','Paticipants have been emailed with a link to the feedback survey.') 
		: 
		redirect('/staff_area/feedback')->with('error','Something went wrong while sending the feedback emails.');
	}

	/**
     * Create an instance of the Email model and returns it
     *
     * @return Match
     */
	private function getEmailModel()
	{
		return new Email;
	}

	/**
     * Create an instance of the Email model and returns it
     *
     * @return Match
     */
	private function getUserModel()
	{
		return new User;
	}

}
