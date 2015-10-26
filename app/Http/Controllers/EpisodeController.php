<?php

namespace Suyabay\Http\Controllers;

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
        $episodes = \Suyabay\Episode::paginate(2);

        return view('app.pages.index')->with('episodes', $episodes);

        // $episodes = \Suyabay\Episode::all();
        // return view('app.pages.index',compact('episodes'));
    }
}
