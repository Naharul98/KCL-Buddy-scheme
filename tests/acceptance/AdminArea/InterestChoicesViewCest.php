<?php

use \Codeception\Step\Argument\PasswordArgument;

class InterestChoicesViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', 'adam@admin.com');
      $I->fillField('password', new PasswordArgument('password'));
      $I->click(['class' => 'btn']);
    }

     public function _after(AcceptanceTester $I){
        $I->click('Logout');
    }

    public function testInterestChoices(AcceptanceTester $I){
        $I->amOnPage('/staff_area/interests/index');
        $I->wantTo('see if all interests are displayed on the screen');

        $I->see('Interest/Hobby Choices');
        $I->see('Interest/Hobby Name');
        $I->see('Name:');

        $I->seeLink('Edit', '/staff_area/interests/update/1');
    }

    public function testCreateInterestChoice(AcceptanceTester $I){
        $I->amOnPage('/staff_area/interests/create');
        $I->wantTo('see if form provides neccessary information to add interest');
        $I->see('Create Interest choice');
        $I->see('Choice Name');
        $I->see('Create', ['class' => 'btn']);
    }
}
?>
