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
    public function index()
    {
        $channels = Channel::orderBy('id', 'asc')->paginate(10);

        return view('dashboard.pages.view_channels', compact('channels'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createIndex()
    {
        return view('dashboard.pages.create_channel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $channel = Channel::create([
            'channel_name'         => $request->name,
            'channel_description'  => $request->description,
            'subscription_count'   => 0
        ]);
        if ($channel)
            return 100;
    }

    /**
     * Check if the channel name already exist
     *
     * @param  $request
     * @return bool
     */
    public function checkChannelExist(Request $request)
    {
        $check = Channel::where('channel_name', $request->name)->first();
        if ($check)
            return true;
    }

    /**
     * Process the request and return result for ajax call
     *
     * @param  $request
     * @return int
     */
    public function processCreate(Request $request)
    {
        if ($this->checkChannelExist($request))
            return 101; //Channel aready exist

        return $this->create($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request)
    {
        $updateChannel = Channel::where('id', $request->channel_id)->update(['channel_name' => $request->channel_name, 'channel_description' => $request->channel_description]);
        if ($updateChannel)
            return 200; // success

        return 201; // Unable to update
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteChannel = Channel::where('id', $id)->delete();
        if ($deleteChannel)
            return 300; // Success

        return 301; // unable to delete
    }
}
