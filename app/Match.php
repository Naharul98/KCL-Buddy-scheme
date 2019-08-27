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

class Match extends Model
{
    //
    protected $table = 'matches';
    public $timestamps = false;
    protected $guarded = [];

    public function __construct()
    {

    }
    
    public function senior(){
        return $this->belongsTo('App\Senior','senior_id','senior_id');
    }
    
    public function junior(){
        return $this->belongsTo('App\Junior','junior_id','junior_id');
    }

    public function getMatchesInSession($session_id)
    {

        $matches = $this->getMatches()->where('s1.session_id',$session_id)->where('s2.session_id',$session_id);
        return  $matches->select('matches.senior_id', 'matches.junior_id','u1.name as seniorName', 'u2.name as juniorName','u1.knumber as seniorKNumber', 'u2.knumber as juniorKNumber','u1.email as seniorEmail', 'u2.email as juniorEmail', 'matches.is_finalized as is_finalized')->paginate(10, ['*'], 'matches');

    }

    public function getBuddyAllocationForJunior($id)
    {
        $matches = $this->getMatches();
        return $matches->where('matches.junior_id',$id)->where('matches.is_finalized', '1')->select('u1.name as name', 'u1.email as email','s1.contact as contact','s1.profile_description as profile_description')->get();
    }

    public function getBuddyAloocationsForSenior($id)
    {
        $matches = $this->getMatches();
        return $matches->where('matches.senior_id',$id)->where('matches.is_finalized', '1')
        ->select('u2.name as name', 'u2.email as email','s2.contact as contact','s2.profile_description as profile_description')->get();
    }

    private function getMatches()
    {
        return DB::table('matches')
        ->join('senior', 'matches.senior_id', '=', 'senior.senior_id')
        ->join('junior', 'matches.junior_id', '=', 'junior.junior_id')
        ->join('students as s1', 'senior.student_id', '=', 's1.student_id')
        ->join('students as s2', 'junior.student_id', '=', 's2.student_id')
        ->join('sessions as se1', 'se1.session_id', '=', 's1.session_id')
        ->join('sessions as se2', 'se2.session_id', '=', 's1.session_id')
        ->join('users as u1', 's1.user_id', '=', 'u1.id')
        ->join('users as u2', 's2.user_id', '=', 'u2.id');
    }

    public function getVerifiedUnallocatedJuniors($session_id)
    {
        return DB::table('users')
        ->join('students', 'students.user_id', '=', 'users.id')
        ->join('junior', 'junior.student_id', '=', 'students.student_id')
        ->join('sessions', 'students.session_id', '=', 'sessions.session_id')
        ->where('sessions.session_id',$session_id)
        ->whereNotIn('junior.junior_id', $this->getMatchedJuniorIDListAsArray($session_id))
        ->where('users.is_verified', '1')
        ->select('users.name','junior.junior_id')->paginate(10, ['*'], 'unallocatedJuniors');

    }

    public function getMatchedJuniorIDListAsArray($session_id)
    {
        return $this->getMatches()->where('s1.session_id',$session_id)->where('s2.session_id',$session_id)->groupBy('matches.junior_id')->pluck('matches.junior_id')->toArray();
    }


    public function getMatchedSeniorIDListAsArray($session_id)
    {
        return $this->getMatches()->where('s1.session_id',$session_id)->where('s2.session_id',$session_id)->groupBy('matches.senior_id')->pluck('matches.senior_id')->toArray();
    }

    public function getEligibleSeniors($formFilterSelections, $session_id, $juniorStudentID)
    {
        $subquery = $this->getCommonInterests($juniorStudentID);
        $eligibleSeniors = DB::table('users')
        ->join('students', 'users.id', '=', 'students.user_id')
        ->join('senior', 'senior.student_id', '=', 'students.student_id')
        ->join('sessions', 'students.session_id', '=', 'sessions.session_id')
        ->leftJoin('matches', 'matches.senior_id', '=', 'senior.senior_id')
        ->leftJoin($subquery, 'students.student_id', '=', 'temp.senior_student_id')
        ->select('senior.student_id','users.name','students.gender','senior.max_juniors','students.same_gender_preference', 'senior.senior_id', 'temp.common_interests', 'students.same_gender_preference')
        ->where('sessions.session_id',$session_id)
        ->where('users.is_verified', '1')
        ->groupBy('senior.student_id', 'users.name','students.gender','senior.max_juniors','students.same_gender_preference', 'senior.senior_id','temp.common_interests', 'students.same_gender_preference')
        ->havingRaw('(senior.max_juniors - COUNT(matches.senior_id)) > 0');

        if($formFilterSelections['gender'] != "")
        {
            $eligibleSeniors->where('students.gender', $formFilterSelections['gender']);
        }
        if($formFilterSelections['name'] != "")
        {
            $eligibleSeniors->where('users.name', 'like', '%' .$formFilterSelections['name'] . '%');
        }

        return $eligibleSeniors->orderBy('temp.common_interests', 'DESC')->paginate(10);

    }

    public function getCommonInterests($juniorStudentID)
    {
        return DB::raw('(SELECT
            senior_interests.student_id as senior_student_id, 
            junior_interests.student_id as junior_student_id, 
            count(junior_interests.interest_id) as common_interests 
            FROM 
            (SELECT students.student_id, student_interests.interest_id 
            FROM student_interests join students on students.student_id=student_interests.student_id join senior on students.student_id=senior.student_id
            ) AS senior_interests,
            (SELECT students.student_id,student_interests.interest_id 
            FROM student_interests join students on students.student_id=student_interests.student_id join junior on junior.student_id=students.student_id
            WHERE students.student_id=' . $juniorStudentID . '
            ) AS junior_interests
            WHERE
            senior_interests.interest_id = junior_interests.interest_id 
            GROUP BY 
            senior_interests.student_id, 
            junior_interests.student_id) as temp
            ');
    }

    public function insertMatch($junior_id,$senior_id)
    {
        DB::table('matches')->insert(['senior_id' => $senior_id, 'junior_id' => $junior_id]);
    }

    public function getUnallocatedSeniorsListWithKNumbersOnly($session_id)
    {   
        return DB::table('users')
        ->join('students', 'users.id', '=', 'students.user_id')
        ->join('senior', 'students.student_id', '=', 'senior.student_id')
        ->select('users.knumber')
        ->whereNotNull('users.knumber')
        ->where('students.session_id', '=', $session_id)
        ->whereNotIn('senior.senior_id', $this->getMatchedSeniorIDListAsArray($session_id))
        ->get();
    }

    public function getUnallocatedJuniorsListWithKNumbersOnly($session_id)
    {   
        return DB::table('users')
        ->join('students', 'users.id', '=', 'students.user_id')
        ->join('junior', 'students.student_id', '=', 'junior.student_id')
        ->select('users.knumber')
        ->whereNotNull('users.knumber')
        ->where('students.session_id', '=', $session_id)
        ->whereNotIn('junior.junior_id', $this->getMatchedJuniorIDListAsArray($session_id))
        ->get();
    }
    
    public function getAllocatedSeniorsListWithKNumbersOnly($session_id)
    {   
        return DB::table('users')
        ->join('students', 'users.id', '=', 'students.user_id')
        ->join('senior', 'students.student_id', '=', 'senior.student_id')
        ->join('matches', 'senior.senior_id', '=', 'matches.senior_id')
        ->select('users.knumber')
        ->whereNotNull('users.knumber')
        ->where('students.session_id', '=', $session_id)
        ->where('matches.is_finalized', '=', 0)
        ->get();
    }

    public function getAllocatedJuniorsListWithKNumbersOnly($session_id)
    {   
        return DB::table('users')
        ->join('students', 'users.id', '=', 'students.user_id')
        ->join('junior', 'students.student_id', '=', 'junior.student_id')
        ->join('matches', 'junior.junior_id', '=', 'matches.junior_id')
        ->select('users.knumber')
        ->whereNotNull('users.knumber')
        ->where('students.session_id', '=', $session_id)
        ->where('matches.is_finalized', '=', 0)
        ->get();
    }

   /**
    * Returns Collection of Sessions which the user has already signed up in
    * along with whether he/she has been allocated yet for that session or not
    *
    * @param int $user_id
    * @return Collection of Session
    */
    public function getSessionsUserHasSignedUpWithAllocationBoolean($user_id)
    {
        return DB::select(
            'SELECT 
            sessions.session_name,
            sessions.session_id, 
            users.id,
            (
            EXISTS(SELECT * FROM matches WHERE matches.junior_id=junior.junior_id AND matches.is_finalized=1) OR 
            EXISTS(SELECT * FROM matches WHERE matches.senior_id=senior.senior_id AND matches.is_finalized=1)
            ) AS is_allocated 
            FROM users 
            INNER JOIN students ON students.user_id = users.id
            INNER JOIN sessions ON students.session_id = sessions.session_id
            LEFT OUTER JOIN senior ON students.student_id = senior.student_id
            LEFT OUTER JOIN junior ON students.student_id = junior.student_id
            WHERE users.id = ?', [$user_id]);
    }

    /**
     * takes a senior id, junior id and removes their record from the matches
     * in order to deallocate them
     *
     * @param int $senior_id int $junior_id
     * @return void
     */
    public function deleteMatch($senior_id, $junior_id)
    {
        $this->where('senior_id',$senior_id)->where('junior_id', $junior_id)->delete();
    }

    /**
     * Takes a session ID and deallocates all unfinalized matches for that session
     *
     * @param int $sessionid
     * @return void
     */
    public function resetNonFinalizedMatches($session_id)
    {
        $this->whereIn('senior_id',$this->getMatchedSeniorIDListAsArray($session_id))
        ->whereIn('junior_id',$this->getMatchedJuniorIDListAsArray($session_id))
        ->where('is_finalized','0')
        ->delete();
    }

    /**
     * Takes a session Id and finalizes matches for that session
     * and sends out emails to students who could not be allocated a match
     *
     * @param int $sessionid
     * @return void
     */
    public function finalizeMatchesForSession($session_id)
    {
        $this->whereIn('junior_id',$this->getMatchedJuniorIDListAsArray($session_id))
        ->whereIn('senior_id',$this->getMatchedSeniorIDListAsArray($session_id))
        ->update(['is_finalized'=>'1']);
    }

}
