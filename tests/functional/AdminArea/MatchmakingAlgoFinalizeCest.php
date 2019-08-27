<?php
use \Codeception\Step\Argument\PasswordArgument;
use Codeception\Util\Locator;

class MatchmakingAlgoFinalizeCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'adam@admin.com');
    $I->fillField('password', new PasswordArgument('password'));
    $I->click(['class' => 'btn']);
  }

  public function testFinalizationOfMatchesWork(FunctionalTester $I)
  {
    $I->wantTo('Test Finalization Of Matches Work');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');
    $I->see('Success');
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '378'));
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '375'));
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '377'));
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '376'));

    $I->click('Finalize Matches');
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '378', 'is_finalized' => '1'));
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '375' , 'is_finalized' => '1'));
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '377' , 'is_finalized' => '1'));
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '376' , 'is_finalized' => '1'));

  }

  public function testMatchesAreNotAlreadyFinalizedAfterRunningMatchmakingAlgo(FunctionalTester $I)
  {
    $I->wantTo('Test that matches are not already finalized after running the matchmaking algo');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');
    $I->see('Success');
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '378', 'is_finalized' => '0'));
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '375', 'is_finalized' => '0'));
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '377', 'is_finalized' => '0'));
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '376', 'is_finalized' => '0'));
  }

  public function testFinalizedMatchesCannotBeDeAllocated(FunctionalTester $I)
  {
    $I->wantTo('Test Finalized Matches Cannot be Deallocated');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');
    $I->see('Success');
    $I->see('Deallocate');

    $I->click('Finalize Matches');
    $I->dontSee('Deallocate');
  }

  public function testUnfinalizedMatchesCanBeDeAllocated(FunctionalTester $I)
  {
    $I->wantTo('Test Finalized Matches Can be Deallocated');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');
    $I->see('Success');
    $I->see('Deallocate');
  }

}
?>
