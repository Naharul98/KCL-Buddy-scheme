<?php
class HomeViewCest {

    public function testHomePage(AcceptanceTester $I){
        $I->amOnPage('/');
        $I->wantTo('see if home page contains neccessary steps to follow to be matched a buddy');

        $I->see('KCL Buddy Scheme');
        $I->see('Step 1: Register');
        $I->see('Step 2: Complete you profile');
        $I->see('Step 3: Recieve your allocations');
    }


}


?>
