<?php

class PasswordResetTest extends TestCase
{
    /**
     * testSeePasswordResetPage
     * visit homepage
     * click sign in
     * click forgot password
     */
    public function testSeePasswordResetPage()
    {
        $this->visit('/')
             ->click('SIGN IN')
             ->seePageIs('/login')
             ->click('Forgot password?')
             ->seePageIs('/passwordreset');
    }

    /**
     * testPasswordResetInput
     * visit passwordreset page
     * enter email address
     * confirm email exist in database
     */
    public function testPasswordResetInput()
    {
        $this->visit('/passwordreset')
             ->type('ibonly01@gmail.com', 'email')
             ->press('Reset')
             ->seeInDatabase('users', ['email' => 'ibonly01@gmail.com']);
    }

}
