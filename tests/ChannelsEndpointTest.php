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
        $channel = factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode', 5)->create([
            'channel_id' => $channel->id,
        ]);

        $response = $this->actingAs($user)->call('GET', '/api/v1/channels');
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
        $this->withoutMiddleware();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Suyabay',
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => 1,
        ]);

        $response = $this->call('GET', '/api/v1/channels/Suyabaye');
        $output = json_decode($response->getContent());

        $this->assertEquals(count($output->data), 0);
    }

    public function testThatAChannelWasCreated()
    {
        $this->withoutMiddleware();

        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Cabinet',
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->call('POST', '/api/v1/channels',
            [
                'name' => 'Nyama Choma',
                'description' => 'This is kenyan way of naming roasted meat',
            ]
        );

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Channel created successfully');
    }

    public function testThatChannelsFieldsAreRequired()
    {
        $this->withoutMiddleware();

        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Cabinet',
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->call('POST', '/api/v1/channels', [
            'description' => 'This is kenyan way of naming roasted meat',
        ]);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'All fields are required');

    }

    public function testThatChannelWasEditedSuccessfullyViaPutVerb()
    {
        $this->withoutMiddleware();

        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => strtolower('Gingerbread'),
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->call('PUT', '/api/v1/channels/'.$channel->channel_name, [
            'name' => 'Gingerbread',
            'description' => 'This is a version 2.3.0 of Java android SDK',
        ]);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Channel updated successfully');
    }

    public function testThatChannelCouldNotEditedViaPutVerb()
    {
        $this->withoutMiddleware();

        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Gingerbread',
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->call('PUT', '/api/v1/channels/'.$channel->channel_name, [
            'name' => 'Lollipop',
            'description' => 'This is a version 5.0.0 of Java android SDK',
        ]);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Channel cannot be updated because the channel name is incorrect');
    }

    public function testThatChannelNameUpdatedViaPatchVerb()
    {
        $this->withoutMiddleware();

        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => strtolower('Suyabay'),
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->call('PATCH', '/api/v1/channels/'.$channel->channel_name, [
            'name' => 'Lollipop',
        ]);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Channel updated successfully');
    }

    public function testThatChannelNameWasNotUpdatedViaPatchVerb()
    {
        $this->withoutMiddleware();

        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Suyabay',
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->call('PATCH', '/api/v1/channels/'.$channel->channel_name, [
            'name' => 'Lollipop',
        ]);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Channel cannot be updated because the channel name is incorrect');
    }

    public function testThatChannelWasNotUpdateViaPatchVerbDueToMissingField()
    {
        $this->withoutMiddleware();

        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => strtolower('Suyabay'),
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->call('PATCH', 
            '/api/v1/channels/'.$channel->channel_name, [
            'name' => '',
        ]);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'All fields are required');
    }

    public function testThatChannelWasNotUpdatedViaPatchVerbDueToIncorrectChannelname()
    {
        $this->withoutMiddleware();

        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Suyabay',
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->call('PATCH', 
            '/api/v1/channels/'.$channel->channel_name, [
            'name' => 'lekdan',
        ]);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Channel cannot be updated because the channel name is incorrect');
    }

    public function testThatChannelWasNotDeletedDueToIncorrectChannelname()
    {
        $this->withoutMiddleware();

        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => 'Suyabay',
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->call('DELETE', 
            '/api/v1/channels/'.$channel->channel_name, [
        ]);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Channel cannot be deleted because the channel name is incorrect');
    }

    public function testThatChannelWasDeletedSuccessfully()
    {
        $this->withoutMiddleware();
        
        $user  = $channel = factory('Suyabay\User')->create();

        $channel = factory('Suyabay\Channel')->create([
            'channel_name' => strtolower('Naija suya'),
            'channel_description' => 'Laoriosam volup atum nesciunt',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->call('DELETE', 
            '/api/v1/channels/'.$channel->channel_name, [
        ]);

        $decodedResponse = json_decode($response->getContent());

        $this->assertEquals($decodedResponse->message, 'Channel successfully deleted');
    }

}
