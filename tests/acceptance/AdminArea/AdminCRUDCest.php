<?php
use \Codeception\Step\Argument\PasswordArgument;
class AdminCRUDCest
{
  public function _before(AcceptanceTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'rob@swire.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
  }
  
    // tests
  public function testAdminAddFormView(AcceptanceTester $I)
  {
    $I->wantTo('Test admin add form view');
    $I->click('Add New Admin');
    $I->see('Name');
    $I->see('E-Mail Address');
    $I->see('Password');
    $I->see('Confirm Password');
    $I->see('Privilege');
  }

  
}
?>