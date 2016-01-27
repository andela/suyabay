<?php

namespace Suyabay\Http\Repository;

use DB;
use Auth;
use Suyabay\Like;

class LikeRepository
{

    /*Find like where*/
    public function findLikeWhere($field, $value)
    {
        return Like::where($field, $value);
    }

    /*Fine and Delete Episode liked by a user*/
    public function findLikeByUserOnEpisode($user_id, $episode_id)
    {
        return DB::table('likes')
        ->where('user_id', $user_id)
        ->where('episode_id', $episode_id)
        ->delete();
    }

    public function insertIntoLikesTable($userid, $episodeid)
    {
        return Like::insert(['user_id' => $userid, 'episode_id' => $episodeid]);
    }

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
        }
        else {
            $status = "like";
        }

        return $status;
    }
}
