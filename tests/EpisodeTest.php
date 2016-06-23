<?php

use Suyabay\Episode;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EpisodeTest extends TestCase
{
    use Suyabay\Tests\CreateData;
    /**
     * Assert that EpisodeRepository's getAllEpisodes returns
     * an array of all episodes.
     *
     * @return void
     */
    public function testGetAllEpisodes()
    {
        factory('Suyabay\Episode', 5)->create();

        $getAllEpisodes = self::$episodeRepository->getAllEpisodes()->toArray();
        $this->assertTrue(is_array($getAllEpisodes));
        $this->assertArrayHasKey('episode_name', $getAllEpisodes[0]);
        $this->assertArrayHasKey('episode_description', $getAllEpisodes[0]);
    }

    /**
     * Assert that EpisodeRepository's findEpisodeById returns an
     * episode by the passed ID.
     *
     * @return void
     */
    public function testFindEpisodeById()
    {
        $episode = factory('Suyabay\Episode')->create();

        $getAllEpisodes = self::$episodeRepository->findEpisodeById($episode['id'])->toArray();

        $this->assertTrue(is_array($getAllEpisodes));
        $this->assertArrayHasKey('episode_name', $getAllEpisodes);
        $this->assertArrayHasKey('episode_description', $getAllEpisodes);
    }

    /**
     * Assert that EpisodeRepository's findEpisodeWhere returns an
     * episode by the passed value.
     *
     * @return void
     */
    public function testFindEpisodeWhere()
    {
        $episode = factory('Suyabay\Episode')->create();

        $getEpisode = self::$episodeRepository->findEpisodeWhere(
            'episode_name',
            $episode['episode_name']
        )->get()->toArray();

        $this->assertTrue(is_array($getEpisode[0]));
        $this->assertArrayHasKey('episode_name', $getEpisode[0]);
        $this->assertArrayHasKey('episode_description', $getEpisode[0]);
    }

    /**
     * Assert that EpisodeRepository's getEpisodes returns all epsiodes whose
     * id matches one provided in the passed array.
     *
     * @return void
     */
    public function testGetEpisodes()
    {
        factory('Suyabay\Episode', 5)->create();

        $episodes = self::$episodeRepository->getEpisodes([1,2,3,4])->toArray();

        $this->assertTrue(is_array($episodes));
        $this->assertArrayHasKey('episode_name', $episodes['data'][0]);
        $this->assertArrayHasKey('episode_description', $episodes['data'][0]);
    }

    /**
     * Assert that EpisodeRepository's  createEpisode adds a new
     * episode into the database.
     *
     * @return void
     */
    public function testCreateEpisode()
    {
        $episode = self::createNewEpisode();
        $getEpisode = self::$episodeRepository->findEpisodeById($episode['id'])->toArray();

        $this->assertTrue(is_array($getEpisode));
        $this->assertArrayHasKey('episode_name', $getEpisode);
        $this->assertArrayHasKey('episode_description', $getEpisode);
        $this->seeInDatabase('episodes', ['episode_name' => 'Swanky new Episode']);
    }

    /**
     * Assert that EpisodeRepository's updateEpisode updates an existing episode
     *
     * @return void
     */
    public function testUpdateEpisode()
    {
        $episode = self::createNewEpisode();
        $update = self::$episodeRepository->updateEpisode($episode['id'], 'episode_name', 'Swanky updated name');
        $this->assertTrue($update);

        $getEpisode = self::$episodeRepository->findEpisodeById($episode['id'])->toArray();

        $this->assertTrue(is_array($getEpisode));
        $this->assertArrayHasKey('episode_name', $getEpisode);
        $this->assertArrayHasKey('episode_description', $getEpisode);
        $this->seeInDatabase('episodes', ['episode_name' => 'Swanky updated name']);
    }

    /**
    * Assert that EpisodeRepository's active and pending episodes return
    * active and pending episodes respectively.
    *
    */
    public function testActiveAndPendingEpisodes()
    {
        factory('Suyabay\Episode', 1)->create(['status' => 1]);
        factory('Suyabay\Episode', 1)->create(['status' => 0]);

        $this->assertTrue(is_array(self::$episodeRepository->getActiveEpisodes()->toArray()));
        $this->assertTrue(is_array(self::$episodeRepository->getPendingEpisodes()->toArray()));
    }

   /**
    * Assert that singleEpisode method displays a single episode.
    *
    * @return void
    */
    public function testSingleEpisodeMethod()
    {
        factory('Suyabay\User')->create(['role_id' => 3]);
        factory('Suyabay\Channel', 1)->create();
        $episode = factory('Suyabay\Episode')->create(['status' => 1]);

        $this->call(
            'GET',
            '/episodes/' . $episode['id']
        );
        $this->see($episode['episode_name']);

        $this->assertViewHasAll(['episode', 'channels']);
        $this->seeInDatabase('episodes', ['episode_name' => $episode['episode_name']]);
    }

    /**
     * Assert that admin user can see the dashboard stats.
     *
     * @return void
     */
    public function testAdminCanSeeStats()
    {
        $user = factory('Suyabay\User')->create(['role_id' => 3]);
        factory('Suyabay\Channel', 15)->create();
        $episodes = factory('Suyabay\Episode', 5)->create();

        $this->actingAs($user)
            ->call(
                'GET',
                '/dashboard'
            );
        $this->assertViewHas('data');
        $this->see($episodes[0]['episode_name']);
        $this->see($episodes[0]['episode_description']);
        $this->see(15);
        $this->see('Active Episodes');
    }

    /**
     * Assert a user can see all episodes.
     *
     * @return void
     */
    public function testAdminCanSeeAllEpisodes()
    {
        $user = factory('Suyabay\User')->create(['role_id' => 3]);
        factory('Suyabay\Channel')->create();
        $episodes = factory('Suyabay\Episode', 5)->create();

        $this->actingAs($user)
            ->call(
                'GET',
                '/dashboard/episodes'
            );
        $this->see($episodes[0]['episode_name']);
        $this->see($episodes[0]['episode_description']);

        $this->assertViewHas('episodes');
    }

    /**
     * Assert that an admin user can create a new episode.
     *
     * @return void
     */
    public function testAdminCanCreateEpisodes()
    {
        $user = factory('Suyabay\User')->create(['role_id' => 3]);
        factory('Suyabay\Channel')->create();

        $this->actingAs($user)
             ->call(
                 'GET',
                 '/dashboard/episode/create'
             );
        $this->see('Create Episode');
        $this->assertViewHas('channels');
    }

    /**
     * Assert admin can edit an episode.
     *
     * @return void
     */
    public function testAdminCanEditEpisode()
    {
        $user = factory('Suyabay\User')->create(['role_id' => 3]);
        factory('Suyabay\Channel')->create();
        $episodes = factory('Suyabay\Episode', 5)->create();

        $this->actingAs($user)
            ->call(
                'GET',
                '/dashboard/episode/1/edit'
            );
            $this->assertViewHasAll(['episode', 'channels']);
        $this->actingAS($user)
            ->call(
                'PUT',
                '/dashboard/episode/edit',
                [
                    'episode' => 'Swanky updated name',
                    'description' => 'Swanky updated description',
                    'episode_id' => 1,
                    'channel_id' => 1
                ]
            );
        $this->call('GET', '/episodes');
        $this->assertViewHas('episodes');
    }

    /**
     * Assert that an admin can activate an episode.
     *
     * @return void
     */
    public function testAdminCanActivateEpisode()
    {
        $this->withoutMiddleware();

        $user = factory('Suyabay\User')->create(['role_id' => 3]);
        factory('Suyabay\Channel')->create();
        factory('Suyabay\Episode')->create();

        $this->assertEquals(0, Episode::first()->toArray()['status']);
        $this->actingAs($user)
            ->call(
                'PATCH',
                '/dashboard/episode/activate',
                [
                    'episode_id' => 1
                ]
            );
        $this->assertEquals(1, Episode::first()->toArray()['status']);
    }

    /**
     * Assert that an admin can delete an episode.
     *
     * @return void
     */
    public function testAdminCanDeleteEpisode()
    {
        $this->withoutMiddleware();

        $user = factory('Suyabay\User')->create(['role_id' => 3]);
        factory('Suyabay\Channel')->create();
        factory('Suyabay\Episode')->create();
        $this->assertEquals(1, count(Episode::first()));

        $this->actingAs($user)
             ->call(
                 'GET',
                 '/dashboard/episode/1/delete'
             );
         $this->assertEquals(0, count(Episode::first()));
    }
}
