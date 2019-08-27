<?php

use \Codeception\Step\Argument\PasswordArgument;

class RegisterAdminViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', 'rob@swire.come');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click(['class' => 'btn']);
    }
    
     public function _after(AcceptanceTester $I){
        $I->click('Logout');
    }
   
    
}
?>
