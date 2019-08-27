<?php


class AdminAccessSecurityCest
{

  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'adam@admin.com');
    $I->fillField('password', 'password');
    $I->click(['class' => 'btn']);
  }

  public function testAdminCannotAccessSuperAdminArea(FunctionalTester $I)
  {
    $I->wantTo('Test that an an unauthenticated admin does not have access to super admin admin index page');
    $I->amOnPage('/staff_area/admin');
    $I->see('403');
  }

}
?>
