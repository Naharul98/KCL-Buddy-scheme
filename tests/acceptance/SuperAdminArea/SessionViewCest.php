<?php

use \Codeception\Step\Argument\PasswordArgument;

class SessionViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', 'rob@swire.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click(['class' => 'btn']);
    }
    
     public function _after(AcceptanceTester $I){
        $I->click('Logout');
    }
    
   
    public function testSessionChoices(AcceptanceTester $I){
        $I->amOnPage('/staff_area/sessions/index');
        $I->wantTo('see if all sessions are displayed on the screen');
        
        $I->see('Sessions');
        $I->see('Session ID');
        $I->see('Name');
    }
    
    public function testCreateSessionChoice(AcceptanceTester $I){
        $I->amOnPage('/staff_area/sessions/create');
        $I->wantTo('see if form provides neccessary information to add interest');
        
        $I->see('Create new session');
        $I->see('Session name:');
    }
}
    

?>
