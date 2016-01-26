<?php

namespace Suyabay\Http\Controllers;

use Suyabay\Episode;
use Suyabay\Channel;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Suyabay\Http\Controllers\Controller;

class IndexController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $episodes = Episode::paginate(5);
        $channels = Channel::all();
        
        return view('app.pages.index', compact('episodes', 'channels'));
    }

}
