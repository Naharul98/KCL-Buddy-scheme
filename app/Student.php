<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
	protected $table = 'students';
	public $timestamps = false;
	protected $primaryKey = 'student_id';
	protected $guarded = [];

    public function user(){
        
    }    
    
	public function getArrayOfSessionIdUserIsAleadyRegisteredIn($user_id)
	{
		return $this->where('user_id',$user_id)->pluck('session_id')->toArray();
	}

	public function getLoggedInStudentProfileAccordingToSession($session_id, $user_id)
	{
		return $this->where('user_id', $user_id)->where('session_id',$session_id)->first();
	}
}
