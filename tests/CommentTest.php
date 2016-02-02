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

        $this->visit('/episodes/1')
             ->see('Only logged in users can comment.');
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
