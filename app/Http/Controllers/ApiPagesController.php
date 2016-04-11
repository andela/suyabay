<?php

namespace Suyabay\Http\Controllers;

use Auth;
use Suyabay\AppInfo;
use Firebase\JWT\JWT;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Suyabay\Http\Controllers\Controller;

class ApiPagesController extends Controller
{
    /**
     * Displays the index page of the API.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('api.pages.index');
    }

    /**
     * Display list of apps the user have created and a link to create new appp.
     *
     * @return \Illuminate\Http\Response
     */
    public function myApp()
    {
        return view('api.pages.myapp');
    }

    /**
     * Displays a form where user can register their new app.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewApp()
    {
        return view('api.pages.mynewapp');
    }
}

