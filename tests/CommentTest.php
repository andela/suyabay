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
     * Test guest user cannot comment
     */
    public function testGuestUserCannotComment()
    {	
        $user = $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();

        $this->visit('/')
        	 ->see('Only logged in users can comment.');
    }

    /**
     * Test only login user can comment
     */
    public function testOnlyLoggedInUserCanComment()
    {
    	
        $user = $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();
    }
}
