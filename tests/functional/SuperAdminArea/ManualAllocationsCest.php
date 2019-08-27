<?php
use \Codeception\Step\Argument\PasswordArgument;

class ManualAllocationsCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'rob@swire.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
  }

  public function CheckCorrectStudentDetails(FunctionalTester $I)
  {
    $I->wantTo('Check if the details for the first student in session 1 are displayed correctly');
    $I->amOnPage('/staff_area/manual_allocation/13/1');



    $I->see('p');
    $I->see('female');
    $I->see('Interest2');
    $I->see('Interest4');
    $I->see('Interest5');

    $I->see('Eligible Seniors');

  }

  public function TestManualAllocation(FunctionalTester $I)
  {
    $I->wantTo('Check if manually allocating the above student with an eligible senior is successful');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(4)');
    $I->click('#table_container > table > tbody > tr > td:nth-child(2) > a');
    $I->click('#table_container > table > tbody > tr:nth-child(1) > td:nth-child(4) > div > a');


    $I->see('success');
    $I->seeRecord('matches', array('junior_id' => '14','is_finalized' => '0'));
    $I->see('false');
  }

  public function TestManualDeallocation(FunctionalTester $I)
  {
    $I->wantTo('Check if deallocating an exisiting match works as intended');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(4)');
    $I->click('#table_container > table > tbody > tr:nth-child(1) > td:nth-child(4) > a');

    $I->dontSeeRecord('matches', array('junior_id' => '17'));
    $I->see('success');
  }

  public function TestUnallocatedEmail(FunctionalTester $I)
  {
    $I->wantTo('Check if email unallocated button works as expected');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(4)');
    $I->click('#banner > div > div.col-lg-4.text-right > div > button');
    $I->click('#banner > div > div.col-lg-4.text-right > div > div > a:nth-child(4)');

    $I->see('Unallocated students have been informed by email');
  }

  public function TestFinaliseMatches(FunctionalTester $I)
  {
    $I->wantTo('Check if finalize button works as expected');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(4)');
    $I->click('#banner > div > div.col-lg-4.text-right > div > button');
    $I->click('#banner > div > div.col-lg-4.text-right > div > div > a:nth-child(2)');

    $I->see('Matches finalized');
    $I->dontSeeRecord('matches', array('is_finalized' => '0'));
    $I->dontSee('false');
  }

  public function TestRunMatchmaking(FunctionalTester $I)
  {
    $I->wantTo('Check if Run Matchmaking button works as expected');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(4)');
    $I->click('#banner > div > div.col-lg-4.text-right > div > button');
    $I->click('#banner > div > div.col-lg-4.text-right > div > div > a:nth-child(3)');

    $I->see('success');
    $I->seeRecord('matches', array('junior_id' => '14','is_finalized' => '0'));
    $I->see('false');
  }

  public function TestResetFunctionality(FunctionalTester $I)
  {
    $I->wantTo('Check if reset button works as expected');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(4)');
    $I->click('#banner > div > div.col-lg-4.text-right > div > button');
    $I->click('#banner > div > div.col-lg-4.text-right > div > div > a:nth-child(1)');

    $I->see('cleared');
    $I->see('success');
    $I->dontSeeRecord('matches', array('is_finalized' => '0'));
    $I->dontSee('false');
  }

  public function TestBackButton(FunctionalTester $I)
  {
    $I->wantTo('Check if Back button works as expected');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > button');
    $I->click('#app > div > div > table > tbody > tr:nth-child(1) > td:nth-child(3) > div > div > div > a:nth-child(4)');
    $I->click('Go Back');

    $I->see('Session2');
    $I->see('Edit');
    $I->see('Delete');
  }
}
?>
