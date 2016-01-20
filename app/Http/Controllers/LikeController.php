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
    public function postLike()
    {
        //return view('app.pages.index');

        $episode 		= $this->episodeRepository->findEpisodeById(5);
        $episode->likes = $episode->likes + 1;
        $episode->save();

        $this->likeRepository->insertIntoLikesTable(1, 5);

        return $episode;
    }

    /**
     * Unlike an Episode
     *
     */
    public function postUnlike()
    {
    	$episode 		= $this->episodeRepository->findEpisodeById(4);
        $episode->likes = $episode->likes - 1;
        $episode->save();

        return $this->likeRepository->findLikeWhere('user_id', 1)->delete();
    }

}
