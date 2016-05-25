<?php

use Suyabay\Episode;
use Suyabay\Comment;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentEndpointTest extends TestCase
{
	/**
     * Test that episode does not exist when a user try to
     * access a route passing unexisting episode name.
     *
     * @return void
     */
    public function testThatEpisodeDoesNotExist()
    {
        $user = factory('Suyabay\User')->create();

        $response = $this->actingAs($user)->call('GET', '/api/v1/episodes/ogabos/comments');
        $decodeResponse = json_decode($response->getContent());
        
        $this->assertEquals($decodeResponse->message, 'Episode does not exist');
        $this->assertEquals($response->status(), 404);   
    }

    /**
     * Test that their are no comment available in an
     * episode a user tries to access.
     *
     * @return void
     */
    public function testThatCommentIsNotAvailableForEpisode()
    {
        $user = factory('Suyabay\User')->create();

        $this->createEpisode();

        $response       = $this->actingAs($user)->call('GET', '/api/v1/episodes/ogaboss/comments');
        $decodeResponse = json_decode($response->getContent());
        $this->assertEquals($decodeResponse->message, 'Comment not available for this episode');
        $this->assertEquals($response->status(), 404);
    }

    /**
     * Test that a user gets all the comments available 
     * in an episode.
     *
     * @return void
     */
    public function testgetEpisodeComments()
    {
        $user = factory('Suyabay\User')->create();

        $this->createEpisode();
        $this->createComment();

        $response       = $this->actingAs($user)->call('GET', '/api/v1/episodes/ogaboss/comments');
        $decodeResponse = json_decode($response->getContent());
        $array          = $decodeResponse->data;
        $this->assertTrue(is_object($decodeResponse->data));

        $this->get('/api/v1/episodes/ogaboss/comments')
            ->seeJson()
            ->seeStatusCode(200);
    }

    /**
     * A methos to create a fake epispode from the factory
     *
     * @return obj
     */
    public function createEpisode()
    {
        return factory('Suyabay\Episode')->create([
	        'episode_name'          => 'ogaboss',
	        'episode_description'   => 'Team lead',
	        'view_count'            => 10,
	        'image'                 => "http://goo.gl/8sorZR",
	        'audio_mp3'             => "http://goo.gl/LkNP5M",
	        'channel_id'            => 1,
	        'status'                => 0,
	        'likes'                 => 10,
        ]);
    }

    /**
     * A methos to create a fake comment from the factory
     *
     * @return obj
     */
    public function createComment()
    {
        return factory('Suyabay\Comment')->create([
	        'user_id'       => 1,
	        'comments'      => 'Nice job',
	        'episode_id'    => 1,
        ]);
    }
}
