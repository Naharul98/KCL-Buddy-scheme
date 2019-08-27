<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Session;
use App\Interest;
use App\Student;
use App\Junior;
use App\Senior;
use App\Matches;
use App\StudentInterests;

class Session extends Model
{
    //
     protected $table = 'sessions';
     protected $primaryKey = 'session_id';
     protected $guarded = [];
     public $timestamps = false;

   /**
    * Returns name of the Model
    * @return Name of Model (String)
    */
    public function getName()
    {
        return 'Session';
    }
    
   

    public function getSessionsAlreadySignedUp($user_id)
    {
    	return DB::table('sessions')
		->join('students', 'sessions.session_id', '=', 'students.session_id')
		->join('users', 'users.id', '=', 'students.user_id')
		->where('users.id',$user_id)
		->distinct('sessions.session_id')
		->select('sessions.session_name', 'sessions.session_id', 'users.id');
    }

   /**
    * Get filtered Session list according to search query
    *
    * @param String $session_name
    * @return collection of Session Objects
    */
    public function getSessionCollectionAccordingToNameFilter($session_name)
    {
        return $this->where('session_name', 'like', '%' .$session_name . '%')->get();
    }
}
