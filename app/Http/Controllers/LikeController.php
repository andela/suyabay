<?php

namespace Suyabay\Http\Controllers;

use Auth;
use Suyabay\Episode;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Suyabay\Http\Controllers\Controller;

class LikeController extends Controller
{
    /**
     * Load Favorite page
     */
    public function index()
    {
        $channels = $this->channelRepository->getAllChannels();

        $likes = auth()->user()->likes->all();
        $episodeIds = $this->getEpisodeIds($likes);
        $userEpisodes = $this->episodeRepository->getEpisodes($episodeIds);

        $favorites = (Auth::check()) ? $this->likeRepository->getUserFavorite('user_id', Auth::user()->id) : 0;

        return view('app.pages.favorites', compact('userEpisodes', 'channels', 'favorites'));
    }

    /**
     * Like an Episode
     *
     */
    public function postLike(Request $request)
    {
        $episode        = $this->episodeRepository->findEpisodeById($request['episode_id']);
        $episode->likes = $episode->likes + 1;
        $episode->save();

        $this->likeRepository->insertIntoLikesTable($request['user_id'], $request['episode_id']);
    }

    /**
     * Unlike an Episode
     *
     */
    public function postUnlike(Request $request)
    {
        $episode        = $this->episodeRepository->findEpisodeById($request['episode_id']);
        $episode->likes = $episode->likes - 1;
        $episode->save();

        return $this->likeRepository->findLikeByUserOnEpisode($request['user_id'], $request['episode_id']);
    }

    /**
     * Get the collection of episode_ids
     */
    public function getEpisodeIds($likes)
    {
        $episodeIds = [];
        $count = 0;

        foreach ($likes as $like) {
            $episodeIds[$count] = $like->episode_id;
            $count++;
        }

        return $episodeIds;
    }

}
