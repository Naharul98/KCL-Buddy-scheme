<?php
use \Codeception\Step\Argument\PasswordArgument;
class FeedbackCest
{
    public function _before(AcceptanceTester $I)
    {
      $I->amOnPage('/login');
      $I->fillField('email', 'adam@admin.com');
      $I->fillField('password', new PasswordArgument('password'));
      $I->click(['class' => 'btn']);
    }
    
    // tests
    public function adminFeedbackPageTest(AcceptanceTester $I)
    {
      $I->amOnPage('/staff_area/feedback');
      $I->wantTo('View feedback page');
      $I->see('Feedback');
      $I->see('Edit');
      $I->see('here');
      $I->see('Email Survey');
      $I->see('Email participants');
    }
    public function SurveyMonkeyLinkTest(AcceptanceTester $I)
    {
      $I->amOnPage('/staff_area/feedback');
      $I->wantTo('Click on SurveyMonkey link');
      $I->click('here');
      $I->see('SurveyMonkey');
      $I->see('Log in to your account');                                     
    }
    
}
?>