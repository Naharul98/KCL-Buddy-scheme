<?php

use \Codeception\Step\Argument\PasswordArgument;

class VerifyKnumberViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', '1234@12.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click('Login', ['class' => 'btn']);
    }

   public function testVerifyKnumber(AcceptanceTester $I){
       $I->amOnPage('/user_area/verify_knum');
       $I->wantTo('see if page provides neccessary field to verify knumber');

       $I->see('Enter K number');

   }

}
?>
