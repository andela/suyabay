<?php

namespace Suyabay\Http\Controllers;

use Illuminate\Http\Request;
use Suyabay\Http\Requests;
use Suyabay\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        return view('app.pages.about');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faqs()
    {
        return view('app.pages.faqs');
    }

    public function privacyPolicy()
    {
        return view('app.pages.privacypolicy');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
