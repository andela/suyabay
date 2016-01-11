<?php

use Suyabay\User;
use Suyabay\Password_reset;

class NewPasswordTest extends TestCase
{
    use Suyabay\Tests\CreateData;
    /**
     * testTokenIsRecieved
     * visit password reset page with token
     * fill in new password form
     * press reset
     * redirect to signin page and search for "sign in" on the page
     */
    public function testTokenIsSet()
    {
        $this->createUser();
        $this->createPasswordResetUser();
        $user = Password_reset::whereEmail('test@test.com')->first();
        echo "water";
        var_dump($user->token);

        // $this->visit('/passwordreset/{ $user->token }')
        //      ->see('Enter your new password')
        //      ->type('test@test.com', 'email')
        //      ->type('password', 'password')
        //      ->type('confirm_password', 'password')
        //      ->press('Reset')
        //      ->see('sign in');
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
