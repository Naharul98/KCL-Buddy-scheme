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

class Junior extends Model
{
    //
	protected $table = 'junior';
	public $timestamps = false;
	protected $guarded = [];
	protected $primaryKey = 'junior_id';

	/**
     * Takes an id of a junior as input and returns Junior model
     * containing student/user information about the particular junior
     * @return Junior
     * @param int $junior_id 
     */
	public function getJuniorInformation($junior_id)
	{
		return DB::table('users')
		->join('students', 'students.user_id', '=', 'users.id')
		->join('junior', 'junior.student_id', '=', 'students.student_id')
		->where('junior.junior_id',$junior_id)
		->select('users.name', 'users.knumber','students.gender', 'students.same_gender_preference','students.priority_information','junior.junior_id','students.student_id')
		->first();
	}
	
	/**
     * Takes a junior id as input and returns the corresponding student id 
     * @return student id
     * @param int $junior_id 
     */
	public function getStudentIdOfJunior($junior_id)
	{
		return $this->where('junior_id',$junior_id)->first()->student_id;
	}

	/**
     * Takes a student id and removes that student from the junior table
     * @return void
     * @param int $studentId 
     */
	public function removeStudentFromJuniorTable($studentId)
	{
		$this->where('student_id',$studentId)->delete();
	}

   /**
    * Returns Junior model corresponding to given student ID
    * @param int $student_id
    * @return Junior, null if no Junior with the student id exists
    */
	public function getJuniorByStudentID($student_id)
	{
		return $this->where('student_id',$student_id);
	}
}
