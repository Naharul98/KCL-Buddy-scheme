
<?php

use \Codeception\Step\Argument\PasswordArgument;

class DashboardViewCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', 'test.student@kcl.ac.uk');
      $I->fillField('password', new PasswordArgument('password'));
      $I->click('Login', ['class' => 'btn']);
    }


    public function testDashboardPage(AcceptanceTester $I){
        $I->amOnPage('/user_area/index');
        $I->wantTo('see if user is on the dashboard and sees checklist');

        $I->see('Warning!');
        $I->seeLink('here', '/user_area/verify_knum');
        $I->seeLink('Sign up for a new session', '/user_area/select_session_for_signup/');

    }

}
?>
