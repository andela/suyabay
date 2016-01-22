<?php

use Suyabay\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class ChangePasswordTest extends TestCase
{

    public function testChangePasswordRoute()
    {
        $user = factory('Suyabay\User')->create();
        $this->actingAs($user)
             ->withSession(['username' => 'jeffrey']);
        $this->visit('/profile/changepassword')
             ->seePageIs('/profile/changepassword');
    }


    /**
     * [testPasswordChange description]
     * @return [type] [description]
     */
    public function testPasswordChange()
    {
        $user = factory('Suyabay\User')->create();
        $this->actingAs($user)
             ->withSession(['username' => $user->username, 'password' => 'password']);
        $this->visit('/profile/changepassword')
             ->seePageIs('/profile/changepassword')
             ->type('password', 'old_password')
             ->type('newpassword', 'password')
             ->type('newpassword', 'password_confirmation')
             ->press('Change password')
             ->seePageIs('/profile/changepassword');

    }

    public function testInitialPasswordEnteredIsWrong()
    {
        $user = factory('Suyabay\User')->create();
        $this->actingAs($user)
             ->withSession(['username' => $user->username, 'password' => 'password']);
        $this->visit('/profile/changepassword')
             ->seePageIs('/profile/changepassword')
             ->type('wrongpassword', 'old_password')
             ->type('newpassword', 'password')
             ->type('newpassword', 'password_confirmation')
             ->press('Change password')
             ->see('Old password incorrect');

    }

    public function testPasswordDoesNotMatch()
    {
        $user = factory('Suyabay\User')->create();
        $this->actingAs($user)
             ->withSession(['username' => $user->username, 'password' => 'password']);
        $this->visit('/profile/changepassword')
             ->seePageIs('/profile/changepassword')
             ->type('password', 'old_password')
             ->type('newpassword', 'password')
             ->type('wrongnewpassword', 'password_confirmation')
             ->press('Change password')
             ->see('The password confirmation does not match.');

    }
}