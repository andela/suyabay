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
     */
    public function testUserCanViewChannels()
    {
        $channel = factory(Channel::class)->create();
        $this->visit(route('channels'))
             ->see($channel['channel_name']);
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

        $user = factory(User::class)->create(['role_id' => 3]);
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

        $user = factory(User::class)->create(['role_id' => 3]);
        $channel = factory(Channel::class)->create();

        $this->actingAs($user)
             ->call(
                 'DELETE',
                 '/dashboard/channel/' . $channel['id']
             );
        $this->visit('/dashboard/channels/deleted')
             ->see($channel['name']);
        $this->seeInDatabase('channels', [
            'id' => $channel['id']
        ]);
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
}
