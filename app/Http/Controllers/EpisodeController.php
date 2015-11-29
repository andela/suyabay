<?php


namespace Suyabay\Http\Controllers;

use Suyabay\Episode;
use Illuminate\Http\Request;
use Suyabay\Http\Requests;
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
        //$episodes = Episode::paginate(5);
        
        $episodes = Episode::get()->take(1);
        return view('app.pages.index', compact('episodes'));
        
    }
}
