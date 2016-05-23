<?php

use Suyabay\Channel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelEpisodeDetailsTest extends TestCase 
{
    public function testThatChannelnameIsIncorrect()
    {
        $user = factory('Suyabay\User')->create();
        $channel = factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode')->create();

        $response = $this
        ->actingAs($user)
        ->call('GET', '/api/v1/channels/mychannel/episodes/'.$episode->episode_name, []);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Channel not found!');
        $this->assertEquals($response->status(), 404);
    }

    public function testGetChannelEpisodeDetails()
    {
        $user = factory('Suyabay\User')->create();
        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => strtolower('Donovan'),
        ]);

        $episode = factory('Suyabay\Episode')->create([
            'episode_name' => strtolower('Nyama Choma'),
            'channel_id'   => $channel->id,
        ]);

        $response = $this->actingAs($user)
        ->call(
            'GET', 
            '/api/v1/channels/'.$channel->channel_name.'/episodes/'.$episode->first()->episode_name, 
        []);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->data->channel_name, $channel->channel_name);
        $this->assertEquals($decodedResponse->data->id, $episode->id);
        $this->assertEquals($decodedResponse->data->name, $episode->episode_name);
    }

    public function testThatChannelEpisodeNameIsIncorrect()
    {
        $user = factory('Suyabay\User')->create();
        $channel = factory('Suyabay\Channel')->create();

        $episode = factory('Suyabay\Episode')->create([
            'episode_name' => 'Nyama Choma',
            'channel_id'   => $channel->id,
        ]);

        $response = $this->actingAs($user)
        ->call(
            'GET', 
            '/api/v1/channels/'.$channel->channel_name.'/episodes/lookingforepisode', 
        []);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Episode not found!');
        $this->assertEquals($response->status(), 404);
    }
}
