<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */


Route::get('/', function(){
    return view('app.pages.index');
});

Route::get('about', function(){
    return view('app.pages.about');
});

Route::get('faqs', function(){
    return view('app.pages.faqs');
});

Route::get('privacy-policy', function(){
    return view('app.pages.privacypolicy');
});


