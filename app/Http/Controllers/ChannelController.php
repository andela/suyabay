<?php

namespace Suyabay\Http\Controllers;

use Auth;
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
     * Return all channels
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channel::withTrashed()->orderBy('id', 'desc')->paginate(10);

        return view('dashboard.pages.view_channels', compact('channels'));
    }

    /**
     * Return only active channels
     * @return \Illuminate\Http\Response
     */
    public function active()
    {
        $channels = $this->channelRepository->getOrderedChannels('id', 'desc')->paginate(10);

        return view('dashboard.pages.view_channels', compact('channels'));
    }

    /**
     * Return only deleted channels
     * @return \Illuminate\Http\Response
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

    public function channelList()
    {
        $channels = $this->channelRepository->getAllChannels();

        return view('app.pages.channel', compact('channels'));
    }

    /**
     * Process channel creation
     */
    public function processCreate(Request $request)
    {
        $this->validate($request, [
            'channel_name' => 'required|max:255|unique:channels',
            'channel_description' => 'required',
        ]);

        $channel = Channel::create([
            'channel_name'         => $request->channel_name,
            'channel_description'  => $request->channel_description,
            'user_id'              => Auth::user()->id,
            'subscription_count'   => 0
        ]);

        return redirect('dashboard/channel/' . $channel->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $channels = $this->channelRepository->findChannelWhere('id', $id)->first();

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
            $updateChannel = $this->channelRepository->findChannelWhere('id', $request->channel_id)->update(['channel_name' => $request->channel_name, 'channel_description' => $request->channel_description]);

            if ($updateChannel) {
                $this->response =
                [
                    'message'     => 'Channel updated Successfully',
                    'status_code' => 200
                ];
            } else {
                $this->response =
                [
                    'message'     => 'Unable to update channel',
                    'status_code' => 400
                ];
            }
        } catch (QueryException $e) {
            $this->response =
            [
                'message'     => 'Channel name already exist',
                'status_code' => 400
            ];
        }

        return $this->response;
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     */
    public function destroy($id)
    {
        try {
            $this->channelRepository->deleteChannel($id);
            Episode::where('channel_id', $id)->update(['flag' => 1]);

            $this->response =
            [
                'message'     => 'Channel deleted Successfully',
                'status_code' => 200
            ];
        } catch (QueryException $e) {

            $this->response =
            [
                'message'     => $e->getMessage(),
                'status_code' => 400
            ];
        }

        return $this->response;
    }

    /**
     * restore soft deleted channel
     * @param int $id
     */
    public function restore($id)
    {
        $this->channelRepository->restoreChannel($id);
        Episode::where('channel_id', $id)->update(['flag' => 0]);

        return redirect()->back();
    }

    /**
     * Return selected channel with all episodes under it
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showChannel($id)
    {
        $channel = Channel::find($id);
        $episodes = Episode::where('channel_id', '=', $id)->get();

        return view('dashboard.pages.view_channel')->with('channel', $channel)->with('episodes', $episodes);
    }

    /**
     * return view to swap episodes to another channel
     * @param int $id
     * @return
     */
    public function swap($id)
    {
        $channels   = Channel::where('id', '!=', $id)->get();
        $channel    = Channel::where('id', $id)->first();

        return view('dashboard.pages.swap_episodes', compact('channels', 'id', 'channel'));
    }

    /**
     * move episodes from source to destination
     * @param  [type] $id [description]
     * @return [type]     [description]
     */

    public function processSwap(Request $request)
    {
        try {
            $swap = Episode::where('channel_id', $request->channel_id)->update(['channel_id' => $request->new_channel_id]);
            $this->channelRepository->deleteChannel($request->channel_id);
            Episode::where('channel_id', $request->channel_id)->update(['flag' => 1]);
            $this->response = ['message' => 'Episodes swapped and Channel deleted Successfully!', 'status_code' => 200];
        } catch (QueryException $e) {
            $this->response = [
                'message'       => 'Channel already exist',
                'status_code'   => 400
            ];
        }

        return $this->response;
    }
}
