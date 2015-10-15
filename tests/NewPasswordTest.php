<?php

use Suyabay\User;

class NewPasswordTest extends TestCase
{

    /**
     * testTokenIsRecieved
     * visit password reset page with token
     * fill in new password form
     * press reset
     * redirect to signin page and search for "sign in" on the page
     *
     * @expectedException InvalidArgumentException
     */
    public function testTokenIsSet()
    {
        $user = User::whereEmail('ibonly01@gmail.com')->first();

        $this->visit('/password/reset/{ $user->token }')
             ->see('Enter your new password')
             ->type('ibonly01@gmail.com', 'email')
             ->type('password', 'password')
             ->type('confirm_password', 'password')
             ->press('Reset')
             ->see('sign in');
    }

    /**
     * testPasswordDoesNotMatch
     *
     * @expectedException InvalidArgumentException
     */
    public function testPasswordDoesNotMatch()
    {
        $user = User::whereEmail('ibonly01@gmail.com')->first();

        $this->visit('/password/reset/{ $user->token }')
             ->see('Enter your new password')
             ->type('ibonly01@gmail.com', 'email')
             ->type('password', 'password')
             ->type('confirm_password', 'password1')
             ->press('Reset');
    }
}
