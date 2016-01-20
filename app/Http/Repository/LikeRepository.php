<?php

namespace Suyabay\Http\Repository;

use Suyabay\Like;
use Auth;

class LikeRepository
{

	/*Find like where*/
	public function findLikeWhere($field, $value)
	{
		return Like::where($field, $value);
	}

    public function insertIntoLikesTable($userid, $episodeid)
	{
		Like::insert(['user_id' => $userid, 'episode_id' => $episodeid]);
	}

	public function checkLikeStatusForUserOnEpisode($likes)
	{
		$is_like_episode = false;

		foreach ($likes as $like) {

			if($like->user_id == Auth::user()->id) {
				$is_like_episode = true;
				break;
			}
		}

		if ($is_like_episode) {

			$status = "dislike";
		}
		else
		{
			$status = "like";
		}

		return $status;
	}

}
