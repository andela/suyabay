<?php

use Suyabay\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends TestCase
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
        $this->assertEquals(
            $users->toArray()[0]['username'],
            self::$userRepository->getAllUsers()->toArray()[1]['username']
        );
    }

    /**
     * Assert that an admin can edit a user profile.
     *
     * @return void
     */
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

        $this->call(
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

    /**
     * Assert that an admin can send an invitation.
     *
     * @return void
     */
    public function testAdminCanCreateInvitation()
    {
        $this->WithoutMiddleware();

        $admin = factory('Suyabay\User')->create(['role_id' => 3]);
        $users = factory('Suyabay\User', 2)->create();

        $this->actingAs($admin)
             ->call(
                 'GET',
                 '/dashboard/user/create'
             );
        $this->assertViewHas('roles');
        $this->see('Send Upgrade Invitation');
    }

    /**
     * Assert that UserRepository's getAllUsers returns all the users.
     * @return void
     */
    public function testgetAllUsersMethod()
    {
        $this->WithoutMiddleware();
        $users = factory('Suyabay\User', 2)->create();
        $getUsers = self::$userRepository->getAllUsers();

        $this->assertTrue(is_array($getUsers->toArray()));
        $this->assertEquals($users[0]['username'], $getUsers[0]['username']);
    }

    /**
     * Assert that UserRepository's findUser returns a single user.
     *
     * @return void
     */
    public function testfindUser()
    {
        $this->WithoutMiddleware();
        $users = factory('Suyabay\User', 2)->create();
        $singleUser = self::$userRepository->findUser(1);

        $this->assertTrue(is_array($singleUser->toArray()));
        $this->assertEquals($users[0]['username'], $singleUser['username']);
    }

    /**
     * Assert that UserRepository's getOnlineUsers returns all online users.
     *
     * @return void
     */
    public function testgetOnlineUsers()
    {
        $user = factory('Suyabay\User', 3)->create(['active' => 1]);

        $onlineUsers = self::$userRepository->getOnlineUsers();
        $this->assertEquals(3, $onlineUsers->count());
    }
    /**
     * Assert that UserRepository's getOfflineUsers returns all offline users.
     *
     * @return void
     */
    public function testgetOfflineUsers()
    {
        $user = factory('Suyabay\User', 3)->create(['active' => 0]);

        $offlineUsers = self::$userRepository->getOfflineUsers();
        $this->assertEquals(3, $offlineUsers->count());
    }

    /**
     * Assert that a user can update their username
     *
     * @return void
     */
    public function testUserCanUpdateUserName()
    {
        $this->login();
        $this->visit('profile/edit')
            ->type('foobar', 'username')
            ->press('update');
        $this->seeInDatabase('users', ['id' => 1, 'username' => 'foobar']);
    }

    /**
     * Test that user can sign up and sign in successfully using social network
     */
    public function testThatUserSignUpUsingOauth()
    {
        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');

        $provider->shouldReceive('redirect')->andReturn('Redirected');

        $providerName  = class_basename($provider);
        $socialAccount = factory('Suyabay\User')->create(['facebookID' => $providerName]);
        $abstractUser  = Mockery::mock('Laravel\Socialite\Two\User');

        $abstractUser->shouldReceive('getId')
            ->andReturn($socialAccount->facebookID)
            ->shouldReceive('getEmail')
            ->andReturn(str_random(10).'@noemail.app')
            ->shouldReceive('getNickname')
            ->andReturn('Oga Boss')
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage/102347280/b3e9c138c1548147b7ff3f9a2a1d9bb0.png?size=200');

        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('facebook')->andReturn($provider);

        $this->visit('authenticate/facebook/callback')
            ->seePageIs('/');
    }
}
