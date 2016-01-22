<?php

use Suyabay\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class UpdateProfileTest extends TestCase
{

    public function testUserCanSeeUpdateProfileForm()
    {
        $user = factory('Suyabay\User')->create();
        $this->actingAs($user)
             ->withSession(['username' => 'jeffrey'])
             ->visit('/profile/edit')
             ->seePageIs('/profile/edit');
    }

    public function testUserCanChangeUsername()
    {
        $user = factory('Suyabay\User')->create();
        $this->actingAs($user)
             ->withSession(['username' => 'jeffrey']);
        $this->visit('/profile/edit')
             ->seePageIs('/profile/edit')
             ->see('Update Profile')
             ->type('newname', 'username')
             ->press('update')
             ->seeinDatabase('users', ['username' => 'newname']);
    }


    public function testPhotoCannotBeUploaded()
    {
        $absolutePathToFile = '/public/invalidpath/testpic.jpg';
        $user = factory('Suyabay\User')->create();
        $this->actingAs($user)
             ->withSession(['username' => 'jeffrey'])
             ->visit('/profile/edit')
             ->see('Avatar')
             ->attach($absolutePathToFile, 'avatar')
             ->press('upload')
             ->seePageIs('/profile/edit')
             ->see('Please select an image.');

    }
}
