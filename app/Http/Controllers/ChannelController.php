<?php

namespace Suyabay\Http\Controllers;

use Suyabay\Channel;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Suyabay\Http\Controllers\Controller;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $channels = Channel::orderBy('id', 'asc')->paginate(10);

        return view('dashboard.pages.view_channels', compact('channels'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createIndex ()
    {
        return view('dashboard.pages.create_channel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create (Request $request)
    {
        Channel::create([
            'channel_name'         => $request->name,
            'channel_description'  => $request->description,
            'subscription_count'   => 0
        ]);
    }

    /**
     * Check if the channel name already exist
     *
     * @param  $request
     * @return bool
     */
    public function checkChannelExist (Request $request)
    {
        $check = Channel::where('channel_name', $request->name)->first();
        if( $check )
            return true;
    }

    /**
     * Process the request and return result for ajax call
     *
     * @param  $request
     * @return int
     */
    public function processCreate (Request $request)
    {
        if ( $this->checkChannelExist($request) )
        {
            return 101; //Channel aready exist
        }
        else
        {
            $this->create($request);
            return 100; //success
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id)
    {
        $channels = Channel::where('id', $id)->first();

        return view('dashboard.pages.edit_channel', compact('channels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request)
    {
        $response = "";
        $e = Channel::where('id', $request->channel_id)->update(['channel_name' => $request->channel_name, 'channel_description' => $request->channel_description]);
        if ( $e )
        {
            $response = 200; // success
        } else {
            $response = 201; // Unable to update
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {
        $delete = Channel::where('id', $id)->delete();
        $response = "";
        if ( $delete )
        {
            $response = 300; // Success
        }
        else
        {
            $response = 301; // unable to delete
        }
        return $response;
    }
}
