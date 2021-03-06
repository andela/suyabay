<?php


namespace Suyabay\Http\Controllers;

use Auth;
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
        $channels = $this->channelRepository->getAllChannels();

        $episodes = Episode::with('like')->orderBy('views', 'desc')->paginate(5);

        $episodes->each(function ($episode, $key) {
            $episode->like_status = $this->likeRepository->checkLikeStatusForUserOnEpisode($episode->like);
        });

        $top = $episodes->shift();

        // All guest users to see at least the top video.
        $top->allow = true;

        $favorites = $this->likeRepository->getNumberOfUserFavorite();

        return view('app.pages.index', compact('episodes', 'top', 'channels', 'favorites'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allEpisode()
    {
        $episodes = Episode::orderBy('views', 'DESC')->get();
        $channels = Channel::all();

        return view('app.pages.episodes', compact('episodes', 'channels'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function singleEpisode($id)
    {
        $episode = Episode::with('like')->find($id)->incrementViews();
        $channels = Channel::all();
        $firstTenComments = $episode->comment()->orderBy('created_at', 'asc')->take(10)->get();

        $episode->like_status = $this->likeRepository->checkLikeStatusForUserOnEpisode($episode->like);

        return view('app.pages.single_episode', compact('episode', 'channels', 'firstTenComments'));
    }
}
