<?php
use \Codeception\Step\Argument\PasswordArgument;
use \Codeception\Util\Locator;

class AllocationsCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'rob@swire.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
  }

  public function testAllocationsView(FunctionalTester $I)
  {
    $I->wantTo('Test allocations view for a session');
    $I->amOnPage('/staff_area/allocations/10');
    $I->see('Matches for AllocationsTest');
    $I->see('Unallocated Juniors');
    $I->see('Allocated Juniors');
    $I->see('Junior Name');
    $I->see('Senior Name');
    $I->see('Finalized');
  }
  
  
}


?>
