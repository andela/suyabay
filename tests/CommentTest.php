<?php

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
    	$this->login();

        $this->visit('/')
        	 ->type('My comment', 'comment')
        	 ->press('submit')
        	 ->seeInDatabase('comments', ['comments' => 'My comment'])
             ->see('{"message":"Comment created Successfully","status_code":200}');
    }

    public function testCommentEpisodeRelationship()
    {
        $this->createUser(1);
        $this->createChannel();
        $episode = $this->createEpisode();
        $comment = $this->createComment();

        $this->assertEquals($comment->episode_id, $comment->episode->id);
    }

    public function testCommentUserRelationship()
    {
        $user = $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();
        $comment = $this->createComment();

        $this->assertEquals($comment->user_id, $comment->user->id);
    }
}
