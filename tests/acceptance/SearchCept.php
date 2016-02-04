<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('Make sure search works');

$I->amOnPage('/');
$I->see('Podcast');
$I->fillField('query', 'search terms');
$I->pressKey('#input', WebDriverKeys::ENTER);
$I->see('Results');
