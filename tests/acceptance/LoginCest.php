<?php
use \Codeception\Step\Argument\PasswordArgument;

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
    }

    // tests
    public function studentSuccessfulLogin(AcceptanceTester $I)
    {
      $I->wantTo('successfully login as a student');
      $I->fillField('email', 'test.student@kcl.ac.uk');
      $I->fillField('password', new PasswordArgument('password'));
      $I->click(['class' => 'btn']);

      $I->seeCurrentUrlEquals('/user_area/index');
      $I->see('Dashboard');
      $I->see('Warning!');
      $I->seeLink('here', '/user_area/verify_knum');
      $I->seeLink('Sign up for a new session', '/user_area/select_session_for_signup/');
    }

    public function adminSuccessfulLogin(AcceptanceTester $I){
      $I->wantTo('successfully login as an admin');
      $I->fillField('email', 'adam@admin.com');
      $I->fillField('password', new PasswordArgument('password'));
      $I->click(['class' => 'btn']);

      $I->seeCurrentUrlEquals('/staff_area/sessions/index');
      $I->see('Feedback');
      $I->see('Interest Choices');
      $I->see('Sessions');
      $I->dontSee('Admin Users');
    }

    public function super_adminSuccessfulLogin(AcceptanceTester $I){
      $I->wantTo('successfully login as a superadmin');
      $I->fillField('email', 'rob@swire.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click(['class' => 'btn']);

      $I->seeCurrentUrlEquals('/staff_area/sessions/index');
      $I->see('Feedback');
      $I->see('Interest Choices');
      $I->see('Sessions');
      $I->see('Admin Users');

      $I->click('Change Admin');
      $I->seeCurrentUrlEquals('/staff_area/admin');
      $I->see('Admins', 'h3');
    }

    public function emptyFailLogin(AcceptanceTester $I)
    {
      $I->wantTo('fail login (No details entered)');
      $I->click(['class' => 'btn']);

      $I->see('The email field is required');
      $I->see('The password field is required');
      $I->seeCurrentUrlEquals('/login');
    }

    public function invalidFailLogin(AcceptanceTester $I)
    {
      $I->wantTo('fail login (Incorrect details entered)');
      //Both wrong email and wrong password give same message
      $I->fillField('email', 'invalid@email.com');
      $I->fillField('password', 'wrong_password');
      $I->click(['class' => 'btn']);

      $I->see('do not match');
      $I->seeCurrentUrlEquals('/login');
    }

}
?>
