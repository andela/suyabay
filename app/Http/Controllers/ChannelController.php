<?php

namespace Suyabay\Http\Controllers;

use Suyabay\Channel;
use Suyabay\Episode;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Suyabay\Http\Controllers\Controller;

class ChannelController extends Controller
{
    protected $response;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channel::all();

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
     * Process channel creation
     */
    public function processCreate(Request $request)
    {
        try {
            $channel = Channel::create([
                'channel_name'         => $request->name,
                'channel_description'  => $request->description,
                'subscription_count'   => 0
            ]);
            $this->response =
            [
                'message' => 'Channel created Successfully',
                'status_code' => 200
            ];
        } catch (QueryException $e) {
            $this->response =
            [
                'message' => 'Channel already exist',
                'status_code' => 400
            ];
        }

        return $this->response;
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
        try {
            $updateChannel = Channel::where('id', $request->channel_id)->update(['channel_name' => $request->channel_name, 'channel_description' => $request->channel_description]);

            if ($updateChannel) {
                $this->response =
                [
                    'message' => 'Channel updated Successfully',
                    'status_code' => 200
                ];
            } else {
                $this->response =
                [
                    'message' => 'Unable to update channel',
                    'status_code' => 400
                ];
            }
        } catch (QueryException $e) {
            $this->response =
            [
                'message' => 'Channel name already exist',
                'status_code' => 400
            ];
        }

        return $this->response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $deleteChannel = Channel::where('id', $id)->delete();

        if ($deleteChannel) {
            $this->response =
            [
                "message"       => "Channel deleted successfully",
                "status_code"   => 200
            ];
        } else {
            $this->response =
            [
                "message"       => "Unable to delete channel",
                "status_code"   => 400
            ];
        }

        return $this->response;
    }

    public function showChannel($id)
    {
        $channel = Channel::find($id);
        $episodes = Episode::where('channel_id', '=', $id)->get();
        
        return view('dashboard.pages.view_channel')->with('channel', $channel)->with('episodes', $episodes);
    }
}
