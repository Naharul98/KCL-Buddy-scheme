1
<?php
use \Codeception\Step\Argument\PasswordArgument;

class StudentAccessSecurityCest
{
    public function _before(FunctionalTester $I)
    {
      $I->amOnPage('/register');
      $I->fillField('name', 'John Doe');
      $I->fillField('email', 'studentaccesst@kcl.ac.uk');
      $I->fillField('password', new PasswordArgument('password'));
      $I->fillField('password_confirmation', new PasswordArgument('password'));
      $I->click('Register', ['class' => 'btn']);
    }

    public function testStudentCannotAccessAdminAreaDashboard(FunctionalTester $I){
      $I->wantTo('Test that an an unauthenticated student does not have access to admin dashboard');
      $I->amOnPage('/staff_area/sessions/index');
      // test that student is redirected to error page
      $I->see('403');
    }

    public function testStudentCannotAccessAdminAreaInterestPage(FunctionalTester $I){
      $I->wantTo('Test that an an unauthenticated student does not have access to admin interest index page');
      $I->amOnPage('/staff_area/interests/index');
      // test that student is redirected to error page
      $I->see('403');
    }



    public function testStudentCannotAccessSuperAdminArea(FunctionalTester $I){
      $I->wantTo('Test that an an unauthenticated student does not have access to super admin admin index page');
      $I->amOnPage('/staff_area/admin');
      // test that student is redirected to home page
      $I->see('Welcome To KCL Buddy Scheme!');
    }
}
?>
