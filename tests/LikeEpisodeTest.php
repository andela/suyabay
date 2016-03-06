<?php

use Suyabay\Like;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikeEpisodeTest extends TestCase
{
    /**
     * Assert that an authenticated user
     * can view all favorited episodes.
     *
     * @return void
     */
    public function testViewLikedEpisodes()
    {
        $this->withoutMiddleware();

        $user = factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode')->create(['status' => 1]);
        $this->actingAs($user)
             ->call(
                 'POST',
                 '/episode/like',
                 [
                    'user_id' => $user['id'],
                    'episode_id' => 1
                 ]
             );

        $this->actingAs($user)
            ->call(
                'GET',
                '/favorites'
            );
        $this->assertViewHasAll(['userEpisodes', 'channels', 'favorites']);
        $this->see($episode['episode_name']);
    }

    /**
     * Assert that:
     *  An authenticated user can like an episode.
     *
     *  LikeRepository's getUserFavorite returns all
     *  episodes favvorited by a user.
     *
     * LikeRepository's findLikeWhere returns episodes
     * that match a criteria.
     *
     * LikeRepository's findLikeByUserOnEpisode deletes an
     * episode that matches a certain criteria.
     *
     * @return void
     */
    public function testEpisodeLike()
    {
        $this->withoutMiddleware();

        $user = factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        factory('Suyabay\Episode')->create(['status' => 1]);

        $this->actingAs($user)
             ->call(
                 'POST',
                 '/episode/like',
                 [
                    'user_id' => $user['id'],
                    'episode_id' => 1
                 ]
             );
        $newLike = self::$likerepository->getUserFavorite('user_id', 1);
        $newLike = $newLike->get()->toArray();

        $this->assertTrue(is_array($newLike));
        $this->assertArrayHasKey('episode_id', $newLike[0]);
        $this->assertArrayHasKey('user_id', $newLike[0]);

        $newLike = self::$likerepository->findLikeWhere('episode_id', 1);
        $newLike = $newLike->get()->toArray();

        $this->assertTrue(is_array($newLike));
        $this->assertArrayHasKey('episode_id', $newLike[0]);
        $this->assertArrayHasKey('user_id', $newLike[0]);

        $episodeUnLike = self::$likerepository->findLikeByUserOnEpisode($user['id'], 1);
        $this->assertEquals(1, $episodeUnLike);
    }

    /**
     * Assert that
     *  An authenticated user can unlike a liked episode
     *
     * @return void
     */
    public function testEpisodeUnlike()
    {
        $this->withoutMiddleware();

        $user = factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        factory('Suyabay\Episode')->create(['status' => 1]);
        $this->actingAs($user)
             ->call(
                 'POST',
                 '/episode/like',
                 [
                    'user_id' => $user['id'],
                    'episode_id' => 1
                 ]
             );

        $this->actingAs($user)
             ->call(
                 'POST',
                 '/episode/unlike',
                 [
                    'user_id' => $user['id'],
                    'episode_id' => 1
                 ]
             );

        $unlikedEpisode = self::$likerepository->findLikeWhere('episode_id', 1);
        $this->assertEquals(0, $unlikedEpisode->get()->count());
    }

    /**
     * Assert that LikeRepository's insertIntoLikesTable inserts new favorite
     * into the database.
     *
     * @return void
     */
    public function testInsertIntoLikesTable()
    {
        $this->withoutMiddleware();

        $user = factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        $episode = factory('Suyabay\Episode')->create(['status' => 1]);

        self::$likerepository->insertIntoLikesTable(1, 1);

        $this->actingAs($user)
            ->call(
                'GET',
                '/favorites'
            );
        $this->assertViewHasAll(['userEpisodes', 'channels', 'favorites']);
        $this->see($episode['episode_name']);

    }
}
