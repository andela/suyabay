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
        $episodes = Episode::where('flag', '=', 0)->orderBy('id', 'desc')->paginate(10);
        $channels = Channel::all();
        
        return view('app.pages.index', compact('episodes'))->with('channels', $channels);
    }
}
