<?php

namespace App\Http\Controllers\Staff_Area;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Controllers;
use App\MatchMaking;

/*
|-----------------------------------------------------------------------------------
| Get Matches Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible running the matchmaking Algorithm
|
*/
class GetMatchesController extends Controller
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
   * Create an instance of the MatchMaking model and return it
   *
   * @return MatchMaking
   */
  private function getMatchMakingModel()
  {
    return new MatchMaking;
  }

  /**
   * Runs the matchmaking algorithm, and populates the data in the Match table
   * and finally, returns the view with appropriate success message
   *
   * @return redirect
   */
  public function populateMatchesTable($session_id)
  {
    $this->getMatchMakingModel()->populateMatches($session_id);
    return redirect('staff_area/allocations/' . $session_id)->with('success','Automated allocations done successfully');
  }
}
