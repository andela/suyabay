<?php

use Suyabay\Channel;
use Suyabay\Http\Repository\ChannelRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelsEndpointTest extends TestCase
{
    public function testThatNothingWasReturnOnGetAllChannels()
    {
        $this->get('/api/v1/channels')
        ->seeJson();
    }

    public function testGetAllChannels()
    {
        $channel = factory('Suyabay\Channel', 5)->create();

        $this->get('/api/v1/channels')
        ->seeJson()
        ->seeStatusCode(200);

    }

    public function testGetASingleChannel()
    {
        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Ginger',
            'channel_description' => 'Laoriosam volup atum nesciunt beatae dolorem neque ut fuga est.',
            'user_id' => 1,
            'subscription_count'  => 10,
        ]);
        
        $channel = ChannelRepository::find($channel['id'])->toArray();

        $this->assertTrue(is_array($channel));
        $this->assertArrayHasKey('user_id', $channel);
        $this->assertArrayHasKey('channel_description', $channel);
        $this->assertArrayHasKey('channel_name', $channel);

        $this->get('/api/v1/channels/Ginger')
        ->seeJson()
        ->seeStatusCode(200);

    }
}