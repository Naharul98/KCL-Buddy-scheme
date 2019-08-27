<?php

use \Codeception\Step\Argument\PasswordArgument;

class DeleteAccountViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', '1234@12.com');
      $I->fillField('password', new PasswordArgument('123456'));
      $I->click('Login', ['class' => 'btn']);
    }

    public function testDeleteConfirmationPage(AcceptanceTester $I){
        $I->amOnPage('/user_area/delete_account/871');
        $I->wantTo('see if user is given appropriate discalaimer');


        $I->see('Delete Account');
        $I->see('Are you sure you want to delete your account');
        $I->see('All data associated with your account will be removed. ');
        $I->see('Yes');
        $I->see('No');

    }
}
?>
