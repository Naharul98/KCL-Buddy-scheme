<?php
use \Codeception\Step\Argument\PasswordArgument;

class RegisterCest
{
    public function _before(FunctionalTester $I)
    {
      $I->amOnPage('/register');
    }

    // tests
    public function successfulRegister(FunctionalTester $I)
    {
      $I->wantTo('successfully register an account');
      $I->fillField('name', 'John Doe');
      $I->fillField('email', 'registertest@kcl.ac.uk');
      $I->fillField('password', new PasswordArgument('password'));
      $I->fillField('password_confirmation', new PasswordArgument('password'));
      $I->click('Register', ['class' => 'btn']);

      $I->seeCurrentUrlEquals('/user_area/index');
    }

    public function emptyFailedRegister(FunctionalTester $I)
    {
      $I->wantTo('fail registration (all fields empty)');
      $I->click('Register', ['class' => 'btn']);
      $I->seeCurrentUrlEquals('/register');

      $I->see('The name field is required');
      $I->see('The email field is required');
      $I->see('The password field is required');
    }

    public function emailFailedRegister(FunctionalTester $I)
    {
      $I->wantTo('fail registration (email does not have @)');
      $I->fillField('name', 'John Doe');
      $I->fillField('email', 'registertest');
      $I->fillField('password', new PasswordArgument('password'));
      $I->fillField('password_confirmation', new PasswordArgument('password'));
      $I->click('Register', ['class' => 'btn']);

      $I->seeCurrentUrlEquals('/register');
      $I->see('The email must be a valid email address');
    }

    public function passwordFailedRegister(FunctionalTester $I)
    {
      $I->wantTo('fail registration (passwords do not match)');
      $I->fillField('name', 'John Doe');
      $I->fillField('email', 'registertest@kcl.ac.uk');
      $I->fillField('password', 'password');
      $I->fillField('password_confirmation', 'notPassword');
      $I->click('Register', ['class' => 'btn']);

      $I->seeCurrentUrlEquals('/register');
      $I->see('password confirmation does not match');
    }

    public function existsFailedRegister(FunctionalTester $I)
    {
      $I->wantTo('fail registration (account already exists)');
      $I->fillField('name', 'John Doe');
      $I->fillField('email', 'test.student@kcl.ac.uk');
      $I->fillField('password', new PasswordArgument('password'));
      $I->fillField('password_confirmation', new PasswordArgument('password'));
      $I->click('Register', ['class' => 'btn']);

      $I->seeCurrentUrlEquals('/register');
      $I->see('The email has already been taken');
    }
}
?>
