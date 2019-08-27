<?php
use \Codeception\Step\Argument\PasswordArgument;

class VerifyKNumCest
{
    public function _before(FunctionalTester $I)
    {
      $I->amOnPage('/register');

      $I->fillField('name', 'John Doe');
      $I->fillField('email', 'verifytest@kcl.ac.uk');
      $I->fillField('password', new PasswordArgument('password'));
      $I->fillField('password_confirmation', new PasswordArgument('password'));
      $I->click('Register', ['class' => 'btn']);
      $I->click('here');
      $I->seeCurrentUrlEquals('/user_area/verify_knum');
    }

    // tests
    public function successfullyVerify(FunctionalTester $I)
    {
      $I->wantTo('successfully send a verification email');
      $I->fillField('knumber', 'k9999999');
      $I->click('Send Verification Link');

      $I->see('Sent');
    }

    public function failOnlyCharsVerify(FunctionalTester $I)
    {
      $I->wantTo('fail to send a verification email (Only letters used in k number)');
      $I->fillField('knumber', 'kkkkkkkk');
      $I->click('Send Verification Link');

      $I->see('must');
    }

    public function failOnlyNumbersVerify(FunctionalTester $I)
    {
      $I->wantTo('fail to send a verification email (Only numbers used in k number)');
      $I->fillField('knumber', '99999999');
      $I->click('Send Verification Link');

      $I->see('must');
    }

    public function failOnlySymbolsVerify(FunctionalTester $I)
    {
      $I->wantTo('fail to send a verification email (Only symbols used in k number)');
      $I->fillField('knumber', '!?£$%^&*');
      $I->click('Send Verification Link');

      $I->see('must');
    }

    public function failKAndSymbolsVerify(FunctionalTester $I)
    {
      $I->wantTo('fail to send a verification email (k and symbols in k number)');
      $I->fillField('knumber', 'k?£$%^&*');
      $I->click('Send Verification Link');

      $I->see('must');
    }

    public function failTooLongVerify(FunctionalTester $I)
    {
      $I->wantTo('fail to send a verification email (k number > 8)');
      $I->fillField('knumber', 'k99999999999');
      $I->click('Send Verification Link');

      $I->see('must');
    }

    public function failTooShortVerify(FunctionalTester $I)
    {
      $I->wantTo('fail to send a verification email (k number < 8)');
      $I->fillField('knumber', 'k99');
      $I->click('Send Verification Link');

      $I->see('must');
    }

}
?>
