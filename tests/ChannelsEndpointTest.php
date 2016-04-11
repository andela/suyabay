<?php

use Suyabay\Channel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelsEndpointTest extends TestCase
{
    public function testThatNothingWasReturnOnGetAllChannels()
    {
        $this->get('http://suyabay.app/api/v1/channels')
        ->seeJson();

    }

    public function testGetAllChannels()
    {
        $channel = factory('Suyabay\Channel', 5)->create();
        $this->get('http://suyabay.app/api/v1/channels')
        ->seeJson();
    }

    public function testGetASingleChannel()
    {
        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Prosper Otemuyiwa',
            'channel_description' => 'Laoriosam volup atum nesciunt beatae dolorem neque ut fuga est.',
            'user_id' => 1,
            'subscription_count'  => 10,
        ]);
        
        $this->get('/api/v1/channels/Prosper Otemuyiwa')
        ->seeJson();

    }
}