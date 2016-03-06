<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suyabay\User;
use Suyabay\Channel;
use Suyabay\Episode;
use Suyabay\Comment;

class CommentsUpdateTest extends TestCase
{
    use Suyabay\Tests\CreateData;

    /**
     * Assert that a HTTP PUT request for a comment update to the
     *
     * URL /comments/{id} with a comment value updates the comments field on the
     *
     * comment row with the new comments
     *
     * @return void
     */
    public function testCommentEdited()
    {
        factory(Channel::class)->create();
        factory(Episode::class)->create(['episode_name' => 'Nyama Choma']);
        $comment = factory(Comment::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/episodes/1')
             ->see($comment->comments);

        $this->call(
            'PUT',
            '/comment/' . $comment->id . '/edit',
            [
                'comment' => 'An awesome new comment',
                '_token' => csrf_token()
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
        factory(Channel::class)->create();
        factory(Episode::class)->create(['episode_name' => 'Nyama Choma']);
        $comment = factory(Comment::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user)
             ->visit('/episodes/1')
             ->see($comment->comments);

        $this->call(
            'DELETE',
            '/comment/' .  $comment->id,
            [
                '_token' => csrf_token()
            ]
        );

        $this->assertEquals(0, count(Suyabay\Comment::find($comment->id)));
    }
}
