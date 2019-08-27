<?php
use \Codeception\Step\Argument\PasswordArgument;

class AdminInterestCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'rob@swire.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
  }

  public function successfullyDeleteInterest(FunctionalTester $I)
  {
    $I->wantTo('Delete an interest');
    $testInterest = '1';

    $deleteURL = "/staff_area/interests/delete/";
    $deleteURL .= $testInterest;
    $I->amOnPage($deleteURL);
    $I->see('Are you sure');
    $I->click('Yes');

    $I->seeCurrentUrlEquals('/staff_area/interests/index');
    $I->dontSeeRecord('interest', array('interest_id' => '1'));
    $I->see('deleted');
    $I->dontSee('Test Interest', 'table');
  }

  public function successfullyAddInterest(FunctionalTester $I)
  {
    $I->wantTo('Add and do not delete a visible interest');
    $I->click('Add New Choice');
    $I->fillField('interest_name', 'Test Interest');
    $I->click('Create');

    $I->see('Success');
    $I->see('Test Interest', 'table');

    $I->seeRecord('interest', array('interest_name' => 'Test Interest'));

  }

  public function successfullyEditInterest(FunctionalTester $I)
  {
    $I->wantTo('Edit an interest');
    $I->haveRecord('interest', array('interest_name' => 'testinterest'));

    $testInterest = '1';
    $editURL = "/staff_area/interests/update/";
    $editURL .= $testInterest;
    $I->amOnPage($editURL);

    $I->fillField('interest_name', 'edittest');
    $I->click('Update');
    $I->seeCurrentUrlEquals('/staff_area/interests/index');
    $I->see('Updated');
    $I->seeRecord('interest', array('interest_name' => 'edittest'));
    $I->dontSeeRecord('interest', array('interest_name' => 'Interest1'));
  }

  public function failDeleteInterest(FunctionalTester $I)
  {
    $I->wantTo('Delete a non-existent interest');
    $I->dontSeeRecord('interest', array('interest_id' => -1));
    $I->amOnPage("/staff_area/interests/delete/-1");

    $I->see('Error');
  }

}
?>
