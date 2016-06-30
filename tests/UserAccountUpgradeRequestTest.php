<?php

use Suyabay\Channel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAccountUpgradeRequestTest extends TestCase
{
    public function testThatAccountRequestFormWasLoaded()
    {
        $user = factory('Suyabay\User')->create();

        $this->actingAs($user)
        ->visit('/request-premium')
        ->see('Request for a premium account')
        ->see('Email')
        ->see('Reason');
    }

    public function testThatTheUserRequestForAccountUpgradeWasSuccessful()
    {
        $user = factory('Suyabay\User')->create();

        $this->actingAs($user)
        ->visit('/request-premium')
        ->type($user->email, 'email')
        ->type('I want to consume your API', 'reason')
        ->press('send')
        ->see('Your request was submitted, we will get back to you soon!');
    }

    public function testThatTheUserEmailAddressIsInvalid()
    {
        $user = factory('Suyabay\User')->create();

        $this->actingAs($user)
        ->visit('/request-premium')
        ->type('just@email.com', 'email')
        ->type('I want to consume your API', 'reason')
        ->press('send')
        ->see('Email address is invalid!');
    }

    public function testThatTheUserSubmittedTheFormEmpty()
    {
        $user = factory('Suyabay\User')->create();

        $this->actingAs($user)
        ->visit('/request-premium')
        ->type('', 'email')
        ->type('', 'reason')
        ->press('send')
        ->see('The email field is required.')
        ->see('The reason field is required.');
    }

    public function testThatAdminWasAbleToViewTheRequests()
    {
        $user = factory('Suyabay\User')->create([
            'role_id' => 3,
        ]);
        $request = factory('Suyabay\AccountUpgrade')->create(
            [
                'user_id' => $user->id,
                'reason'  => 'Just for testing purpose',
            ]
        );

        $this->actingAs($user)
        ->visit('/dashboard/view-upgrade-request')
        ->see($request->user->username);
    }
}
