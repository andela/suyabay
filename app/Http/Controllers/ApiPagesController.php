<?php

namespace Suyabay\Http\Controllers;

class ApiPagesController extends Controller
{
    public function index()
    {
        return view('api.pages.index');
    }

    public function myApp()
    {
        return view('api.pages.myapp');
    }
}
