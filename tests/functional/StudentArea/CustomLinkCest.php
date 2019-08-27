<?php
use \Codeception\Step\Argument\PasswordArgument;

class CustomLinkCest
{
  public function _before(FunctionalTester $I)
  {
    $I->haveRecord('sessions', array('session_name' => 'CustomLinkTestSession', 'is_locked' => '0'));
  }

  public function linkGeneratesValidIDPass(FunctionalTester $I)
  {
    $I->wantTo('Successfully create a session and generate link');
    $I->amOnPage('/login');
    $I->fillField('email', 'rob@swire.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
    $testSessionID = '1';
    $sessionLink = '/staff_area/sessions/generateLink/' .+ (string)$testSessionID;
    $I->amOnPage($sessionLink);
    $I->see('Your custom link is');
    $signUpLink = '/id=' .+ (string)$testSessionID;
    $I->amOnPage($signUpLink);
    $I->see('Login');
    $I->see('E-mail Address');
    $I->see('Password');
  }

  public function linkGeneratesInvalidIDPass(FunctionalTester $I)
  {
    $I->wantTo('Successfully create a session and generate link with large ID');
    $I->amOnPage('/login');
    $I->fillField('email', 'rob@swire.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);

    $I->amOnPage('/staff_area/sessions/generateLink/999999999999999999999999999');
    $I->see('Your custom link is');
    $I->amOnPage('/id=999999999999999999999999999');
    $I->see('Login');
    $I->see('E-mail Address');
    $I->see('Password');
  }

  public function linkRegisterValidIDPass(FunctionalTester $I)
  {
    $I->wantTo('Successfully register through link');
    $testSessionID = '1';
    $signUpLink = '/id=' .+ (string)$testSessionID;
    $I->amOnPage($signUpLink);
    $I->click('Register', 'a');

    $I->fillField('name', 'John Doe');
    $I->fillField('email', 'customLinkTest@kcl.ac.uk');
    $I->fillField('password', new PasswordArgument('password'));
    $I->fillField('password_confirmation', new PasswordArgument('password'));
    $I->click('Register', ['class' => 'btn']);

    $I->seeCurrentUrlEquals('/user_area/index');
    $I->see('Session1', 'strong');
    $I->see('Profile Incomplete', ['class' => 'badge']);
  }

  public function OptOutValidIDPass(FunctionalTester $I)
  {
    $I->wantTo('Successfully opt out of session');
    $testSessionID = '1';
    $signUpLink = '/id=' .+ (string)$testSessionID;
    $I->amOnPage($signUpLink);
    $I->click('Register', 'a');

    $I->fillField('name', 'John Doe');
    $I->fillField('email', 'customLinkTest@kcl.ac.uk');
    $I->fillField('password', new PasswordArgument('password'));
    $I->fillField('password_confirmation', new PasswordArgument('password'));
    $I->click('Register', ['class' => 'btn']);

    $I->seeCurrentUrlEquals('/user_area/index');
    $I->see('Session1', 'strong');
    $I->see('Profile Incomplete', ['class' => 'badge']);
    $I->click('✖');
    $I->see('Opted out');
  }

  public function linkGeneratesEmptyFail(FunctionalTester $I)
  {
    $I->wantTo('Fail generating a link without no session id');
    $I->amOnPage('/login');
    $I->fillField('email', 'rob@swire.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);

    $I->amOnPage('/staff_area/sessions/generateLink/');
    $I->dontSee('Your custom link is');
    $I->see('404');
  }

  public function linkRegisterInvalidIDFail(FunctionalTester $I)
  {
    $I->wantTo('Fail to register through non-existent ID link');
    $I->amOnPage('/id=thisIsInvalid');
    $I->click('Register', 'a');

    $I->fillField('name', 'John Doe');
    $I->fillField('email', 'customLinkTest@kcl.ac.uk');
    $I->fillField('password', new PasswordArgument('password'));
    $I->fillField('password_confirmation', new PasswordArgument('password'));
    $I->click('Register', ['class' => 'btn']);

    $I->seeCurrentUrlEquals('/user_area/index');
    $I->dontSee('CustomLinkTestSession', 'strong');
    $I->dontSee('Profile Incomplete', ['class' => 'badge']);
  }

  public function OptOutManualSignupFail(FunctionalTester $I)
  {
    $I->wantTo('fail to opt out from a session signed up to manually');
    $testSessionID = '1';

    $I->amOnPage('/register');
    $I->fillField('name', 'John Doe');
    $I->fillField('email', 'customLinkTest@kcl.ac.uk');
    $I->fillField('password', new PasswordArgument('password'));
    $I->fillField('password_confirmation', new PasswordArgument('password'));
    $I->click('Register', ['class' => 'btn']);

    $I->seeCurrentUrlEquals('/user_area/index');
    $I->dontSee('Session1', 'strong');
    $I->dontSee('Allocation Pending', ['class' => 'badge']);

    $I->amOnPage('/user_area/create_profile/' .+ (string)$testSessionID);
    $I->selectOption("student_type", "junior");
    $I->selectOption("gender", "male");
    $I->selectOption("same_gender_preference", "1");
    $I->fillField("profile_description", "Custom Link Test");
    $I->click('Create Profile');
    $I->seeCurrentUrlEquals('/user_area/index');
    $I->see('Session1', 'strong');
    $I->see('Allocation Pending', ['class' => 'badge']);
    $I->amOnPage('/rId=' .+ (string)$testSessionID);
    $I->see('Session1', 'strong');
    $I->see('Allocation Pending', ['class' => 'badge']);
  }

}
?>
