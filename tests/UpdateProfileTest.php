<?php

use Suyabay\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class UpdateProfileTest extends TestCase
{

    use Suyabay\Tests\CreateData;

    /*
    * Assert user can see the update profile form after a successful login
     */
    public function testUserCanSeeUpdateProfileForm()
    {
        $this->login();

        $this->visit('/profile/edit')
             ->seePageIs('/profile/edit');
    }

    /*
    * Assert logged in user can change their username
     */
    public function testUserCanChangeUsername()
    {
        $this->login();

        $this->visit('/profile/edit')
             ->seePageIs('/profile/edit')
             ->see('Update Profile')
             ->type('newname', 'username')
             ->press('update')
             ->seeinDatabase('users', ['username' => 'newname']);
    }

    /*
    * Assert avatar cannot be uploaded if path specified
    * does not exist
     */
    public function testPhotoCannotBeUploaded()
    {
        $absolutePathToFile = '/public/invalidpath/testpic.jpg';

        $this->login();

        $this->visit('/profile/edit')
             ->see('Avatar')
             ->attach($absolutePathToFile, 'avatar')
             ->press('upload')
             ->seePageIs('/profile/edit');
    }
}

