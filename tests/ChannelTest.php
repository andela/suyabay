<?php

use Suyabay\Episode;
use Suyabay\Channel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelTest extends TestCase
{
    use Suyabay\Tests\CreateData;

    /**
     * Test channel link leads to route
     */
    public function testChannelLink()
    {
        $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();

        $this->visit('/')
             ->click('Channels')
             ->seePageIs('/channels');
    }

    /**
     * Test user channnel relationship
     */
    public function testUserChannelRelationship()
    {
        $user = $this->createUser(1);
        $channel = $this->createChannel();

        $this->assertEquals($channel->user_id, $channel->user->id);
    }

    /**
     * Test Episode Channel relationship
     */
    public function testEpisodechannelRelationship()
    {
        $this->createUser(1);
        $this->createChannel();
        $episode = $this->createEpisode();

        $this->assertEquals($episode->channel_id, $episode->channel->id);
    }

    public function testChannelHasEpisode()
    {
        $this->createUser(1);
        $this->createChannel();
        $this->createEpisode();

        $this->visit('/')
             ->click('Channels')
             ->seePageIs('/channels')
             ->see('Channel name')
             ->click('channel1')
             ->sePageIs('/channel/1');
    }

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

    /**
     * Test that only authenticated user can use this route
     * status code
     * @return status code
     */
    public function testCreateEpisodeRoute()
    {
        $response = $this->call('GET', '/dashboard/channels', ['username' => 'Taylor', 'password' => 'pass']);

        $this->assertEquals(302, $response->status());
    }

}
