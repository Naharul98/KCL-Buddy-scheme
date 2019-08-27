<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role',];

    protected $primaryKey = 'id';

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * set up relationship between the user and the verification model
     *
     */
    public function verifyUser()
    {
        return $this->hasOne('App\Verification');
    }
    
    public function session(){
        return $this->hasOne('App\Session');
    }
    
    public function getName()
    {
        return 'Admin';
    }
    /**
     * Get collection of user objects who are admins
     *
     * @return collection of User Objects
     */
    public function getAdminList()
    {
        return $this->where('role', 'like', '%' . 'admin' . '%');
    }
    /**
     * Get collection of user objects who are students and have entered their k number
     *
     * @return collection of User objects
     */
    public function getStudentListWithKNumbersOnly()
    {
        return $this->where('role', 'like', '%' . 'student' . '%')->whereNotNull('knumber')->get();
    }
}
