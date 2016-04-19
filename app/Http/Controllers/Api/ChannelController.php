<?php

namespace Suyabay\Http\Controllers\Api;

use DB;
use Validator;
use Suyabay\Channel;
use Suyabay\Http\Requests;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Response;
use Suyabay\Http\Controllers\Controller;
use Suyabay\Http\Transformers\ChannelTransformer;

class ChannelController extends Controller
{
    protected $mail;
    protected $response;
    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /*
     * This method lists all channels 
     * @param $page
     * @param $request
     * @param $response
     *
     * @return json $response
     */
    public function getAllChannels(Request $request, ChannelTransformer $channelTransformer)
    {
        $perPage = $request->query('results') ? : 10;

        $channels = Channel::orderBy('id', 'asc')
        ->skip($this->getRecordsToSkip($perPage, $request))
        ->take($perPage)
        ->get();

        $resource = new Collection($channels, $channelTransformer);
        $data = $this->fractal->createData($resource)->toArray();

        if (count($data['data']) > 0) {
            return Response::json($data, 200);

        }

        return Response::json(['message' => 'Channels are not available for display'], 404);

    }

    /**
     * This method get a single channel
     *
     * @param $channel_name
     *
     * @return json $response
     */
    public function getAChannel($channel_name, ChannelTransformer $channelTransformer)
    {
        $channel = Channel::where('channel_name', '=', $channel_name)
        ->orWhere('channel_name', '=', strtolower($channel_name))
        ->orderBy('id', 'asc')
        ->first();

        if (! is_null($channel)) {
            $resource = new Item($channel, $channelTransformer);
            $data = $this->fractal->createData($resource)->toArray();

            return Response::json($data, 200);

        } 

        return Response::json(['message' => 'Channel not found'], 404);

    }

    /**
     * This method creates a new channel
     *
     * @param $request
     *
     * @return $response
     */
    public function postAChannel(Request $request)
    {
        $userId = 1;// The id of the user gotten from the token

        if ($this->validateUserRequestForEmptyFields($request)) {
            return Response::json(['message' => 'All fields are required'], 400);

        }

        if ($this->validateUserRequest($request)) {
            return Response::json(['message' => 'Channel already exists'], 400);

        } 

        $channel = Channel::create([
            'channel_name' => $request->input('channel_name'),
            'channel_description' => $request->input('channel_description'),
            'created_at' => date('Y-m-d h:i:s'),
            'user_id' => $userId,
        ]);

        if (count($channel) > 0) {
            return Response::json(['message' => 'Channel created successfully'], 201);
        }
    }

    /**
     * This method updates a channel using PUT verb
     *
     * @param $channel_name
     * @param $channel_description
     *
     * @return $response
     */
    public function editAChannel(Request $request, $channel_name)
    {
        if ($this->validateUserRequestForEmptyFields($request)) {
            return Response::json(['message' => 'All fields are required'], 400);

        }

        $channel = Channel::where('channel_name', '=', $channel_name)
        ->orWhere('channel_name', '=', strtolower($channel_name))
        ->first();

        if ($this->processEditChannel($request, $channel)) {
            return Response::json(['message' => 'Channel updated successfully'], 200);

        }

        return Response::json([
            'message' => 'Channel cannot be updated because the channel name is incorrect'
        ], 404);

    }

    /**
     * This method updates a channel using PATCH verb
     *
     * @param $channel_name
     *
     * @return $response
     */
    public function editASingleChannelResource(Request $request, $channel_name)
    {
        if ($this->validateUserRequestForPatchRequest($request)) {
            return Response::json(['message' => 'All fields are required'], 400);

        }

        $channel = Channel::where('channel_name', '=', $channel_name)
        ->orWhere('channel_name', '=', strtolower($channel_name))
        ->first();

        if ($this->processEditChannelForPatchRequest($request, $channel)) {
            return Response::json(['message' => 'Channel updated successfully'], 200);

        }

        return Response::json([
            'message' => 'Channel cannot be updated because the channel name is incorrect'
        ], 404);

    }

    /**
     * This method completes the processing of editing user using PUT verb
     *
     * @param $request
     * @param $channel
     *
     * @return $response
     */
    public function processEditChannel($request, $channel)
    {
        if (! is_null($channel)) {
            DB::table('channels')
            ->where('id', '=', $channel->id)
            ->update([
                'channel_name' => $request->input('channel_name'),
                'channel_description' => $request->input('channel_description'),
                'updated_at' => date('Y-m-d h:i:s'),
            ]);

            return true;

        }
        return false;

    }

    /**
     * This method completes the processing of editing user using PATCH verb
     *
     * @param $request
     * @param $channel
     *
     * @return $response
     */
    public function processEditChannelForPatchRequest($request, $channel)
    {
        if (! is_null($channel)) {
            DB::table('channels')
            ->where('id', '=', $channel->id)
            ->update([
                'channel_name' => $request->input('channel_name'),
                'updated_at' => date('Y-m-d h:i:s'),
        ]);
            return true;
            
        }
        return false;

    }

    /**
     * This method valdates the user request
     *
     * @param $request
     *
     * @return json $response
     */
    public function validateUserRequestForEmptyFields($request)
    {
        $validator = Validator::make($request->all(), [
            'channel_name' => 'required',
            'channel_description' => 'required',
        ]);

        if ($validator->fails()) {
            return true;

        }
    }

    /**
     * This method validates the user request
     *
     * @param $request
     *
     * @return boolean true
     */
    public function validateUserRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'channel_name' => 'required|unique:channels|max:50',
            'channel_description' => 'required|max:160',
        ]);

        if ($validator->fails()) {
            return true;

        }
    }

    /**
     * This method validates the user request
     *
     * @param $request
     *
     * @return boolean true
     */
    public function validateUserRequestForPatchRequest($request)
    {
        $validator = Validator::make($request->all(), [
            'channel_name' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            return true;

        }
    }

    /**
     * This method validate channel request
     * @param $pageLimit
     * @param $request
     *
     * @return $recordsToSkip
     */
    public function getRecordsToSkip($pageLimit, $request)
    {
        $page = $request->query('page') ? : 1;
        $recordsToSkip = (int) ($pageLimit * $page) - $pageLimit;

        return $recordsToSkip;
    }
}