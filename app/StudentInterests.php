<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentInterests extends Model
{

	protected $table = 'student_interests';
	public $timestamps = false;
	protected $guarded = [];

    /**
     * delete all interests corresponding to the given studentId
     * @param int studentId
     * @return void
     */
    public function clearStudentInterest($studentId)
    {
    	$this->where('student_id',$studentId)->delete();
    }

    public function getInterestChoicesOfStudentAsArray($student)
    {
    	return $this->where('student_id', $student->student_id)->pluck('interest_id')->toArray();

    }

}
