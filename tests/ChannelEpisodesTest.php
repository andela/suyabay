<?php

use Suyabay\Channel;
use Suyabay\Http\Repository\ChannelRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelEpisodesTest extends TestCase
{
    public function testThatAChannelHaveEpisodes()
    {
        $user = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'user_id'      => 1,
            'channel_name' => strtolower('Ginger Spot'),
        ]);

        $episode = factory('Suyabay\Episode')->create(['channel_id' => $channel->id]);

        $comment = factory('Suyabay\Comment')->create([
            'user_id'    => $user->id,
            'episode_id' => $episode->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->call('GET', '/api/v1/channels/'.$channel->channel_name.'/episodes', []);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($response->status(), 200);
        $this->assertGreaterThan(0, count($decodedResponse->data[0]));
    }

    public function testThatChannelDoesnotExist()
    {
        $user = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create();

        $response = $this
            ->actingAs($user)
            ->call('GET', '/api/v1/channels/'.$channel->channel_name.'/episodes', []);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($response->status(), 404);
        $this->assertEquals($decodedResponse->message, 'Channel not found!');

    }

    public function testThatChannelDoesnotHaveEpisodes()
    {
        $user = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'user_id'      => 1,
            'channel_name' => strtolower('Ginger Spot'),
        ]);

        $response = $this
            ->actingAs($user)
            ->call('GET', '/api/v1/channels/'.$channel->channel_name.'/episodes', []);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($response->status(), 200);
        $this->assertEquals(0, count($decodedResponse->data));
    }
}