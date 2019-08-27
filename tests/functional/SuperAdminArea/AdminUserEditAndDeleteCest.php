<?php
use \Codeception\Step\Argument\PasswordArgument;

class AdminUserEditAndDeleteCest
{
  public function _before(FunctionalTester $I)
  {
    $I->amOnPage('/login');
    $I->fillField('email', 'rob@swire.com');
    $I->fillField('password', new PasswordArgument('123456'));
    $I->click(['class' => 'btn']);
    $I->amOnPage('/staff_area/admin');
  }

  public function testSelectNoInAdminDeleteConfirmation(FunctionalTester $I)
  { 
    $I->wantTo('Select no during admin delete confirmation');
    $I->amOnPage('/staff_area/admin/delete/2852');
    $I->see('Are you sure you want to delete the following admin');
    $I->click('No');
    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->seeRecord('users', array('name' => 'rob2', 'email' => 'rob2@swire.com'));

  }

  public function testDeleteAdmin(FunctionalTester $I)
  { 
    $I->wantTo('Delete an admin');
    $I->amOnPage('/staff_area/admin/delete/2852');
    $I->see('Are you sure you want to delete the following admin');
    $I->click('Yes');
    $I->see('Admin has been successfully deleted');
    $I->dontSeeRecord('users', array('name' => 'rob2', 'email' => 'rob2@swire.com'));
  }

  public function testEditAdminBlankNameFormSubmission(FunctionalTester $I)
  {
    $I->wantTo('Edit an admin and submit incomplete');
    $I->amOnPage('/staff_area/admin/update/2852');
    $I->see('Edit');
    
    $I->fillField('name', '');
    $I->click('Update');
    $I->canSeeInCurrentUrl('/staff_area/admin/update');
  }

  public function testEditAdminBlankEmailFormSubmission(FunctionalTester $I)
  {
    $I->wantTo('Edit an admin and submit incomplete');
    $I->amOnPage('/staff_area/admin/update/2852');
    $I->see('Edit');
    
    $I->fillField('email', '');
    $I->click('Update');
    $I->canSeeInCurrentUrl('/staff_area/admin/update');
  }

  public function testEditFormSubmissionSuccess(FunctionalTester $I)
  {
    $I->wantTo('Edit an admin (to super-admin) and submit the form');
    $I->amOnPage('/staff_area/admin/update/2852');
    $I->see('Edit');
    $I->see('In charge of');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('role', 'Super Admin');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Admin has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('super_admin', 'table');

    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com', 'role' => 'super_admin'));
  }
  
  public function testEditRoleSubmissionSuccess(FunctionalTester $I)
  {
    $I->wantTo('Edit admin sessions and submit the form');
    $I->amOnPage('/staff_area/admin/update/2852');
    $I->see('Edit');
    $I->see('In charge of');
    
    $I->fillField('name', 'NewName');
    $I->fillField('email', 'emailtest@emailtest.com');
    $I->selectOption('role', 'Admin');
    $I->selectOption('session_choices[]', '1');
    $I->click('Update');

    $I->canSeeInCurrentUrl('/staff_area/admin');
    $I->see('Admin has been successfully updated');
    $I->see('NewName', 'table');
    $I->see('emailtest@emailtest.com', 'table');
    $I->see('admin', 'table');
    
    $I->seeRecord('admin_sessions', array('user_id' => 2852, 'session_id' => '1'));
    $I->seeRecord('users', array('name' => 'NewName', 'email' => 'emailtest@emailtest.com', 'role' => 'admin'));
  }

}
?>
