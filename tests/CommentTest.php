<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suyabay\User;
use Suyabay\Channel;
use Suyabay\Episode;
use Suyabay\Comment;

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

    /* Assert that a HTTP PUT request for a comment update to the
     *
     * URL /comments/{id} with a comment value updates the comments field on the
     *
     * comment row with the new comments
     *
     * @return void
     */
    public function testEditComment()
    {
        $user = factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode')->create(['status' => 1]);
        $comment = factory('Suyabay\Comment')->create();

        $this->actingAs($user)
            ->withSession(['show_comments', true])
            ->call(
                'PUT',
                '/comment/1/edit',
                [
                    '_token' => csrf_token(),
                    'comment' => 'An awesome new comment'
                ]
            );

        $this->seeInDatabase('comments', ['comments' => 'An awesome new comment']);
    }

    /**
     * Assert that a HTTP DELETE request for a given comment ID
     *
     * URL /comments/{id} deletes comment with the given id
     *
     *
     * @return void
     */
    public function testCommentDelete()
    {
        $user = factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode')->create(['status' => 1]);
        $comment = factory('Suyabay\Comment')->create();

        $this->actingAs($user)
             ->withSession(['show_comments', true])
             ->call(
                 'DELETE',
                 'comment/1',
                 [
                    '_token' => csrf_token()
                 ]
             );
             $this->visit('/episodes/1')
             ->dontSee($comment['comments']);
    }
    /**
     * test that a Comment belongs to an episode.
     *
     * @return void
     */
    public function testCommentEpisodeRelationship()
    {
        $this->createUser(1);
        $this->createChannel();
        $episode = $this->createEpisode();
        $comment = $this->createComment();

        $this->assertEquals($comment->episode_id, $comment->episode->id);
    }

    /**
     * test the that a comment belongs to a user.
     *
     * @return void
     */
    public function testCommentUserRelationship()
    {
        $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();
        $comment = $this->createComment();

        $this->assertEquals($comment->user_id, $comment->user->id);
    }
}
