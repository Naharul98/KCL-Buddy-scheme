<?php
use \Codeception\Step\Argument\PasswordArgument;

class LogoutCest
{
    public function _before(FunctionalTester $I)
    {
      $I->amOnPage('/register');
    }

    public function successfulLogout(FunctionalTester $I)
    {
      $I->wantTo('Logout from an account');
      $I->fillField('name', 'John Doe');
      $I->fillField('email', 'logouttest@kcl.ac.uk');
      $I->fillField('password', new PasswordArgument('password'));
      $I->fillField('password_confirmation', new PasswordArgument('password'));
      $I->click('Register', ['class' => 'btn']);

      $I->seeCurrentUrlEquals('/user_area/index');
      $I->click('Logout');
      $I->seeCurrentUrlEquals('/logout');
    }

    public function failLogout(FunctionalTester $I)
    {
      $I->wantTo('fail to logout (Access /logout without logging in)');

      $I->amOnPage('/logout');
      $I->seeCurrentUrlEquals('/logout');
      $I->see('error');
    }

}
?>
