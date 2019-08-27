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

class MatchMaking extends Model{
    
  public function populateMatches($session_id){
    $this->insertMatches($this->getMatches($session_id));
  }
    
 public function insertMatches($matches){
   $insertable = [];
   foreach ($matches as $junior => $senior)
   {
     $row = ['senior_id'=>$senior, 'junior_id'=>$junior ];
     array_push($insertable, $row);
   }
   DB::table('matches')->insert($insertable);
  }

  public function getMatches($session_id)
    {
      $query_maker = new MatchMakingQueries($session_id);
      $interest_scores = $query_maker->getScores();
      $max_juniors_indexed = $query_maker->getMaxJuniors();
      $juniors_indexed= $query_maker->getJuniors();


      $matches = [];
      //assign the most compatible couples first
      foreach ($interest_scores as $value)
      {
        if (!isset($max_juniors_indexed[$value->senior_student_id]) or isset($matches[$value->junior_student_id]))
        {
          continue;
        }
        $matches[$value->junior_student_id] = $value->senior_student_id;
        $max_juniors_indexed[$value->senior_student_id] = (int)($max_juniors_indexed[$value->senior_student_id])-1;
        if ((int)($max_juniors_indexed[$value->senior_student_id])<1)
        {
          unset($max_juniors_indexed[$value->senior_student_id]);
        }
        unset($juniors_indexed[$value->junior_student_id]);
      }

      return $this->fillRemainingMatches($matches, $juniors_indexed, $max_juniors_indexed);
  }
    
  private function fillRemainingMatches($matches, $juniors_indexed, $max_juniors_indexed){
    //match any remaining juniors with any remaining seniors
    foreach ($juniors_indexed as $junior_student_id => $irrelevant)
    {
      if (count($max_juniors_indexed)<1)
      {
        break; //no seniors left
      }
      $senior_student_id = key($max_juniors_indexed);
      $matches[$junior_student_id]=$senior_student_id;
      $max_juniors_indexed[$senior_student_id] = (int)($max_juniors_indexed[$senior_student_id])-1;
      if ((int)($max_juniors_indexed[$senior_student_id])<1)
      {
        unset($max_juniors_indexed[$senior_student_id]);
      }
    }
    return $matches;
  }
}
