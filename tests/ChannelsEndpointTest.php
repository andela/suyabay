<?php

use Suyabay\Channel;
use Suyabay\Http\Repository\ChannelRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelEndpointsTest extends TestCase
{
    public function testThatNothingWasReturnOnGetAllChannels()
    {
        $response = $this->call('GET', '/api/v1/channels');
        $output = json_decode($response->getContent());

        $this->assertEquals($output->message, 'Channels are not available for display');
    }

    public function testGetAllChannels()
    {
        $user = factory('Suyabay\User')->create();
        $channel = factory('Suyabay\Channel', 5)->create();

        $response = $this->call('GET', '/api/v1/channels');
        $channels = json_decode($response->getContent());

        $channels->data[0] = (array) $channels->data[0];
        
        $this->assertTrue(is_array($channels->data[0]));
        $this->assertArrayHasKey('channel_id', $channels->data[0]);
        $this->assertArrayHasKey('channel_note', $channels->data[0]);
        $this->assertArrayHasKey('channel_name', $channels->data[0]);
        
    }

    public function testGetASingleChannel()
    {
        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Ginger',
            'channel_description' => 'Laoriosam volup atum nesciunt beatae dolorem neque ut fuga est',
            'user_id' => 1,
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

    public function testThatASingleChannelWasNotFound()
    {
        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Suyabay',
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => 1,
        ]);

        $response = $this->call('GET', '/api/v1/channels/Suyabaye');
        $output = json_decode($response->getContent());

        $this->assertEquals(count($output->data), 0);
    }

}
