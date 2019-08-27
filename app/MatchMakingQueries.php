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

class MatchMakingQueries extends Model
{   
    private $session_id;
    
    public function __construct($session_id){
        $this->session_id = $session_id;
    }
     
  public function getScores(){
    //priority multipliers from least to most important
    $interest_multiplier=1;
    //ensures that no matches made between opposite genders
    $gender_preference_multiplier=($interest_multiplier * $this->getNumberOfInterests()) +2;      
    //ensures special needs students are matched first
    $priority_multiplier=($interest_multiplier * $this->getNumberOfInterests()) + (2 * $gender_preference_multiplier)+ 3; 
      
    return $this->getScoresWithMultipliers($interest_multiplier,$gender_preference_multiplier, $priority_multiplier);
    }
    
    public function getScoresWithMultipliers($interest_multiplier, $gender_preference_multiplier,$priority_multiplier){
        $interest_scores = DB::select(
      'SELECT
      junior_student_id, senior_student_id,
      ((COUNT(junior_interest_id)*?) +((junior_gender=senior_gender)*junior_preference*?)+((junior_gender=senior_gender)*senior_preference*?)+(junior_priority*?)) 
      AS score FROM
      (SELECT
      junior.junior_id as junior_student_id,
      interest_id as junior_interest_id,
      gender as junior_gender,
      same_gender_preference as junior_preference,
      need_priority as junior_priority
      FROM junior
      INNER JOIN student_interests ON junior.student_id=student_interests.student_id
      INNER JOIN students on students.student_id=junior.student_id
      INNER JOIN users on students.user_id=users.id
      WHERE
      students.session_id=?
      AND users.is_verified=TRUE
      AND NOT EXISTS(SELECT * FROM matches WHERE matches.junior_id=junior.junior_id)
      ) as a
      INNER JOIN
      (SELECT
      senior.senior_id as senior_student_id,
      interest_id AS senior_interest_id,
      gender as senior_gender,
      same_gender_preference as senior_preference
      FROM senior
      INNER JOIN student_interests ON senior.student_id=student_interests.student_id
      INNER JOIN students on students.student_id=senior.student_id
      INNER JOIN users on students.user_id=users.id
      WHERE
      students.session_id=?
      AND users.is_verified=TRUE
      AND NOT EXISTS(SELECT * FROM matches WHERE matches.senior_id=senior.senior_id)
      ) as b
      ON junior_interest_id= senior_interest_id
      GROUP BY junior_student_id, senior_student_id
      ORDER BY score DESC',
      [
        $interest_multiplier,
        $gender_preference_multiplier,
        $gender_preference_multiplier, 
        $priority_multiplier,
        $this->session_id,
        $this->session_id
      ]);

      return $interest_scores;
        
    }
    
    /**
    * Get a list of unmatched verified senior students in a given session and their specified max junior count
    * @param session id of seniors
    * @return array where valid seniors are mapped to their max junior count
    */
    public function getMaxJuniors(){
      $max_juniors = DB::select(
        'SELECT senior.senior_id as student_id, max_juniors
        FROM senior
        INNER JOIN students ON senior.student_id = students.student_id
        INNER JOIN users on students.user_id=users.id
        WHERE
        students.session_id=?
        AND users.is_verified=TRUE
        AND NOT EXISTS(SELECT * FROM matches WHERE matches.senior_id=senior.senior_id)', [$this->session_id]);

      $max_juniors_indexed = [];

      foreach ($max_juniors as $value)
      {
        $max_juniors_indexed[$value->student_id]=$value->max_juniors;
      }
      return $max_juniors_indexed;
    }

    /**
    * Get a list of the unmatched verified junior students in a given session
    * @param session id of junior students
    * @return array where valid junior student is mapped to 1
    */
    public function getJuniors(){
      $juniors = DB::select(
        'SELECT junior.junior_id as student_id
        FROM junior
        INNER JOIN students ON junior.student_id = students.student_id
        INNER JOIN users on students.user_id=users.id
        WHERE
        students.session_id=?
        AND users.is_verified=TRUE
        AND NOT EXISTS(SELECT * FROM matches WHERE matches.junior_id=junior.junior_id)', [$this->session_id]);

      $juniors_indexed=[];

      foreach ($juniors as $value)
      {
        $juniors_indexed[$value->student_id]=1;
      }

      return $juniors_indexed;
    }
    
    private function getNumberOfInterests(){
        return DB::table('interest')->count();
    }
}
