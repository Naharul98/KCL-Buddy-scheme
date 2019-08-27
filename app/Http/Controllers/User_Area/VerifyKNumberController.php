<?php

namespace App\Http\Controllers\User_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Verification;
use App\Email;
use App\Rules\KNumber;
/*
|-----------------------------------------------------------------------------------
| Verify KNumber Controller
|------------------------------------------------------------------------------------
|
| This controller is responsible for handling K-Number verification
|
*/
class VerifyKNumberController extends Controller
{
    /**
     * Create a new controller instance and adds its respective middleware
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth');
    }

   /**
    * returns view for verifying K-Number
    *
    * @return view
    */
   public function inputKNumber()
   {
   	return view('user_area.knum_verify');
   }

   /**
    * Send verification Email and return appropriate view with success/error message
    * @param Request $request
    * @return view
    */
   public function verifyKNumByEmail(Request $request)
   {
   	$email = new Email();

   	$this->validateFormData($request);

   	$user = $this->insertKNumInUserTable($request);

   	$knum = $request->input('knumber');

   	$isSuccess = $email->sendVerificationEmailAndReturnStatus($knum,$user);

   	return ($isSuccess === true) ? 
   	redirect('/user_area/verify_knum')->with('success','We have sent you a verification link in your kcl email address. Please log in to your kcl email and click on the verification link to verify your profile') 
   	: 
   	redirect('/user_area/verify_knum')->with('error','There was a problem sending the verification email to your kcl email, Please check if you have entered the correct K-Number');

   }

   /**
    * validates form data upon submission
    * @param Request $request
    */
   private function validateFormData($request)
   {
   	$request->validate(['knumber' => ['required', 'string', new KNumber],]);
   }

   /**
    * inserts k number in users table and returns the user
    * @return the logged in user
    * @param Request $request
    */
   private function insertKNumInUserTable($request)
   {
   	$user = Auth::user();
   	$user->knumber = $request->input('knumber');
   	$user->save();
   	return $user;
   }

   /**
    * Verify user based on k number verification token
    * Then redirect based on whether verification success or failure 
    * with appropriate success/error message
    * @return redirect
    * @param Request $request
    */
   public function verifyUser($token)
   {
   	$verifyUser = $this->getUserToBeVerified($token);
   	if($this->verificationDataExists($verifyUser))
   	{
   		$user = $this->getUserByID($verifyUser->user_id);
   		//k number already verified
   		if($user->is_verified == '1') 
   		{
   			return redirect('/home')->with('success', "Your K number is already verified.");
   		}
   		else
   		{
   			//verify the user
   			$user->is_verified = 1;
   			$user->save();
   			return redirect('/home')->with('success', "Your K number has been successfully verified");
   		}
   	}
   	else
   	{
   		//k number couldnt be verified
   		return redirect('/login')->with('error', "Sorry your K Number couldn't be verified");
   	}
   }

   /**
    * get verification data absed on token
    * @return Verification
    * @param string $token
    */
   private function getUserToBeVerified($token)
   {
   	return (Verification::where('token', $token)->first());
   }

   /**
    * return false if user to be verified is not found, true otherwise
    * @return boolean
    * @param Verification $verifyUser
    */
   private function verificationDataExists($verifyUser)
   {
   	return (isset($verifyUser));
   }

   /**
    * return user based on the Id given
    * @return User
    * @param int $id
    */
   private function getUserByID($id)
   {
   	return User::find($id);
   }
}
