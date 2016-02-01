<?php

use Suyabay\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegistrationAndLoginTest extends TestCase
{   
    use Suyabay\Tests\CreateData;

    /**
     * Test for creating a user
     */
    public function testForCreatingOneUser()
    {
        $this->createUser(1);
        $user = User::all();
        $this->assertEquals(1, sizeof($user));
    }

    /**
     * Test Login found user record
     */
    public function testLoginFoundOneRecord()
    {
        $this->createUser(1);
        $user = Auth::attempt(['username' => 'test', 'password' => 'test']);
        $this->assertEquals(1, sizeof($user));
    }
}
