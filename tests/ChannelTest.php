<?php

use Suyabay\Episode;
use Suyabay\Channel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelTest extends TestCase
{
    /**
     * Test that an episode is created.
     *
     * @return void
     */
    public function testCreateNewEpisode()
    {
        Channel::create([
            'channel_name'          => 'test',
            'channel_description'   => 'test',
            'user_id'               => 3,
            'subscription_count'    => 0
        ]);

        $this->seeInDatabase('channels', [
            'channel_name'          => 'test',
            'channel_description'   => 'test',
            'user_id'               => 3,
            'subscription_count'    => 0
        ]);
    }
}
