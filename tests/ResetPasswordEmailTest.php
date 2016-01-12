<?php

use Mockery as M;
use Illuminate\Support\Facades\Facade;

class ResetPasswordEmailTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->password = M::mock('Illuminate\Auth\Reminders\PasswordBroker');
        Facade::setFacadeApplication([
            'auth.reminder' => $this->password
        ]);
    }

    protected function tearDown()
    {
        M::close();
        Facade::setFacadeApplication(null);
        Facade::clearResolvedInstances();
    }

    public function test_it_sends_password_reset_confirmation_email()
    {

        $response = M::mock();
        $this->password->shouldReceive('sendResetLink')->with(M::on(function(){
            return true;
        }))->andReturn($response);
    }
}