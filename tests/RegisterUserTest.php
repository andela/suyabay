<?php
use App\User;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_to_register_user_in_to_the_database()
    {
        $user = new App\User;
        $user = User::create(['username' => 'test_user', 'password' => 'test_password', 'email' => 'test_email'])->AssertTrue();

    }
    public function test_user_login_to_database()
    {

        Auth::login($user);
        //$user = User::create(['username' => 'test_user', 'password' => 'test_password', 'email' => 'test_email']);
    }
}
