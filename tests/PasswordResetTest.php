<?php

class PasswordResetTest extends TestCase
{
    use Suyabay\Tests\CreateData;

    /**
     * testPasswordResetInput
     * visit passwordreset page
     * enter email address
     * confirm email exist in database.
     */
    public function testPasswordResetInput()
    {
        $this->createUser(1);
        $this->visit('/passwordreset')
             ->type('test@test.com', 'email')
             ->press('Reset')
             ->seeInDatabase('users', ['email' => 'test@test.com']);
    }
}
