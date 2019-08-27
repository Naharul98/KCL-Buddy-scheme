<?php
use \Codeception\Step\Argument\PasswordArgument;

class ProfileCest
{
    public function _before(FunctionalTester $I)
    {
      $I->amOnPage('/register');
      $I->fillField('name', 'John Doe');
      $I->fillField('email', 'profiletest@kcl.ac.uk');
      $I->fillField('password', new PasswordArgument('password'));
      $I->fillField('password_confirmation', new PasswordArgument('password'));
      $I->click('Register', ['class' => 'btn']);
      $I->seeCurrentUrlEquals('/user_area/index');
      $I->click('Sign up for a new session');
      $I->click('Select Session');
      $I->seeCurrentUrlEquals('/user_area/create_profile/1');
    }



    // tests
    public function successfulBuddyProfileUpdate(FunctionalTester $I)
    {
      $I->wantTo("Update profile as a buddy");
      $I->selectOption("student_type", "junior");
      $I->selectOption("gender", "male");
      $I->selectOption("same_gender_preference", "1");
      $I->fillField("profile_description", "Test: Buddy looking for Mentor");
      $I->click('Create Profile');

      $I->seeCurrentUrlEquals('/user_area/index');
      $I->see('Allocation Pending');
      $I->click('Session1');
      $I->click('Update Profile');
      $I->seeOptionIsSelected('student_type', 'junior');
      $I->dontSeeOptionIsSelected('student_type', 'senior');
      $I->see('Test: Buddy looking for Mentor', '//*[@id="profile_textboxes"]');
    }

    public function successfulMentorProfileUpdate(FunctionalTester $I)
    {
      $I->wantTo("Update profile as a mentor");
      $I->selectOption("student_type", "senior");
      $I->selectOption("gender", "male");
      $I->selectOption("same_gender_preference", "1");
      $I->selectOption("max_number_of_buddies", "2");
      $I->fillField("profile_description", "Test: Mentor looking for Buddy");
      $I->click('Create Profile');

      $I->seeCurrentUrlEquals("/user_area/index");
      $I->see('Allocation Pending');
      $I->click('Session1');
      $I->click('Update Profile');
      $I->seeOptionIsSelected('student_type', 'senior');
      $I->dontSeeOptionIsSelected('student_type', 'junior');
      $I->see('Test: Mentor looking for Buddy', '//*[@id="profile_textboxes"]');
    }

    public function successfulAddSpecialNeeds(FunctionalTester $I)
    {
      $I->wantTo("Add special needs to profile");
      $I->selectOption("student_type", "junior");
      $I->selectOption("gender", "male");
      $I->selectOption("same_gender_preference", "1");
      $I->fillField("profile_description", "Special needs test description");
      $I->checkOption('//*[@id="spcialNeedsInput"]');
      $I->fillField('//*[@id="profile_textboxes"]', "Special needs test details");
      $I->click('Create Profile');

      $I->seeCurrentUrlEquals('/user_area/index');
      $I->see('Allocation Pending');
      $I->click('Session1');
      $I->click('Update Profile');
      $I->seeOptionIsSelected('//*[@id="spcialNeedsInput"]', '1');
      $I->see('Special needs test details', '//*[@id="profile_textboxes"]');
    }

    public function addAllInterests(FunctionalTester $I)
    {
      $I->wantTo("Add all interests to my profile");
      $sessionID = '/user_area/create_profile/';
      $sessionID .= '1';
      $I->amOnPage($sessionID);
      $I->selectOption("student_type", "junior");
      $I->selectOption('interest_choices[]', array('Interest1', 'Interest2',
      'Interest4', 'Interest5', 'Interest44',
      'Interest53'));
      $I->selectOption("gender", "male");
      $I->selectOption("same_gender_preference", "1");
      $I->fillField("profile_description", "Test: Buddy looking for Mentor");
      $I->click('Create Profile');

      $I->seeCurrentUrlEquals('/user_area/index');
      $I->see('Allocation Pending');
      $I->click('Session1');
      $I->click('Update Profile');
      $I->seeOptionIsSelected('interest_choices[]', 'Interest1');
    }

    public function completeProfileWithNoInterests(FunctionalTester $I)
    {
      $I->wantTo("Not see any interests when session has none");
      $sessionID = '/user_area/create_profile/';
      $sessionID .= '5';
      $I->amOnPage($sessionID);
      $I->selectOption("student_type", "junior");
      $I->dontSee('Interests');
      $I->selectOption("gender", "male");
      $I->selectOption("same_gender_preference", "1");
      $I->fillField("profile_description", "Test: Buddy looking for Mentor");
      $I->click('Create Profile');

      $I->seeCurrentUrlEquals('/user_area/index');
      $I->see('Allocation Pending');
      $I->click('session5');
      $I->click('Update Profile');
      $I->dontSee('Interests');
    }

}
?>
