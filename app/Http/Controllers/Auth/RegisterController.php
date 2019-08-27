<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Session;
use App\Verification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\AdminSession;
use App\Rules\NewAdminRegistrationSessionInCharge;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user_area/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('register');
    }

    /**
     * Check privilege of the user registering, and depending on that, redirects them to 
     * specific page depending on that 
     *
     * @return void
     */
    public function register(Request $request)
    {
      $this->validator($request->all())->validate();

      event(new Registered($user = $this->create($request->all())));
      if(Auth::check() == false)
      {
        $this->guard()->login($user);
        return $this->registered($request, $user)?: redirect($this->redirectPath());
      }
      else
      {
        return redirect('/staff_area/admin')->with('success','Admin Record Updated');
      }

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      if(Auth::check() == false)
      {
        return Validator::make($data, [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
      }
      else
      {
        return Validator::make($data, [
          'name' => ['required', 'string', 'max:255' , new NewAdminRegistrationSessionInCharge($data)],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
      }

    }

    /**
     * Create a new user instance after a valid registration.
     * if user registering is an admin, it creates an admin user
     * and finally, it returns the newly created User.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      if(Auth::check() == false)
      {
        $user =  User::create(['name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        ]);
        $this->createKNumVerificationData($user->id);
        return $user;
      }
      if(Auth::user()->role === "super_admin")
      {
        $user =  User::create(['name' => $data['name'],'email' => $data['email'],'password' => Hash::make($data['password']),'role' => $data['role'],]);

        ($data['role'] == 'admin')?$this->addAdminSessionsToDatabase($data['session_choices'],$user->id):'';

        return $user;
      }
    }

    /**
     * takes an array of session id containing session admin is made to be a part of
     * and then updates database to allocate the given admin id with the sessions
     *
     * @param  array  $arr int  $admin_id 
     * @return void
     */
    private function addAdminSessionsToDatabase($arr,$admin_id)
    {
      $adminSession = new AdminSession();
      $adminSession->addAdminSessionsToDatabase($arr,$admin_id);
    }

    /**
     * returns the view for the registration form
     * 
     * @return view
     */
    public function showRegistrationForm()
    {
      $title = 'Register';
      $openSessions = Session::where('is_locked',0)->get();
      return view('auth.register')->with('sessions',$openSessions);
    }

    /**
     * creates data for the purpose of Knumber verification of the user in the database
     * 
     * @return void
     * @param int  $userID 
     */
    private function createKNumVerificationData($userID)
    {
      Verification::create(['user_id' => $userID,'token' => sha1(time() . str_random(40)),]);
    }


}
