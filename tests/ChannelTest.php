<?php

use Suyabay\Episode;
use Suyabay\Channel;
use Suyabay\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suyabay\Http\Repository\ChannelRepository;

class ChannelTest extends TestCase
{
    use Suyabay\Tests\CreateData;

    /**
     * Test channel link leads to route
     *
     * Update test to assert that a channels variable is returned.
     */
    public function testUserCanViewChannels()
    {
        $channel = factory(Channel::class)->create();
        $this->visit(route('channels'))
             ->see($channel['channel_name']);

        $this->call('GET', '/channels');
        $this->assertViewHasAll(['channels']);

    }

    /**
     * Assert that a new channel is created
     * in the database.
     *
     * @return void
     */
    public function testCreateChannel()
    {
        $user = factory(User::class)->create(['role_id' => 3]);
        $this->actingAs($user)
         ->visit('/dashboard/channel/create')
         ->type('Swanky new name', 'channel_name')
         ->type('Swanky new description', 'channel_description')
         ->press('create')
         ->seeInDatabase('channels', [
            'channel_name' => 'Swanky new name'
         ]);

         $admin = factory(User::class)->create(['role_id' => 3]);
         $newChannel  = $this->actingAs($admin)
         ->call(
             'POST',
             '/dashboard/channel/create',
             [
                'channel_name' => 'Another Channel Name',
                'channel_description' => 'Another channel description',
                '_token' => csrf_token()
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

        $admin = factory(User::class)->create(['role_id' => 3]);
        $channel = factory(Channel::class)->create();

        $this->actingAs($admin)
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

        $admin = factory(User::class)->create(['role_id' => 3]);
        $channel = factory(Channel::class)->create();

        $this->actingAs($admin)
             ->call(
                 'DELETE',
                 '/dashboard/channel/' . $channel['id']
             );
        $this->visit('/dashboard/channels/deleted')
             ->see($channel['name']);
        $this->seeInDatabase('channels', [
            'id' => $channel['id']
        ]);

        $this->call('GET', '/dashboard/channels/deleted');
        $this->assertViewHas('channels');
    }

    /**
     * Test that the all channels page displays both active and deleted episodes
     * @return [type] [description]
     */
    public function testAllChannelsPage()
    {
         $this->withoutMiddleware();

        $user = factory(User::class)->create(['role_id' => 3]);
        $channel1 = factory(Channel::class)->create(['id' => 1]);
        $channel2 = factory(Channel::class)->create(['id' => 2]);

        $this->actingAs($user)
             ->call(
                 'DELETE',
                 '/dashboard/channel/' . $channel2['id']
             );
        $this->visit('dashboard/channels/all')
             ->see($channel1['name'])
             ->see($channel2['name']);

        $this->seeInDatabase('channels', [
            'id' => $channel1['id']
        ]);
        $this->seeInDatabase('channels', [
            'id' => $channel2['id']
        ]);

        $this->call('GET', '/dashboard/channels/all');
        $this->assertViewHas('channels');
    }

    /**
     * Assert that new active channel
     *is visible in /dashboard/channels/active.
     *
     * @return void
     */
    public function testActiveChannelsPage()
    {
        $admin = factory(User::class)->create(['role_id' => 3]);
        $channel = factory(Channel::class)->create();
        $this->actingAs($admin)
             ->visit('/dashboard/channels/active')
             ->see($channel['channel_name']);

        $this->call('GET', '/dashboard/channels/active');
        $this->assertViewHas('channels');
    }

    /**
     * Test that an admin sees a no episodes message when
     * a channel is empty
     *
     * @return void
     */
    public function testAdminGetsMessageOnEmptyChannels()
    {
        $admin = factory(User::class)->create(['role_id' => 3]);
        $channel = factory(Channel::class)->create();
        $this->actingAs($admin)
             ->visit('/dashboard/channel/'. $channel['id'])
             ->see('Ooops, there are no episodes in this channel');
    }

    /**
     * Test that a User sees a no episodes message when
     * a channel is empty
     *
     * @return void
     */
    public function testUserGetsMessageOnEmptyChannels()
    {
        $admin = factory(User::class)->create(['role_id' => 3]);
        $user = factory(User::class)->create();
        $channel = factory(Channel::class)->create();
        $this->actingAs($user)
             ->visit('/channel/' . $channel['id'])
             ->see('Ooops, there are no episodes in this channel');
    }

    /**
     * Test user channnel relationship
     */
    public function testUserChannelRelationship()
    {
        /**
         * Update createdUser to admin with privilleges to create
         * a new channel
         */
        $admin = $this->createUser(3);
        $channel = $this->createChannel();

        $this->assertEquals($channel->user_id, $channel->user->id);
    }

    /**
     * Test Episode Channel relationship
     */
    public function testEpisodechannelRelationship()
    {
        $this->createUser(3);
        $channel = $this->createChannel();
        $episode1 = $this->createEpisode();
        $episode2 = $this->createEpisode();

        $this->assertEquals($episode1->channel_id, $channel->id);
        $this->assertEquals($episode2->channel_id, $channel->id);
    }
    /**
     * Asseert that ChannelRepository::find($id) returns an array
     *
     * @return void
     */
    public function testFindInChannelRepository()
    {
        $channel = factory(Channel::class)->create();
        $channelRepository = new ChannelRepository();
        $channel = $channelRepository->find($channel['id'])->toArray();

        $this->assertTrue(is_array($channel));
        $this->assertArrayHasKey('channel_name', $channel);
        $this->assertArrayHasKey('channel_description', $channel);
    }

    /**
     * assert that ChannelRepository::deleteChannel($id) deletes a
     * channel.
     *
     * @return void
     */
    public function testDeletedChannelInChannelRepository()
    {
        $channel = factory(Channel::class)->create();
        $id = $channel['id'];
        $channelRepository = new ChannelRepository();
        $channel = $channelRepository->deleteChannel($id);

        $this->assertTrue(is_null($channel));
        $this->assertTrue(is_array(Channel::withTrashed()->find($id)->toArray()));
        $this->assertArrayHasKey('channel_name', Channel::withTrashed()->find($id)->toArray());
        $this->assertArrayHasKey('channel_description', Channel::withTrashed()->find($id)->toArray());
        $this->assertArrayHasKey('deleted_at', Channel::withTrashed()->find($id)->toArray());
    }

    /**
     * Assert that restorechannel method in ChannelRepository deletes
     * the deleted_At field/
     *
     * @return void
     */
    public function testRestoreChannelInChannelRepository()
    {
        $channel = factory(Channel::class)->create();
        $id = $channel['id'];

        $channelRepository = new ChannelRepository();
        $channelRepository->deleteChannel($id);
        $channelRepository->restoreChannel($id);

        $channel = Channel::find($id)->toArray();
        $this->assertTrue(is_array($channel));
        $this->assertArrayHasKey('channel_name', $channel);
        $this->assertArrayHasKey('channel_description', $channel);
        $this->assertArrayHasKey('deleted_at', $channel);
        $this->assertEquals('', $channel['deleted_at']);

    }
    /**
     * Assert that getOrderedChannels returns an ordered array of channels.
     *
     * @return void
     */
    public function testGetOrderedChannel()
    {
        $channel = factory('Suyabay\Channel', 5)->create();

        $channelRepository = new ChannelRepository();

        $descending = $channelRepository->getOrderedChannels('id', 'desc')->get()->toArray();
        $this->assertTrue(is_array($descending));
        $this->assertEquals(5, $descending[0]['id']);

        $ascending = $channelRepository->getOrderedChannels('id', 'asc')->get()->toArray();
        $this->assertTrue(is_array($ascending));
        $this->assertEquals(1, $ascending[0]['id']);
    }
}
