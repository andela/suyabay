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

    /**
     * Assert that LikeRepository's testGetNumberOfUserFavorite returns an
     * array of all liked episodes or empty.
     *
     * @return void
     */
    public function testGetNumberOfUserFavorite()
    {
         $this->withoutMiddleware();

        $user = factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        factory('Suyabay\Episode', 3)->create(['status' => 1]);

        $this->actingAs($user);
        $likedEpisodes = self::$likerepository->getNumberOfUserFavorite();
        $likedEpisodes = $likedEpisodes->get();
        $this->assertTrue(is_array($likedEpisodes->toArray()));
        $this->assertEquals(0, $likedEpisodes->count());

        $this->actingAs($user)
         ->call(
             'POST',
             '/episode/like',
             [
                'user_id' => $user['id'],
                'episode_id' => 1
             ]
         );

        $likedEpisodes = self::$likerepository->getNumberOfUserFavorite();
        $likedEpisodes = $likedEpisodes->get();
        $this->assertTrue(is_array($likedEpisodes->toArray()));
        $this->assertEquals(1, $likedEpisodes->count());

        $this->actingAs($user)
         ->call(
             'POST',
             '/episode/like',
             [
                'user_id' => $user['id'],
                'episode_id' => 3
             ]
         );

        $likedEpisodes = self::$likerepository->getNumberOfUserFavorite();
        $likedEpisodes = $likedEpisodes->get();
        $this->assertTrue(is_array($likedEpisodes->toArray()));
        $this->assertEquals(2, $likedEpisodes->count());
    }

    /**
     * Assert that LikeRepository's checkLikeStatusForUserOnEpisode returns
     * either must_login, like or dislike message.
     *
     * @return void
     */
    public function testCheckLikeStatusForUserOnEpisode()
    {
        $this->withoutMiddleware();

        $feedback = self::$likerepository->checkLikeStatusForUserOnEpisode([]);
        $this->assertEquals('must_login', $feedback);

        $user = factory('Suyabay\User')->create();
        factory('Suyabay\Channel')->create();
        factory('Suyabay\Episode')->create(['status' => 1]);

        $this->actingAs($user);

        $likes = self::$likerepository->findLikeWhere('episode_id', 1);
        $feedback = self::$likerepository->checkLikeStatusForUserOnEpisode($likes);
        $this->assertEquals('like', $feedback);

        $this->actingAs($user)
         ->call(
             'POST',
             '/episode/like',
             [
                'user_id' => $user['id'],
                'episode_id' => 1
             ]
         );
        $likes = self::$likerepository->getUserFavorite('user_id', 1)->get();
        $feedback = self::$likerepository->checkLikeStatusForUserOnEpisode($likes);
        $this->assertEquals('dislike', $feedback);
    }
}
