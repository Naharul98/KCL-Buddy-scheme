<?php


class UserAccessSecurityCest
{
    public function testUserCannotAccessStudentArea(FunctionalTester $I){
        $I->wantTo('Test that an an unauthenticated user does not have access to student area');
        $I->amOnPage('/user_area/index');
        // test that user is redirected to login page
        $I->see('Login');
        $I->dontSeeCurrentUrlEquals('/user_area/index');
    }

    public function testUserCannotAccessAdminAreaDashboard(FunctionalTester $I){
        $I->wantTo('Test that an an unauthenticated user does not have access to admin dashboard');
        $I->amOnPage('/staff_area/interests/index');
        // test that user is redirected to login page
        $I->see('Login');
        $I->dontSeeCurrentUrlEquals('/staff_area/interests/index');
    }

    public function testUserCannotAccessAdminAreaInterestPage(FunctionalTester $I){
        $I->wantTo('Test that an an unauthenticated user does not have access to admin interest index page');
        $I->amOnPage('/user_area/index');
        // test that user is redirected to login page
        $I->see('Login');
        $I->dontSeeCurrentUrlEquals('/user_area/index');
    }

    public function testUserCannotAccessAdminAreaSessionPage(FunctionalTester $I){
        $I->wantTo('Test that an an unauthenticated user does not have access to admin session index page');
        $I->amOnPage('/staff_area/sessions/index');
        // test that user is redirected to login page
        $I->see('Login');
        $I->dontSeeCurrentUrlEquals('/staff_area/sessions/index');
    }

    public function testUserCannotAccessSuperAdminArea(FunctionalTester $I){
        $I->wantTo('Test that an an unauthenticated user does not have access to super admin admin index page');
        $I->amOnPage('/staff_area/sessions/index');
        // test that user is redirected to login page
        $I->see('Login');
        $I->dontSeeCurrentUrlEquals('/staff_area/admin');
    }
}
?>
