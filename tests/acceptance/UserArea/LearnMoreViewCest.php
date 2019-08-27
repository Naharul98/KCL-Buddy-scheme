<?php
class LearnMoreViewCest {

    public function testLearnMorePage(AcceptanceTester $I){
        $I->amOnPage('/learn_more');
        $I->wantTo('see if learn more page contains neccessary information about the scheme');

        $I->see('About this scheme');
        $I->see('The KCL buddy scheme allows new first year students to be given a mentor who is a more senior KCL student. We hope this will allow new students to learn from the expirience and have a more pleasent expirience when they are just starting out.');

        $I->see('To sign up to the scheme either as a buddy or a senior, simply create an account and complete each item on the checklist provided before the deadline');

        $I->see('FAQs');
        $I->see('What Information do I need to sign up to this scheme?');
        $I->see('What does "verification" involve after I sign up?');
        $I->see('Why do I need to answer questions about my personality and interests?');
    }


}


?>
