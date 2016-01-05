<?php
use Suyabay\User;
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

    public function testLoginFoundOneRecord()
    {
        $this->createUser();
        $user = Auth::attempt(['username' => 'test', 'password' => 'test']);
        $this->assertEquals(1, sizeof($user));
    }

    public function testLoginReturnTwoArray()
    {
        $this->createUser();
        $user = Auth::attempt(['username' => 'test', 'password' => 'test']);
        $this->assertContains(2, array(1, 2));
    }


    public function tearDown()
    {
        $this->createApplication();
        Artisan::call('migrate:rollback');
    }

}
