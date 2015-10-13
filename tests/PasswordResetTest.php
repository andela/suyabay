<?php


class PasswordResetTest extends TestCase
{
    public function testSeePasswordResetPage()
    {
        $this->visit('/')
             ->click('Sign in')
             ->seePageIs('/signin')
             ->click('Forgot password?')
             ->seePageIs('/passwordreset');
    }

    public function testPasswordResetInput()
    {
        $this->visit('/passwordreset')
             ->type('ibonly@yahoo.com', 'email')
             ->press('Reset');
    }

}
