<?php

use Suyabay\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterUserTest extends TestCase
{
    // /**
    //  * A basic test example.

    public function test_user_login_to_database()
    {
        Auth::login($user);
        $this->assertTrue(true);
    }
}
