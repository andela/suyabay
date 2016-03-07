<?php

use Suyabay\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegistrationAndLoginTest extends TestCase
{
    use Suyabay\Tests\CreateData;

    /**
     * Test for creating a user
     */
    public function testForCreatingOneUser()
    {
        $this->createUser(1);
        $user = User::all();
        $this->assertEquals(1, sizeof($user));
    }

    /**
     * Test Login found user record
     */
    public function testLoginFoundOneRecord()
    {
        $this->createUser(1);
        $user = Auth::attempt(['username' => 'test', 'password' => 'test']);
        $this->assertEquals(1, sizeof($user));
    }

    /**
     * Assert that an admin user can see all users on /dashboard/users page.
     *
     * @return void
     */
    public function testAdminCanGetAllUsers()
    {
        $this->WithoutMiddleware();

        $admin = factory('Suyabay\User')->create(['role_id' => 3]);
        $users = factory('Suyabay\User', 2)->create();

        $this->actingAs($admin)
             ->call(
                 'GET',
                 '/dashboard/users'
             );
        $this->assertViewHas('users');
        $this->see($users->toArray()[0]['username']);
        $this->assertEquals($users->toArray()[0]['username'], self::$userRepository->getAllUsers()->toArray()[1]['username']);
    }

    public function testAdminCanEditUserProfile()
    {
        $this->WithoutMiddleware();

        $admin = factory('Suyabay\User')->create(['role_id' => 3]);
        $users = factory('Suyabay\User', 3)->create();

        $this->actingAs($admin)
             ->call(
                 'GET',
                 '/dashboard/users'
             );
        $this->assertViewHas('users');
        $this->call(
            'GET',
            '/dashboard/user/1/edit'
        );
        $this->assertViewHasALL(['users', 'roles']);

        $x = $this->call(
            'PUT',
            '/dashboard/user/edit',
            [
                'user_id' => 1,
                'user_role' => 3,
                'username' => 'NewUserName'
            ]
        );
        $this->assertEquals('NewUserName', self::$userRepository->findUser(1)['username']);
    }
}
