<?php
use \Codeception\Step\Argument\PasswordArgument;
use \Codeception\Util\Locator;

class FooterCest
{
    public function noLoginFooter(AcceptanceTester $I){
        $I->wantTo('Test footer appears and works for non logged in users');
        $I->amOnPage('/');

        $I->see('Address');
        $I->see('Email');
        $I->seeLink('K1764014@kcl.ac.uk', 'mailto:#');
        $I->see('Phone');
        $I->seeLink('+4407518850169', 'tel:#');
        $I->see('Links');
        $I->seeLink('Home', '/');
        $I->seeLink('Learn More', '/learn_more');

        $I->dontSee('Dashboard', 'section-footer');
        $I->dontSee('Sessions', 'section-footer');
        $I->dontSee('Interest Choices', 'section-footer');
        $I->dontSee('Feedback', 'section-footer');

        $I->click('Home', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/');

        $I->click('Learn More', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/learn_more');
      }

    public function studentFooter(AcceptanceTester $I){
        $I->wantTo('Test footer appears and works for logged in students');
        $I->amOnPage('/login');
        $I->fillField('email', 'test.student@kcl.ac.uk');
        $I->fillField('password', new PasswordArgument('password'));
        $I->click(['class' => 'btn']);

        $I->see('Email');
        $I->seeLink('K1764014@kcl.ac.uk', 'mailto:#');
        $I->see('Phone');
        $I->seeLink('+4407518850169', 'tel:#');
        $I->see('Links');
        $I->seeLink('Dashboard', '/user_area/index');

        $I->dontSee('Home', 'section-footer');
        $I->dontSee('Learn More', 'section-footer');
        $I->dontSee('Sessions', 'section-footer');
        $I->dontSee('Interest Choices', 'section-footer');
        $I->dontSee('Feedback', 'section-footer');

        $I->click('Dashboard', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/user_area/index');
    }

    public function adminFooter(AcceptanceTester $I){
        $I->wantTo('Test footer appears and works for logged in admins');
        $I->amOnPage('/login');
        $I->fillField('email', 'adam@admin.com');
        $I->fillField('password', new PasswordArgument('password'));
        $I->click(['class' => 'btn']);

        $I->see('Email');
        $I->seeLink('K1764014@kcl.ac.uk', 'mailto:#');
        $I->see('Phone');
        $I->seeLink('+4407518850169', 'tel:#');
        $I->see('Links');
        $I->seeLink('Sessions', '/staff_area/sessions/index');
        $I->seeLink('Interest Choices', '/staff_area/interests/index');
        $I->seeLink('Feedback', '/staff_area/feedback');

        $I->dontSee('Home', 'section-footer');
        $I->dontSee('Learn More', 'section-footer');

        $I->click('Sessions', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/staff_area/sessions/index');

        $I->click('Interest Choices', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/staff_area/interests/index');

        $I->click('Feedback', Locator::elementAt('footer', 1));
        $I->seeCurrentUrlEquals('/staff_area/feedback');
    }

}


?>
