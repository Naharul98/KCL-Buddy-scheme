<?php

use \Codeception\Step\Argument\PasswordArgument;

class ProfileViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', '1234@12.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click('Login', ['class' => 'btn']);
    }

    public function testStudentProfilePage(AcceptanceTester $I){
      $I->amOnPage('/user_area/create_profile/1');
      $I->wantTo('see if profile page provides neccessary fields to update profile');

      $I->see('Profile');
      $I->see('Signing up as');
      $I->see('Session');
      $I->see('Interests');
      $I->see('Gender');
      $I->see('Same Gender Allocation Preference');
      $I->see('Short description about yourself');
      $I->see('Additional contact informations for your buddy');
      $I->see('Check this box if you have any special needs');
      $I->see('How will my information be used?');
    }
    
    public function testStudentDataProcessingPage(AcceptanceTester $I){
      $I->amOnPage('/user_area/create_profile/1');
      $I->wantTo('see if data processing page provides neccessary information');
        
      $I->click('How will my information be used?');
      $I->seeInCurrentUrl('/user_area/data_processing_info');
      $I->see('How will my information be used?');
      $I->see('The information you enter into your profile is used solely to ensure you are being matched with the most compatible mentor/buddies. To ensure that your information is protected, data on the students and their profiles will be removed every year. This is also used in order to restart the matchmaking process for new students joining the KCL Buddy Scheme in the next academic year.');
      $I->see('If you would like to join the KCL Buddy Scheme in the next year, you will need to register again.');
      $I->see('Interests');
      $I->see('We aim to match you with students who share at least one common interest as you. Please note in some situations this may not be possible so be sure to choose all of the interests that apply to you.');
      $I->see('Gender Allocation Preference');
      $I->see('If this option is selected, your preference will be prioritised and you will be matched with someone of the same gender where possible.');
      $I->see('Contact Information');
      $I->see('Your contact information entered in will only be seen by your matched buddy/mentor to make it easier to communicate once the matches have been made.');
      $I->see('Special Needs');
      $I->see('Information on any special needs you may require can be seen by your assigned buddies/mentor as well as admins. In the case that you require special needs it is very important to include this information as an admin will be able to manually allocate you to the most suitable students.

');
    }
}
?>
