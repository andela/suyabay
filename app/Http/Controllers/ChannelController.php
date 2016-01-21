<?php

namespace Suyabay\Http\Controllers;

use Auth;
use Suyabay\Channel;
use Suyabay\Episode;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Suyabay\Http\Controllers\Controller;
use Suyabay\Http\Repository\ChannelRepository;

class ChannelController extends Controller
{
    protected $response;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct(ChannelRepository $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Return all channels
     * @return [type] [description]
     */
    public function index()
    {
        $channels = Channel::withTrashed()->orderBy('id', 'desc')->paginate(10);

        return view('dashboard.pages.view_channels', compact('channels'));
    }

    /**
     * Return only active channels
     * @return [type] [description]
     */
    public function active()
    {
        $channels = Channel::orderBy('id', 'desc')->paginate(10);

        return view('dashboard.pages.view_channels', compact('channels'));
    }

    /**
     * Return only deleted channels
     * @return [type] [description]
     */
    public function deleted()
    {
        $channels = Channel::onlyTrashed()->orderBy('id', 'desc')->paginate(10);

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
                'subscription_count'   => 0,
                'user_id'              => Auth::user()->id
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
        $this->channel->deleteChannel($id);

        return redirect('/dashboard/channels/all');
    }

    /**
     * [showChannel description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function showChannel($id)
    {
        $channel = Channel::find($id);
        $episodes = Episode::where('channel_id', '=', $id)->get();
        
        return view('dashboard.pages.view_channel')->with('channel', $channel)->with('episodes', $episodes);
    }
}
