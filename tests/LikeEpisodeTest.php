<?php

use Suyabay\Like;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikeEpisodeTest extends TestCase
{
    /**
     * Test that an episode can be liked .
     *
     * @return void
     */
    public function testUserCanLikeEpisode()
    {
        Like::create([
            'user_id'       => 1,
            'episode_id'    => 1,
        ]);

        $this->seeInDatabase('likes', [
            'user_id'            => 1,
            'episode_id'    => 1,
        ]);
    }

    /**
     * Test that an episode can be disliked .
     *
     * @return void
     */
    public function testUserCanDislikeEpisode()
    {
        Like::where('user_id', 1)
        ->where('video_id', 1)
        ->delete();

        $this->missingFromDatabase('likes', [
            'user_id'            => 1,
            'episode_id'    => 1,
        ]);
    }

}
