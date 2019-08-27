<?php
use \Codeception\Step\Argument\PasswordArgument;
use Codeception\Util\Locator;

class SessionsCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'rob@swire.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
  }

  public function addNewSession(FunctionalTester $I)
  {
    $I->wantTo('Add a new session');
    $I->amOnPage('/staff_area/sessions/create');
    $I->fillField('session_name', 'Session1');
    $I->selectOption('form select[name=select_picker]', '1');
    $I->click('submit_session');

    $I->see('Success');
    $I->see('Test_Session_1');
    $I->seeRecord('sessions', ['session_name' => 'Session1']);
  }

  public function addNewSessionWithBlankField(FunctionalTester $I)
  {
    $I->wantTo('Try to add a session with a blank name');
    $I->amOnPage('/staff_area/sessions/create');
    $I->fillField('session_name', '');
    $I->click('submit_session');

    $I->dontSee('Success');
  }

  public function EditSession(FunctionalTester $I)
  {
    $I->wantTo('Edit a session');
    $I->amOnPage('/staff_area/sessions/index');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(1)');
    $I->fillField('session_name', 'Session2');
    $I->click('submit_session');

    $I->see('Success');
    $I->see('Test_Session_2');
    $I->seeRecord('sessions', array('session_name' => 'Session2'));
  }

  public function EditSessionWithBlankField(FunctionalTester $I)
  {
    $I->wantTo('Try to add a session with a blank name');
    $I->amOnPage('/staff_area/sessions/index');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(1)');
    $I->fillField('session_name', '');
    $I->click('submit_session');

    $I->dontSee('Success');
    $I->dontSee('Test_Session_2');
  }

  public function deleteSession(FunctionalTester $I)
  {
    $I->wantTo('Delete a session and say Yes');
    $I->amOnPage('/staff_area/sessions/index');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(2)');
    $I->click('Yes');

    $I->see('Success');
    $I->dontSee('Session1');
    $I->dontSeeRecord('sessions', array('session_name' => 'Session111'));
  }

  public function deleteSessionAndPressNo(FunctionalTester $I)
  {
    $I->wantTo('Delete a session and say No');
    $I->amOnPage('/staff_area/sessions/index');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(2)');
    $I->click('No');

    $I->dontSee('Success');
    $I->See('Session1', 'table');
  }

  public function generateCustomLink(FunctionalTester $I)
  {
    $I->wantTo('Generate a custom link for a session');
    $I->amOnPage('/staff_area/sessions/index');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(3)');

    $I->See('Custom Link');
    $I->See('/id=1');
  }

  public function viewSessionAllocations(FunctionalTester $I)
  {
    $I->wantTo('View allocations of a session');
    $I->amOnPage('/staff_area/sessions/index');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div.container-fluid.pb-5 > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(4)');

    $I->see('Matches for');
    $I->seeInCurrentUrl('/staff_area/allocations/');;
  }
}
?>
