<?php

use Suyabay\Episode;
use Suyabay\Channel;
use Suyabay\User;
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

    public function testCreateChannelPage()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
         ->visit('/dashboard/channel/create')
         ->see('Create Channel');
    }

    /**
     * Assert that a new channel is created
     * in the database.
     *
     * @return void
     */
    public function testCreateChannel()
    {
        $this->withoutMiddleware();

        $user = factory(User::class)->create();
        $this->actingAs($user)
         ->visit('/dashboard/channel/create')
         ->type('Swanky new name', 'name')
         ->type('Swanky new description', 'description')
         ->press('create')
         ->seeInDatabase('channels', [
            'channel_name' => 'Swanky new name'
         ]);

        $user = factory(User::class)->create();
        $this->actingAs($user)
        ->call(
            'POST',
            '/dashboard/channel/create',
            [
                'name' => 'Another Channel Name',
                'description' => 'Another channel description'
            ]
        );

        $this->seeInDatabase('channels', [
        'channel_name' => 'Another Channel Name'
        ]);
    }

    /**
     * Assert that edit route updates the channel.
     *
     * @return void
     */
    public function testEditChannel()
    {
        $this->withoutMiddleware();

        $user = factory(User::class)->create();
        $channel = factory(Channel::class)->create();

        $this->actingAs($user)
            ->call(
                'PUT',
                '/dashboard/channel/edit',
                [
                    'channel_id' => 1,
                    'channel_name' => 'Swanky updated name',
                    'channel_description' => 'Swanky updated description'
                ]
            );

            $this->seeInDatabase('channels', [
                'id' => $channel['id'],
                'channel_name' => 'Swanky updated name'
             ]);
    }

    /**
     * Assert that the DELETE route removes a channel from the database
     *
     * @return void
     */
    public function testDeleteChannel()
    {
        $this->withoutMiddleware();

        $user = factory(User::class)->create();
        $channel = factory(Channel::class)->create();

        $this->actingAs($user)
             ->call(
                 'DELETE',
                 '/dashboard/channel/' . $channel['id']
             );
        $this->assertEquals(0, count(Channel::where('id', $channel['id'])->get()));
    }

    /**
     * Assert that new active channel
     *is visible in /dashboard/channels/active.
     *
     * @return void
     */
    public function testActiveChannelsPage()
    {
        $user = factory(User::class)->create();
        $channel = factory(Channel::class)->create();

        $this->actingAs($user)
             ->visit('/dashboard/channels/active')
             ->see($channel['channel_name']);
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
}
