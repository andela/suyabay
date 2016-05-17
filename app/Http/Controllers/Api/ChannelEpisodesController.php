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
use Suyabay\Http\Repository\ChannelRepository;
use Suyabay\Http\Transformers\ChannelEpisodesTransformer;

class ChannelEpisodesController extends Controller 
{
    protected $mail;
    protected $fractal;

    public function __construct(Manager $fractal, Mail $mail)
    {
        $this->fractal = $fractal;

        parent::__construct($mail);
    }

    /**
     * This method takes channel name and return all episodes podcast under it.
     * 
     * @param $request
     * @param $name
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllEpisodes(Request $request, $name, ChannelEpisodesTransformer $channelEpisodesTransformer)
    {
        $episodes = null;

        $perPage = $request->query('results') ? : 10;

        $channel = $this->getChannelByName($name);

        if (! is_null($channel)) {
            $episodes = $this->getEpisodesByChannnelId($channel, $perPage, $request);

            $resource = new Collection($episodes, $channelEpisodesTransformer);
            $data = $this->fractal->createData($resource)->toArray();
            dd($data);
        }

        return Response::json([
            'message' => 'Channel not found !'
        ], 404);
    }

    /**
     * This method validate channel request.
     * 
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

    /**
     * This method gets channel details by it's name and 
     * return the channel object.
     * 
     * @param $name
     * 
     * @return Channel
     */
    public function getChannelByName($name)
    {
        return $this->channelRepository
        ->findChannelWhere('channel_name', strtolower(urldecode($name)))
        ->get()
        ->first();
    }

    /**
     * This method return all episodes under a channel.
     * 
     * @param $channel
     * @param $perPage
     * @param $request
     *
     * @return Episode
     */
    public function getEpisodesByChannnelId($channel, $perPage, $request)
    {
        return Episode::orderBy('id', 'asc')
        ->where('episodes.channel_id', $channel->id)
        ->skip($this->getRecordsToSkip($perPage, $request))
        ->take($perPage)
        ->get();
    }
}