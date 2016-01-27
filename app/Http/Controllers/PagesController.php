<?php

namespace Suyabay\Http\Controllers;

use Suyabay\Http\Requests;
use Illuminate\Http\Request;
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
        $channels = $this->channelRepository->getAllChannels();

        return view('app.pages.about' compact('channels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faqs()
    {
        $channels = $this->channelRepository->getAllChannels();

        return view('app.pages.faqs' compact('channels'));
    }

    public function privacyPolicy()
    {
        $channels = $this->channelRepository->getAllChannels();
        
        return view('app.pages.privacypolicy' compact('channels'));
    }


}
