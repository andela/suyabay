<?php

use Auth;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase
{
    use Suyabay\Tests\CreateData;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Test only login user can user
     */
    public function testLoginUserCanComment()
    {	
        $user = $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();

        $user = Auth::login($user);;

        $this->visit('/')
        	 ->see('Channel name')
        	 ->click('clickable_object')
        	 ->see('Enter your comment')
        	 ->type('My new comment', 'comment');
    }


}
