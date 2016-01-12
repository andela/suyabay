<?php

namespace Suyabay\Tests;

use Suyabay\User;
use Suyabay\Password_reset;

trait CreateData
{
    protected function createUser ()
    {
        $user = User::create([
            'username' => 'test',
            'password' => 'test',
            'email' => 'test@test.com'
        ]);
        return $user;
    }

    public function createPasswordResetUser()
    {
        return Password_reset::create([
            'email' => 'test@test.com',
            'token' => 12345
            ]);
    }
}