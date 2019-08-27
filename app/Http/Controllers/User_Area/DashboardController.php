<?php

namespace App\Http\Controllers\User_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\User;
use App\Junior;
use App\Senior;
use App\Match as Match;
use App\Session;
use App\Interest;
use App\StudentInterests;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
/*
|-----------------------------------------------------------------------------------
| Dashboard Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for handling the dashboard area of the user
|
*/
class DashboardController extends Controller
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
    * returns view for the data processing info page for the user
    *
    * @return view
    */
	public function showDataProcessingView()
	{
		return view('user_area.data_usage_info');
	}

   /**
    * Passes in necessary data to the dashboard view, and returns the view
    *
    * @return view
    */
	public function index()
	{
		$data=[];
		$user = Auth::user();
		$data['user'] = $user;
		$data['sessions_already_signed_up'] = $this->getSessionsSignedUpWithAllocationBoolean($user->id);
		$data['sessions_not_signed_up_yet'] = $this->getSessionsNotSignedUpYet();
		return view('user_area.index')->with($data);
	}

   /**
    * returns array of session ids for which there is sign up register link cookie, but have not signed up yet
    *
    * @return array of session ids (int)
    */
	private function getArrayOfSessionIdsNotSignedUpYetFromCookies()
	{
		$arr = [];
		if(strlen(Cookie::get('session_select_id'))>0)
		{
			$arr = explode(", ",Cookie::get('session_select_id'));
		}
		$returnArray = array_unique($arr);

		$sessionsAlreadySignedUp = $this->getSessionsAlreadySignedUp(Auth::user()->id)->pluck('sessions.session_id')->toArray();
		return array_diff($returnArray,$sessionsAlreadySignedUp);
	}

   /**
    * Create an instance of the Session model and returns it
    *
    * @return Session
    */
    protected function getSessionModel()
    {
        return new Session;
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
    * Returns Collection of Session objects which the user has not signed up yet, but has the register cookie
    *
    * @return Collection of Session
    */
	private function getSessionsNotSignedUpYet()
	{
		return Session::whereIn('sessions.session_id',$this->getArrayOfSessionIdsNotSignedUpYetFromCookies())->get();
	}

   /**
    * Returns Collection of Sessions which the user has already signed up in
    *
    * @param int $user_id
    * @return Collection of Session
    */
	private function getSessionsAlreadySignedUp($user_id)
	{
		return $this->getSessionModel()->getSessionsAlreadySignedUp($user_id);
	}

   /**
    * Returns Collection of Sessions which the user has already signed up in
    * along with whether he/she has been allocated yet for that session or not
    *
    * @param int $user_id
    * @return Collection of Session
    */
	private function getSessionsSignedUpWithAllocationBoolean($user_id)
	{
		return $this->getMatchModel()->getSessionsUserHasSignedUpWithAllocationBoolean($user_id);
	}

}
