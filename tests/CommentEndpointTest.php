<?php

use Suyabay\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentEnpointTest extends TestCase
{
    use Suyabay\Tests\CreateData;

    public function testThatEpisodeDoesNotExist()
    {
        $this->get('/api/v1/Episodes/ogaboss/comments')
        ->seeJson()
        ->seeStatusCode(404);
    }

    public function testThatCommentNotAvailableForEpisode()
    {
    	factory('Suyabay\User')->create([
	        'episode_name'          => 'ogaboss',
	        'episode_description'   => '',
	        'view_count'            => 10,
	        'image'                 => "http://goo.gl/8sorZR",
	        'audio_mp3'             => "http://goo.gl/LkNP5M",
	        'channel_id'            => 1,
	        'status'                => 0,
	        'likes'                 => 10,
        ]);
    }

    public function testGetAllComment()
    {
        
    }
}