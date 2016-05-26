<?php

namespace Suyabay\Http\Controllers\Api;

use DB;
use Validator;
use Suyabay\Channel;
use Suyabay\Episode;
use Suyabay\Http\Requests;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use Illuminate\Mail\Mailer as Mail;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Response;
use Suyabay\Http\Controllers\Controller;
use Suyabay\Http\Repository\UserRepository;
use Suyabay\Http\Transformers\ChannelTransformer;

class ChannelController extends Controller
{
    protected $mail;
    protected $response;
    protected $fractal;

    public function __construct(Manager $fractal, Mail $mail)
    {
        $this->fractal = $fractal;

        parent::__construct($mail);
    }

    /**
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

        $channels = Channel::with('episode')->orderBy('channels.id', 'asc')
        ->skip($this->getRecordsToSkip($perPage, $request))
        ->take($perPage)
        ->get();

        $channels = $this->formatChannel($channels);

        $resource = new Collection($channels, $channelTransformer);

        $data = $this->fractal->createData($resource)->toArray();

        if (count($data['data']) > 0) {
            return Response::json($data, 200);

        }

        return Response::json([
            'message' => 'Channels are not available for display'
        ], 404);

    }

    public function formatChannel($channels)
    {
        foreach ($channels as $key => &$value) {
            $pending = Channel::pendingEpisodes($value->id)->count();
            $active  = Channel::activeEpisodes($value->id)->count();
            $value['user_id'] = UserRepository::findUser($value->user_id)->username;
            // if ($pending != 0 || $active != 0) {
            //     $value['episode'] = compact('pending', 'active');
            // } else {
            //     $value['episode'] = 0;
            // }

        }
        
        return $channels;
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
        $channel = Channel::with('episode')->orderBy('channels.id', 'asc')
        ->where('channel_name', '=', strtolower(urldecode($channel_name)))
        ->get();

        if (! is_null($channel)) {
            $channel = $this->formatChannel($channel);

            $resource = new Collection($channel, $channelTransformer);
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
            'channel_name' => strtolower($request->input('name')),
            'channel_description' => $request->input('description'),
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

        $channel = Channel::where('channel_name', '=', strtolower(urldecode($channel_name)))
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

        $channel = Channel::where('channel_name', '=', strtolower(urldecode($channel_name)))
        ->first();

        if ($this->processEditChannelForPatchRequest($request, $channel)) {
            return Response::json(['message' => 'Channel updated successfully'], 200);

        }

        return Response::json([
            'message' => 'Channel cannot be updated because the channel name is incorrect'
        ], 404);

    }

    /**
     * This method deletes a channel
     *
     * @param $channel_name
     *
     * @param $request
     *
     * @return $response
     */
    public function deleteASingleChannel(Request $request, $channel_name)
    {
        $channel = Channel::where('channel_name', '=', strtolower(urldecode($channel_name)))
        ->first();

        if (! is_null($channel)) {
            $returnValue = $this->channelRepository->deleteChannel($channel->id);

            if (! is_null($returnValue)) {
                return Response::json([
                    'message' => 'Oop! something went wrong'
                ], 400);

            }

            return Response::json([
            'message' => 'Channel successfully deleted'
            ], 200);

        }

        return Response::json([
            'message' => 'Channel cannot be deleted because the channel name is incorrect'
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
            Channel::where('id', '=', $channel->id)
            ->update([
                'channel_name' => $request->input('name'),
                'channel_description' => $request->input('description'),
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
        $recordToBeUpdated = [];

        if ($request->input('name')) {
            $recordToBeUpdated = [
            'channel_name' => $request->input('name'),
            'updated_at' => date('Y-m-d h:i:s'),
            ];
        } else if ($request->input('description')) {
            $recordToBeUpdated = [
            'channel_description' => $request->input('description'),
            'updated_at' => date('Y-m-d h:i:s'),
            ];
        }

        if (! is_null($channel)) {
            Channel::where('id', '=', $channel->id)
            ->update($recordToBeUpdated);

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
            'name' => 'required',
            'description' => 'required',
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
            'name' => 'required|unique:channels|max:50',
            'description' => 'required|max:160',
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
        $request = $request->all();

        if (empty($request)) {
            return true;
        }

        if (isset($request['name']) &&  $request['name'] == '') {
            return true;
            
        } else if (isset($request['description']) && $request['description'] == '') {
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
