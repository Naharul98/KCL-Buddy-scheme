<?php
use \Codeception\Step\Argument\PasswordArgument;

class DeleteAccountCest
{
  public function testSuccessfulDelete(FunctionalTester $I)
  {
    $I->amOnPage('/register');
    $I->wantTo('delete an account');
    $I->fillField('name', 'John Doe');
    $I->fillField('email', 'deletetest@kcl.ac.uk');
    $I->fillField('password', new PasswordArgument('password'));
    $I->fillField('password_confirmation', new PasswordArgument('password'));
    $I->click('Register', ['class' => 'btn']);
    $I->click('Delete Account');

    $I->see('Are you sure you want to delete your account');
    $I->click('Yes');
    $I->see('your account along with all your existing data has been deleted.');
    $I->dontSeeRecord('users', array('name' => 'John Doe', 'email' => 'deletetest@kcl.ac.uk'));

  }

  public function testSelectNoInDeleteConfirmation(FunctionalTester $I)
  {
    $I->amOnPage('/register');
    $I->wantTo('select not to delete an account');
    $I->fillField('name', 'John Doe');
    $I->fillField('email', 'deletetest@kcl.ac.uk');
    $I->fillField('password', new PasswordArgument('password'));
    $I->fillField('password_confirmation', new PasswordArgument('password'));
    $I->click('Register', ['class' => 'btn']);
    $I->click('Delete Account');

    $I->see('Are you sure you want to delete your account');
    $I->click('No');
    $I->canSeeInCurrentUrl('/user_area/index');
    $I->seeRecord('users', array('name' => 'John Doe', 'email' => 'deletetest@kcl.ac.uk'));
  }

  public function testFailDelete(FunctionalTester $I)
  {
    $I->wantTo('fail to delete account (Access /delete_account without logging in)');

    $I->amOnPage('/delete_account');
    $I->see('Not Found');
  }

}

?>
