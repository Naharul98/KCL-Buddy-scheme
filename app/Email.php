<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Mail\VerifyMail;
use App\Mail\FeedbackMail;
use App\Mail\UnallocatedStudentMail;
use App\Mail\AllocatedStudentMail;
use Mail;

class Email extends Model
{
	public function sendVerificationEmailAndReturnStatus($knum,$user)
	{
		$email = $this->convertKNumberToKclEmail($knum);
		try 
		{
			Mail::to($email)->send(new VerifyMail($user));
			return true;
		} 
		catch (Exception $e) 
		{
			return false;
		}
	}
	
	public function sendAllocatedStudentEmailAndReturnStatus($students)
	{
		$emailArray = $this->getEmailListAsArray($students);
		try 
		{
			Mail::to($emailArray)->send(new AllocatedStudentMail());
			return true;
		} 
		catch (Exception $e) 
		{
			return false;
		}
	}
	
	public function sendUnallocatedStudentEmailAndReturnStatus($students)
	{
		$emailArray = $this->getEmailListAsArray($students);
		try 
		{
			Mail::to($emailArray)->send(new UnallocatedStudentMail());
			return true;
		} 
		catch (Exception $e) 
		{
			return false;
		}
	}
	
	public function sendFeedbackEmailAndReturnStatus($students)
	{
		$emailArray = $this->getEmailListAsArray($students);
		try 
		{
			Mail::to($emailArray)->send(new FeedbackMail());
			return true;
		} 
		catch (Exception $e) 
		{
			return false;
		}
	}
	
	private function getEmailListAsArray($students)
	{
		$emailArray = array();
		foreach($students as $student)
		{
			array_push($emailArray, ($this->convertKNumberToKclEmail($student->knumber)));
		}
		return $emailArray;
	}

	private function convertKNumberToKclEmail($knum)
	{
		$kclEmail = (string) ($knum . '@kcl.ac.uk');
		return $kclEmail;
	}
}
