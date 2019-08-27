<?php
use \Codeception\Step\Argument\PasswordArgument;
use Codeception\Util\Locator;

class MatchmakingAlgoResetCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'adam@admin.com');
    $I->fillField('password', new PasswordArgument('password'));
    $I->click(['class' => 'btn']);
  }

  public function testMatchmakingAlgoResetAfterRunning(FunctionalTester $I)
  {
    $I->wantTo('test Matchmaking Algo Reset After Running');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->see('Unallocated Juniors');
    $I->see('Allocated Matches');
    $I->click('Run Automated Matchmaking');
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '378'));
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '375'));
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '377'));
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '376'));
    $I->see('Success');
    $I->click('Reset Unfinalized Matches');
    $I->dontSeeRecord('matches', array('senior_id' => 1344, 'junior_id' => '378'));
    $I->dontSeeRecord('matches', array('senior_id' => 1343, 'junior_id' => '375'));
    $I->dontSeeRecord('matches', array('senior_id' => 1344, 'junior_id' => '377'));
    $I->dontSeeRecord('matches', array('senior_id' => 1343, 'junior_id' => '376'));
    $I->dontSeeRecord('matches', array('junior_id' => '379'));
  }

}
?>
