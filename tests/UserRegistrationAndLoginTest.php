<?php
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegistrationAndLoginTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->createApplication();
        Artisan::call('migrate:refresh');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    protected function createUser ()
    {
        $user = App\User::create([
            'username' => 'test',
            'password' => 'test',
            'email' => 'test@test.com'
        ]);
        return $user;
    }

    public function testForCreatingOneUser()
    {
        $this->createUser();
        $user = App\User::all();
        $this->assertEquals(1, sizeof($user));
    }

    public function testForUserLogin()
    {
        $this->createUser();
        $user = Auth::attempt(['username' => 'test', 'password' => 'pass']);
        $this->assertEquals(1, sizeof($user));
    }

}
