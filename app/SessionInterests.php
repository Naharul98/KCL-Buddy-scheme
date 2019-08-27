<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SessionInterests extends Model
{
    //
	protected $table = 'session_interests';
	public $timestamps = false;
	protected $guarded = [];
	
  public function addSessionInterestsToDatabase($arr,$session_id)
	{
		if($arr != null && $arr !="")
    {
      foreach($arr as $interest) 
		  {
			  $this->insert(array('session_id' => $session_id, 'interest_id' => $interest));
		  }
    }
    $this->deleteRedundantStudentInterests($session_id);
	}
  
  private function deleteRedundantStudentInterests($session_id)
  {
    $query = DB::delete('DELETE si
      FROM student_interests si JOIN students s ON si.student_id=s.student_id
      WHERE s.session_id=? 
      AND si.interest_id NOT IN (SELECT session_interests.interest_id
      FROM session_interests JOIN interest ON session_interests.interest_id=interest.interest_id
      WHERE session_interests.session_id=?)', [$session_id,$session_id]);
  }
  
	public function getInterestListSpecificToSession($session_id)
	{
		return DB::table('session_interests')
        ->join('interest', 'interest.interest_id', '=', 'session_interests.interest_id')
        ->where('session_interests.session_id',$session_id)->get();
	}
  
  /**
   * Takes a session id and clears all interests allocated to that session
   * @param int $session_id
   * @return void
   */ 
  public function clearSessionInterests($session_id)
  {
    $this->where('session_id',$session_id)->delete();
  }

  /**
   * returns an array of integers containing interest ids allocated to session
   * based on the session id provided
   * @param int $session_id
   * @return array of interest ids
   */ 
  public function getArrayOfInterestIdsAllocatedToSession($session_id)
  { 
    return $this->where('session_id',$session_id)->pluck('interest_id')->toArray();
  }
}
