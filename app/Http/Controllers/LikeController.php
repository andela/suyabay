<?php

namespace Suyabay\Http\Controllers;

use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Suyabay\Http\Controllers\Controller;

class LikeController extends Controller
{

    /**
     * Like an Episode
     *
     */
    public function postLike(Request $request)
    {


        $episode 		= $this->episodeRepository->findEpisodeById($request['episode_id']);
        $episode->likes = $episode->likes + 1;
        $episode->save();

        $this->likeRepository->insertIntoLikesTable($request['user_id'], $request['episode_id']);

        return $episode;
    }

    /**
     * Unlike an Episode
     *
     */
    public function postUnlike(Request $request)
    {

    	$episode 		= $this->episodeRepository->findEpisodeById($request['episode_id']);
        $episode->likes = $episode->likes - 1;
        $episode->save();

        $this->likeRepository->findLikeByUserOnEpisode($request['user_id'], $request['episode_id']);

    }

}
