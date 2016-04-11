<?php

use Suyabay\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelsEndpointTest extends TestCase
{
    public function testThatNothingWasReturnOnGetAllUsers()
    {
        $this->get('http://suyabay.app/api/v1/users')
        ->seeJson()
        ->seeStatusCode(404);
    }

    public function testGetAllUsers()
    {
        $users = factory('Suyabay\User', 5)->create();
        $this->get('http://suyabay.app/api/v1/users')
        ->seeJson()
        ->seeStatusCode(200);
    }

    public function testGetASingleUser()
    {
        $channel = factory('Suyabay\User')->create([
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
}