<?php

use Suyabay\User;
use Suyabay\Http\Repository\UserRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersEndpointTest extends TestCase
{
    public function testThatNothingWasReturnOnGetAllUsers()
    {
        $this->get('/api/v1/users')
        ->seeJson()
        ->seeStatusCode(404);
    }

    public function testGetAllUsers()
    {
        $users = factory('Suyabay\User', 5)->create();
        $this->get('/api/v1/users')
        ->seeJson()
        ->seeStatusCode(200);
    }

    public function testGetASingleUser()
    {
        factory('Suyabay\User')->create([
            'username'       => 'ginger',
            'email'          => 'ginger@laravel.io',
            'password'       => bcrypt(str_random(10)),
            'remember_token' => str_random(10),
            'role_id'        => 1
        ]);

        $this->get('/api/v1/users/ginger')
        ->seeJson()
        ->seeStatusCode(200);
    }

    public function testGetCurrentLoggedInUserInfo()
    {
        $user = factory('Suyabay\User')->create([
            'username'       => 'laztopaz',
            'email'          => 'temitope.olotin@laravel.io',
            'password'       => bcrypt(str_random(10)),
            'remember_token' => str_random(10),
            'role_id'        => 1
        ]);

        $user = UserRepository::findUser($user['id'])->toArray();
        $this->assertTrue(is_array($user));
        $this->assertArrayHasKey('id', $user);
        $this->assertArrayHasKey('role_id', $user);
        $this->assertArrayHasKey('username', $user);

        $this->get('/api/v1/users/me')
        ->seeJson()
        ->seeStatusCode(200);
    }
}