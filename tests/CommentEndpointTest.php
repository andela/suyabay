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

        $response       = $this->actingAs($user)->call('GET', '/api/v1/episodes/ogabos/comments');
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
        $this->assertTrue(is_array($decodeResponse->data));

        $this->get('/api/v1/episodes/ogaboss/comments')
            ->seeJson()
            ->seeStatusCode(200);
    }

    /**
     * Test that a user gets all the comments available 
     * if query is passed.
     *
     * @return void
     */
    public function testdisplayCommentsByDate()
    {
        $user = factory('Suyabay\User')->create();

        $this->createEpisode();
        $this->createComment();

        $response = $this->actingAs($user)->call('GET', '/api/v1/episodes/ogaboss/comments');
        
        $decodeResponse = json_decode($response->getContent());
        $array          = $decodeResponse->data;
        $dataNumber     = count($array['0']->comment->data);
        
        $this->assertEquals($dataNumber, 2);
        $this->get('/api/v1/episodes/ogaboss/comments?fromDate=2016-05-10&toDate=2016-05-18&limit=2')
            ->seeJson()
            ->seeStatusCode(200);
    }

    /**
     * Test that episode does not exist when a user try to
     * access an endpoint passing an invalid comment id.
     *
     * @return void
     */
    public function testEpisodeDoesNotExistForTheSuppledCommentID()
    {
        $user = factory('Suyabay\User')->create();

        $this->createEpisode();

        $response       = $this->actingAs($user)->call('GET', '/api/v1/episodes/ogaboss/comments/1/commenter');
        $decodeResponse = json_decode($response->getContent());

        $this->assertEquals($decodeResponse->message, 'Comment not available for this episode, try another id');
        $this->assertEquals($response->status(), 404);   
    }

    /**
     * Test that episode does not exist when a user try to
     * access an endpoint passing an invalid comment id.
     *
     * @return void
     */
    public function testGetEpisodeCommenter()
    {
        $user = $this->createUser();

        $this->createEpisode();
        $this->createComment();

        $response       = $this->actingAs($user)->call('GET', '/api/v1/episodes/ogaboss/comments/1/commenter');
        $decodeResponse = json_decode($response->getContent());

        $this->assertEquals($decodeResponse->data->username, 'unicodeveloper');
        $this->assertEquals($decodeResponse->data->email, 'unicodeveloper@andela.com');
        $this->assertEquals($response->status(), 200);   
    }

    /**
     * Test that user does not exist
     *
     * @return void
     */
    Public function testUserDoesNotExist()
    {       
        $user = $this->createUser();

        $response       = $this->actingAs($user)->call('GET', '/api/v1/users/unicodev/comments');
        $decodeResponse = json_decode($response->getContent());

        $this->assertEquals($decodeResponse->message, 'This user does not exist');
        $this->assertEquals($response->status(), 404); 
    }

    /**
     * Test that their are no comment available for 
     * the user
     *
     * @return void
     */
    public function testThatCommentIsNotAvailableForUser()
    {
        $user = $this->createUser();

        $response       = $this->actingAs($user)->call('GET', '/api/v1/users/unicodeveloper/comments');
        $decodeResponse = json_decode($response->getContent());

        $this->assertEquals($decodeResponse->message, 'Comment not available for this user');
        $this->assertEquals($response->status(), 404);
    }

    /**
     * Test that comments are available 
     * in for the user.
     *
     * @return void
     */
    public function testgetUserComments()
    {
        $user = $this->createUser();

        $this->createComment();

        $response       = $this->call('GET', '/api/v1/users/unicodeveloper/comments');
        $decodeResponse = json_decode($response->getContent());
        $array          = $decodeResponse->data;
        $dataNumber     = count($array->comment->data);

        $this->assertEquals($dataNumber, 2);
        $this->get('/api/v1/users/unicodeveloper/comments')
            ->seeJson()
            ->seeStatusCode(200);
    }

    /**
     * Test that a user gets all the comments available 
     * if query is passed.
     *
     * @return void
     */
    public function testdisplayUserCommentsByDate()
    {
        $user = $this->createUser();

        $this->createComment();

        $response       = $this->actingAs($user)->call('GET', '/api/v1/users/unicodeveloper/comments');
        $decodeResponse = json_decode($response->getContent());
        $array          = $decodeResponse->data;
        $dataNumber     = count($array->comment->data);

        $this->assertEquals($dataNumber, 2);
        $this->get('/api/v1/users/unicodeveloper/comments?fromDate=2016-05-10&toDate=2016-05-18&limit=2')
            ->seeJson()
            ->seeStatusCode(200);
    }

    /**
     * A method to create a fake epispode from the factory
     *
     * @return obj
     */
    public function createUser()
    {
        $user = factory('Suyabay\User')->create([
            'username'       => 'unicodeveloper',
            'email'          => 'unicodeveloper@andela.com',
            'password'       => bcrypt(str_random(10)),
            'remember_token' => str_random(10),
            'role_id'        => 1
        ]);

        return $user;
    }

    /**
     * A method to create a fake epispode from the factory
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
     * A method to create a fake comment from the factory
     *
     * @return obj
     */
    public function createComment()
    {
        return factory('Suyabay\Comment', 2)->create([
	        'user_id'       => 1,
	        'comments'      => 'Nice job',
	        'episode_id'    => 1,
        ]);
    }
}
