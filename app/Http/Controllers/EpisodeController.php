<?php


namespace Suyabay\Http\Controllers;

use Auth;
use Suyabay\Episode;
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

        $episodes = Episode::with('like')->orderBy('id', 'desc')->paginate(5);

        $episodes->each(function ($episode, $key) {

            $episode->like_status = $this->likeRepository->checkLikeStatusForUserOnEpisode($episode->like);

        });

        $favorites = (Auth::check()) ? $this->likeRepository->getUserFavorite('user_id', Auth::user()->id) : 0;

        return view('app.pages.index', compact('episodes', 'channels', 'favorites'));
    }
}
