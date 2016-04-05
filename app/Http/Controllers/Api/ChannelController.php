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
        $perPage = $request->query('results') ? : 2;

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
        $channels = Channel::where('channel_name', '=', $channel_name)
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

         $resource = new Item($channels, new ChannelTransformer());
         $data = $this->fractal->createData($resource)->toArray();

         if (count($data['data']) > 0) {
            return Response::json($data, 200);

        }
        
        return Response::json(['message' => 'Channel is not available for display'], 404);

    }

    public function getRecordsToSkip($perPage, $request)
    {
        $page = $request->query('page') ? : 1;
        $recordsToSkip = (int) ($perPage * $page) - $perPage;

        return $recordsToSkip;
    }
}
