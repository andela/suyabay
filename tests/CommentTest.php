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
        $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();

        $this->visit('/episodes/1')
             ->see('Only logged in users can comment.');
    }

    /**
     * assert that an authenitcated user can add a new comment to an
     * episode.
     *
     * @return void
     */
    public function testAddNewComment()
    {
        $this->withoutMiddleware();

        $user = factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode')->create(['status' => 1]);
        $this->actingAs($user)
            ->call(
                'POST',
                '/comment',
                [
                    'comment' => 'Swanky new comment',
                    'episode_id' => $episode['id']
                ]
            );
        $this->seeInDatabase('comments', ['comments' => 'Swanky new comment']);
        $this->seeInDatabase('comments', ['episode_id' => $episode['id']]);
        $this->seeInDatabase('comments', ['user_id' => $user['id']]);
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
        $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();
        $comment = $this->createComment();

        $this->assertEquals($comment->user_id, $comment->user->id);
    }
}
