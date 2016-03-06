<?php

use Suyabay\Like;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikeEpisodeTest extends TestCase
{
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
        $newLike = self::$likerepisitory->getUserFavorite('user_id', 1);
        $newLike = $newLike->get()->toArray();

        $this->assertTrue(is_array($newLike));
        $this->assertArrayHasKey('episode_id', $newLike[0]);
        $this->assertArrayHasKey('user_id', $newLike[0]);

        $newLike = self::$likerepisitory->findLikeWhere('episode_id', 1);
        $newLike = $newLike->get()->toArray();

        $this->assertTrue(is_array($newLike));
        $this->assertArrayHasKey('episode_id', $newLike[0]);
        $this->assertArrayHasKey('user_id', $newLike[0]);

        $episodeUnLike = self::$likerepisitory->findLikeByUserOnEpisode($user['id'], 1);
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

        $unlikedEpisode = self::$likerepisitory->findLikeWhere('episode_id', 1);
        $this->assertEquals(0, $unlikedEpisode->get()->count());
    }
}
