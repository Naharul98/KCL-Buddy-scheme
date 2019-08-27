<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminSession extends Model
{
    //
	protected $table = 'admin_sessions';
	public $timestamps = false;
	protected $guarded = [];

  /**
   * Insert AdminSession Records according to sessions list provided as an array 
   * @param int $admin_id array $arr
   * @return void
   */ 
	public function addAdminSessionsToDatabase($arr,$admin_id)
	{
		foreach($arr as $session) 
		{
			$this->insert(array('user_id' => $admin_id, 'session_id' => $session));
		}
	}
  /**
   * @param int $admin_id
   * @return Collection of AdminSessions Model a particular user/admin is a part of
   */ 
	public function getSessionsListModelSpecificToAdmin($admin_id)
	{
		return DB::table('admin_sessions')
		->join('sessions', 'sessions.session_id', '=', 'admin_sessions.session_id')
		->where('admin_sessions.user_id',$admin_id);
	}

  /**
   * @param int $admin_id
   * @return Collection of AdminSession a particular User/Admin is a part of
   */ 
	public function getSessionsListSpecificToAdmin($admin_id)
	{
		return $this->getSessionsListModelSpecificToAdmin($admin_id)->get();
	}

  /**
   * return admin list filtered according to filter request
   * @param int $admin_id Request $filterRequest
   * @return Collection of filtered admin users
   */ 
	public function getSessionsListSpecificToAdminWithFilter($admin_id,$filterRequest)
	{
		$sessionsList = $this->getSessionsListModelSpecificToAdmin($admin_id);
		if($filterRequest->input('session_name') != "")
		{
			$sessionsList->where('session_name', 'like', '%' .$filterRequest->input('session_name') . '%');
		}
		return $sessionsList->get();
	}

  /**
   * takes the primary key of the admin/user and removes all session allocation for that admin
   * @param int $admin_id
   * @return void
   */ 
  public function clearAdminSessions($admin_id)
  {
  	$this->where('user_id',$admin_id)->delete();
  }

  /**
   * Takes primary key of the Admin/User and returns an array of session ids, that the admin is a part of
   * @param int $user_id
   * @return array of session IDs (int)
   */
  public function getArrayOfSessionsInChargeForAParticularAdmin($user_id)
  {
  	return $this->where('user_id',$user_id)->pluck('session_id')->toArray();
  }

}
