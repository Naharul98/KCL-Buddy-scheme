<?php
use \Codeception\Step\Argument\PasswordArgument;
use Codeception\Util\Locator;

class MatchmakingAlgoCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'adam@admin.com');
    $I->fillField('password', new PasswordArgument('password'));
    $I->click(['class' => 'btn']);
  }

  public function testMatchmakingAlgoSuccessView(FunctionalTester $I)
  {
    $I->wantTo('Test matching algo matches students correctly');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->see('Unallocated Juniors');
    $I->see('Allocated Matches');
    $I->click('Run Automated Matchmaking');

    $I->see('Success');
  }

  public function testCaseWhenJuniorCantBeAllocatedBecauseOfLowNumberOfSenior(FunctionalTester $I)
  {
    $I->wantTo('Test When Junior Cant Be Allocated because not enough Senior');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');

    $I->see('Success');
    $I->dontSeeRecord('matches', array('junior_id' => '379'));
  }

  public function testJuniorAllocatedWithSeniorWithWhichAllInterestsMatchWithoutConstraints(FunctionalTester $I)
  {
    $I->wantTo('Test Junior Allocated With Senior With Which All Interests Match Without Constraints');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');

    $I->see('Success');
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '375'));
  }

  public function testWhenJuniorAllocationHasChoiceBetweenTwoSeniorTheSeniorWithMostNumberOfCommonInterestIsAllocated(FunctionalTester $I)
  {
    $I->wantTo('Test When Junior Cant Be Allocated because not enough Senior');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');

    $I->see('Success');
    $I->seeRecord('matches', array('senior_id' => 1343, 'junior_id' => '376'));
  }

  public function testJuniorWithSameSexAllocationPreferenceMatchedWithSeniorOfSameSex(FunctionalTester $I)
  {
    $I->wantTo('Test Junior With Same Gender Allocation Preference is correctly matched with a senior of same gender with maximum possible interests choices in common');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');

    $I->see('Success');
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '377'));
  }

  public function testStudentWithSpecialNeedsIsAllocatedAMatchDespiteDisproportionate(FunctionalTester $I)
  {
    $I->wantTo('Test Student With Special Needs Is Allocated A Match Despite Disproportionate number of juniors and seniors');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');

    $I->see('Success');
    $I->seeRecord('matches', array('senior_id' => 1344, 'junior_id' => '378'));
  }

  public function testWhenDisproportionateNumberOfSeniorAndJuniorStudentLeastCompatibleWithAnyoneElseIsChosenToBeLeftOutInMatchmaking(FunctionalTester $I)
  {
    $I->wantTo('Test When Disproportionate Number Of Senior And Junior, Student Least Compatible With Anyone Else Is Chosen To Be Left Out In Matchmaking');
    $I->amOnPage('/staff_area/allocations/386');
    $I->see('Matchmaking Test Session');
    $I->click('Run Automated Matchmaking');

    $I->see('Success');
    $I->dontSeeRecord('matches', array('junior_id' => '379'));
  }

}
?>
