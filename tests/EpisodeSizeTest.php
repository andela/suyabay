<?php

use Suyabay\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateProfileTest extends TestCase
{

    use Suyabay\Tests\CreateData;

    /*
    * Assert user can see the update profile form after a successful login
     */
    public function testUserCanSeeUpdateProfileForm()
    {
        $this->login();

        $this->visit('/profile/edit')
             ->seePageIs('/profile/edit');
    }
}
