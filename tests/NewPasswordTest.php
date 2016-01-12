<?php

use Suyabay\User;
use Suyabay\Password_reset;

class NewPasswordTest extends TestCase
{
    use Suyabay\Tests\CreateData;

    public function resetData()
    {
        $this->createUser();
        $this->createPasswordResetUser();
        $user = Password_reset::whereEmail('test@test.com')->first();

        return $user;
    }
    /**
     * testTokenIsRecieved
     * visit password reset page with token
     * fill in new password form
     * press reset
     * redirect to signin page and search for "sign in" on the page
     */
    public function testTokenIsSet()
    {
        $user = $this->resetData();

        $this->visit('/password/reset/12345')
             ->see('Enter your new password')
             ->type('test@test.com', 'email')
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
        $this->resetData();

        $this->visit('/password/reset/12345')
             ->see('Enter your new password')
             ->type('ibonly01@gmail.com', 'email')
             ->type('password', 'password')
             ->type('confirm_password', 'password1')
             ->press('Reset');
    }
}
