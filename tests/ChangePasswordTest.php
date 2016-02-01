<?php

use Suyabay\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class ChangePasswordTest extends TestCase
{

    use Suyabay\Tests\CreateData;


    /*
    * Assert logged in can access password reset form
     */
    public function testChangePasswordRoute()
    {
        $this->login();

        $this->visit('/profile/changepassword')
             ->seePageIs('/profile/changepassword');
    }



    /*
    * Test that a success message is flashed for
    * successful password resets
     */
    public function testPasswordChange()
    {
        $this->login();

        $this->visit('/profile/changepassword')
             ->seePageIs('/profile/changepassword')
             ->type('test', 'old_password')
             ->type('newpassword', 'password')
             ->type('newpassword', 'password_confirmation')
             ->press('Change password')
             ->seePageIs('/profile/changepassword');

    }


    /*
    * Test error is thrown if the old password
    * entered is wrong
     */
    public function testInitialPasswordEnteredIsWrong()
    {
        $this->login();

        $this->visit('/profile/changepassword')
             ->seePageIs('/profile/changepassword')
             ->type('wrongpassword', 'old_password')
             ->type('newpassword', 'password')
             ->type('newpassword', 'password_confirmation')
             ->press('Change password')
             ->see('Old password incorrect');

    }

    /*
    * Test error is thrown for passwords that do not match
     */
    public function testPasswordDoesNotMatch()
    {
        $this->login();

        $this->visit('/profile/changepassword')
             ->seePageIs('/profile/changepassword')
             ->type('password', 'old_password')
             ->type('newpassword', 'password')
             ->type('wrongnewpassword', 'password_confirmation')
             ->press('Change password')
             ->see('The password confirmation does not match.');

    }
}