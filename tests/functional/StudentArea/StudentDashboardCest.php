<?php
use \Codeception\Step\Argument\PasswordArgument;
class StudentDashboardCest
{

    public function _before(FunctionalTester $I)
    {
      $I->amOnPage('/register');
      $I->fillField('name', 'John Doe');
      $I->fillField('email', 'dashboardtest@kcl.ac.uk');
      $I->fillField('password', new PasswordArgument('password'));
      $I->fillField('password_confirmation', new PasswordArgument('password'));
      $I->click('Register', ['class' => 'btn']);
    }

    // tests
    public function StudentDashboardTest(FunctionalTester $I)
    {
      $I->amOnPage('/user_area/index');
      $I->wantTo('View student dashboard');
      $I->see('Warning!');
      $I->seeLink('here', '/user_area/verify_knum');
      $I->seeLink('Sign up for a new session', '/user_area/select_session_for_signup/');
    }

    public function ProfileLinkTest(FunctionalTester $I)
    {
      $I->amOnPage('/user_area/index');
      $I->wantTo('Click complete profile link');
      $I->click('Sign up for a new session');
      $I->click('Select Session');
      $I->see('Signing up as');
      $I->seeInCurrentUrl('/user_area/create_profile/1');
    }

    public function VerificationLinkTest(FunctionalTester $I)
    {
      $I->amOnPage('/user_area/index');
      $I->wantTo('Click verify k-num link');
      $I->click('here');
      $I->see('Enter K number');
      $I->seeInCurrentUrl('/user_area/verify_knum');
    }

}
?>
