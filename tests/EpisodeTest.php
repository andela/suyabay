<?php

use Suyabay\Episode;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EpisodeTest extends TestCase
{
    /**
     * Test that an episode is created.
     *
     * @return void
     */
    public function testCreateNewEpisode()
    {
        $channel = factory('Suyabay\Channel')->create();
        Episode::create([
            'episode_name'          => 'test',
            'episode_description'   => 'test',
            'channel_id'            => $channel->id,
            'view_count'            => 0,
            'image'                 => 'dummy url',
            'audio_mp3'             => 'dummy url',
            'status'                => 0
        ]);

        $this->seeInDatabase('episodes', [
            'episode_name'          => 'test',
            'episode_description'   => 'test',
            'channel_id'            => $channel->id,
            'view_count'            => 0,
            'image'                 => 'dummy url',
            'audio_mp3'             => 'dummy url',
            'status'                => 0
        ]);
    }

}
