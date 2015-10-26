<?php

use Illuminate\Support\Facades\Facade;

class ResetPasswordEmailTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->password = \Mockery::mock('Illuminate\Auth\Reminders\PasswordBroker');
        Facade::setFacadeApplication([
            'auth.reminder' => $this->password
        ]);
    }
    protected function tearDown()
    {
        \Mockery::close();
        Facade::setFacadeApplication(null);
        Facade::clearResolvedInstances();
    }
    // tests
    public function test_it_sends_password_reset_confirmation_email()
    {
      // Other Assertions

      // Testing for Password::reset()
        $response = \Mockery::mock();
        $this->password->shouldReceive('sendResetLink')
            ->with(\Mockery::on(function(){
                return true;
            }))
            ->andReturn($response);
      // Act
      // Assert
    }
}