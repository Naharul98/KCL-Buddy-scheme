<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Senior extends Model
{
    //
	protected $table = 'senior';
	public $timestamps = false;
	protected $guarded = [];
	protected $primaryKey = 'senior_id';

    /**
     * Removes the student with the studentID provided, from the senior table
     * @param int $studentId
     * @return void
     */
	public function removeStudentFromSeniorTable($studentId)
	{
		$this->where('student_id',$studentId)->delete();
	}

	public function checkIfStudentIDIsOfASenior($studentID)
	{
		return ($this->where('student_id', $studentID)->exists()) ?true:false;
	}
	
   /**
    * Returns Senior model corresponding to given student ID
    * @param int $student_id
    * @return Senior or null if no senior with the student id exists
    */
	public function getSeniorByStudentID($student_id)
	{
		return $this->where('student_id',$student_id);
	}

}
