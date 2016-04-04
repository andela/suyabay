<?php

namespace Suyabay\Http\Controllers;

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
     * Displays a form a form where user can register their new app.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewApp()
    {
        return view('api.pages.mynewapp');
    }
}
