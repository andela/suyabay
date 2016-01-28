<?php


namespace Suyabay\Http\Controllers;

use Suyabay\Episode;
use Suyabay\Channel;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Suyabay\Http\Controllers\Controller;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels       = Channel::all();
        $episodes       = Episode::where('flag', '=', 0)->orderBy('id', 'desc')->paginate(10);
        $likedEpisodes  = Episode::with('like')->paginate(5);

        $likedEpisodes->each(function ($likedEpisodes, $key) {

            $likedEpisodes->like_status = $this->likeRepository->checkLikeStatusForUserOnEpisode($likedEpisodes->like);

        });

        return view('app.pages.index', compact('episodes', 'likedEpisodes'))->with('channels', $channels);

    }

    public function show($episodeId)
    {
        $episode = Episode::findOrFail($episodeId);

        return view('app.pages.episode', compact('episode'));
    }
}
