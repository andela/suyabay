<?php

namespace Suyabay\Http\Controllers\Api;

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

    /**
     * This method lists all channels 
     * @param $page
     * @param $request
     * @param $response
     *
     * @return json $response
     */
    public function getAllChannels(Request $request)
    {
        $perPage = $request->query('results') ? : 10;

        $channels = Channel::orderBy('id', 'asc')
        ->skip($this->getRecordsToSkip($perPage, $request))
        ->take($perPage)
        ->get([
            'id',
            'channel_name',
            'channel_description',
            'subscription_count',
            'created_at',
            'updated_at',
            'user_id',
        ]);

         $resource = new Collection($channels, new ChannelTransformer());
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
    public function getAChannel($channel_name)
    {
        $channel = Channel::where('channel_name', '=', $channel_name)
        ->orWhere('channel_name', '=', strtolower($channel_name))
        ->orderBy('id', 'asc')
        ->first([
            'id',
            'channel_name',
            'channel_description',
            'subscription_count',
            'created_at',
            'updated_at',
            'user_id',
        ]);

        if (! is_null($channel)) {
            $resource = new Item($channel, new ChannelTransformer());
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
        if ($this->validateUserRequest($request)) {
            return Response::json(['message' => 'Expected fields not supplied or Channel already exists or may the supplied fields does not contain values'], 400);

        } else {
            $userId = 1;// The id of the user gotten from the token
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
        $channel = Channel::where('channel_name', '=', $channel_name)
        ->orWhere('channel_name', '=', strtolower($channel_name))
        ->first()
        ->toArray();

        if (count($channel) > 0) {
            
        }

        return Response::json([
            'message' => 'Channel cannot be updated because the channel name was incorrect'
        ], 404);
    }

    /**
     * This method valdates the user request
     * 
     * @param $request
     * 
     * @return json $response
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
     * This method validate channel request
     * @param $request
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function getRecordsToSkip($perPage, $request)
    {
        $page = $request->query('page') ? : 1;
        $recordsToSkip = (int) ($perPage * $page) - $perPage;

        return $recordsToSkip;
    }
}
