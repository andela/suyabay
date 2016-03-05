<?php

use Suyabay\Episode;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Suyabay\Http\Repository\EpisodeRepository;

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

        $repository = new EpisodeRepository();
        $getAllEpisodes = $repository->getAllEpisodes()->toArray();
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

        $repository = new EpisodeRepository();
        $getAllEpisodes = $repository->findEpisodeById($episode['id'])->toArray();

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

        $repository = new EpisodeRepository();
        $getEpisode = $repository->findEpisodeWhere('episode_name', $episode['episode_name'])->get()->toArray();

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
        $repository = new EpisodeRepository();
        $episodes = $repository->getEpisodes([1,2,3,4])->toArray();

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
        $repository = new EpisodeRepository();
        $episode = $repository->createEpisode([
            'episode_name' => 'Swanky new Episode',
            'episode_description' => 'Swanky New episode description',
            'view_count'            => 10,
            'image'                 => "http://goo.gl/8sorZR",
            'audio_mp3'             => "http://goo.gl/LkNP5M",
            'channel_id'            => 1,
            'status'                => 0,
            'likes'                 => 10
        ]);

        $repository = new EpisodeRepository();
        $getEpisode = $repository->findEpisodeById($episode['id'])->toArray();

        $this->assertTrue(is_array($getEpisode));
        $this->assertArrayHasKey('episode_name', $getEpisode);
        $this->assertArrayHasKey('episode_description', $getEpisode);
        $this->seeInDatabase('episodes', ['episode_name' => 'Swanky new Episode']);
    }

    /**
     * Assert that EpisodeRepository's updateEpisode updates an existing episode
     * @return [type] [description]
     */
    public function testUpdateEpisode()
    {
        $repository = new EpisodeRepository();
        $episode = $repository->createEpisode([
            'episode_name' => 'Swanky new Episode',
            'episode_description' => 'Swanky New episode description',
            'view_count'            => 10,
            'image'                 => "http://goo.gl/8sorZR",
            'audio_mp3'             => "http://goo.gl/LkNP5M",
            'channel_id'            => 1,
            'status'                => 0,
            'likes'                 => 10
        ]);
        $update = $repository->updateEpisode($episode['id'], 'episode_name', 'Swanky updated name');
        $this->assertTrue($update);

        $getEpisode = $repository->findEpisodeById($episode['id'])->toArray();

        $this->assertTrue(is_array($getEpisode));
        $this->assertArrayHasKey('episode_name', $getEpisode);
        $this->assertArrayHasKey('episode_description', $getEpisode);
        $this->seeInDatabase('episodes', ['episode_name' => 'Swanky updated name']);
    }
    /**
    * Assert that EpisodeRepository's
    */
    public function testActiveAndPendingEpisodes()
    {
        factory('Suyabay\Episode', 1)->create(['status' => 1]);
        factory('Suyabay\Episode', 1)->create(['status' => 0]);

        $repository = new EpisodeRepository();
        $this->assertTrue(is_array($repository->getActiveEpisodes()->toArray()));
        $this->assertTrue(is_array($repository->getPendingEpisodes()->toArray()));
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

        $this->assertViewHasAll(['episodes', 'channels']);
        $this->seeInDatabase('episodes', ['episode_name' => $episode['episode_name']]);
    }

    /**
     * Assert a user can see all episodes.
     *
     * @return void
     */
    public function testUserCanSeeAllEpisodes()
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
}
