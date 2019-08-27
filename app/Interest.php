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


class Interest extends Model
{
    //
	protected $table = 'interest';
	protected $primaryKey='interest_id';
	public $timestamps = false;
	protected $guarded = [];

    /**
     * Returns name of the Model
     * @return Name of Model (String)
     */
    public function getName()
    {
        return 'Interest';
    }
    /**
     * Takes an id of a student as input and returns collection of Interests
     * corresponding to that student
     * @return Collection of Interest
     * @param int $student_id 
     */
    public function getInterestListOfStudent($student_id)
    {
    	return DB::table('students')
        ->join('student_interests', 'students.student_id', '=', 'student_interests.student_id')
        ->join('interest', 'interest.interest_id', '=', 'student_interests.interest_id')
        ->where('student_interests.student_id',$student_id)
        ->select('interest.interest_name')->get();
    }
    /**
     * Get filtered Interest list according to search query
     *
     * @param String $interest_name
     * @return collection of Interest Objects
     */
    public function getInterestCollectionAccordingToNameFilter($interest_name)
    {
        return $this->where('interest_name', 'like', '%' . $interest_name . '%')->get();
    }
}
