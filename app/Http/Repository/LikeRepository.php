<?php

namespace Suyabay\Http\Repository;

use DB;
use Auth;
use Suyabay\Like;

class LikeRepository
{
    /**
    * Return all Favorite from the database
    */
    public function getUserFavorite($field, $value)
    {
        return Like::where($field, $value);
    }

    /*Find like where*/
    public function findLikeWhere($field, $value)
    {
        return Like::where($field, $value);
    }

    /**
     * Find and Delete Episode liked by a user
     * @param  integer $user_id    User ID
     * @param  integer $episode_id Episode ID
     * @return void
     */
    public function findLikeByUserOnEpisode($user_id, $episode_id)
    {
        return DB::table('likes')
        ->where('user_id', $user_id)
        ->where('episode_id', $episode_id)
        ->delete();
    }

    /**
     * Persist new Episode like to the database.
     *
     * @param  integer $userid    Authenticated user ID
     * @param  integer $episodeid Episode ID
     * @return boolean            true or false
     */
    public function insertIntoLikesTable($userid, $episodeid)
    {
        return Like::insert(['user_id' => $userid, 'episode_id' => $episodeid]);
    }

    /**
     * returns  either must_login, like or dislike message.
     *
     * @return void
     */

    public function checkLikeStatusForUserOnEpisode($likes)
    {
        $is_like_episode = false;

        if (! Auth::check()) {
            return "must_login";
        }

        foreach ($likes as $like) {
            if ($like->user_id == Auth::user()->id) {
                $is_like_episode = true;
                break;
            }
        }

        if ($is_like_episode) {
            $status = "dislike";
        } else {
            $status = "like";
        }

        return $status;
    }

    /**
     * return an array of all the episodes favorited by a user.
     * returns empty array if none.
     *
     * $returns array
     */
    public function getNumberOfUserFavorite()
    {
        return (Auth::check()) ? $this->getUserFavorite('user_id', Auth::user()->id) : 0;
    }
}
