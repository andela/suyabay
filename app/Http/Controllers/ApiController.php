<?php

namespace Suyabay\Http\Controllers;

class ApiController extends Controller
{
    public function index()
    {
        return view('api.index');
    }

    public function docs()
    {
        return view('suyabay.readthedocs.org');
    }
}
