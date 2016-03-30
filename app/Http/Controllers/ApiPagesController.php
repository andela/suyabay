<?php

namespace Suyabay\Http\Controllers;

class ApiPagesController extends Controller
{
    public function index()
    {
        return view('api.index');
    }

    public function myApp()
    {
        return view('api.pages.myapp');
    }
}
