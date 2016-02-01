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

        $episodes = Episode::with('like')->orderBy('id', 'desc')->paginate(5);

        $episodes->each(function ($episode, $key) {
            $episode->like_status = $this->likeRepository->checkLikeStatusForUserOnEpisode($episode->like);
        });
        
        $favorites = $this->likeRepository->getNumberOfUserFavorite();

        return view('app.pages.index', compact('episodes', 'channels', 'favorites'));
    }

    public function show($episodeId)
    {
        $channels = $this->channelRepository->getAllChannels();
        $episode = Episode::findOrFail($episodeId);

        return view('app.pages.episode', compact('episode', 'channels'));
    }


    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allEpisode()
    {
        $episodes = Episode::get();

        return view('app.pages.episodes', compact('episodes'));
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function singleEpisode($id)
    {
        $episodes = Episode::with('like')->where('id', $id)->get();

            $episodes->each(function ($episode, $key) {

                $episode->like_status = $this->likeRepository->checkLikeStatusForUserOnEpisode($episode->like);

            });
        
            return view('app.pages.single_episode', compact('episodes'));
    }

}
