<?php

namespace Suyabay\Http\Controllers\Api;

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
use Suyabay\Http\Repository\EpisodeRepository;
use Suyabay\Http\Transformers\ChannelEpisodesTransformer;

class ChannelEpisodesController extends Controller
{
    use Utility\Utility;

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
    public function getAllEpisodes($name, Request $request, ChannelEpisodesTransformer $channelEpisodesTransformer)
    {
        $episodes = null;

        $perPage = $request->has('limit') ? (int) $request->input('limit') : 10;

        $channel = $this->getChannelByName($name);

        if (! is_null($channel)) {
            $episodes = $this->getEpisodesByChannnelId($channel, $perPage, $request);

            if (! is_null($episodes)) {
                $episodesWithComments = $this->formatEpisodes($episodes);
                $resource = new Collection($episodesWithComments, $channelEpisodesTransformer);
                $data = $this->fractal->createData($resource)->toArray();

                return Response::json($data, 200);
            }

            return Response::json(['message' => 'Channel does not have episodes yet'], 404);

        }

        return Response::json(['message' => 'Channel not found!'], 404);
    }

    /**
     * This method returns the channel episode details.
     *
     * @param $request
     * @param $channelName
     * @param $episodeName
     * @param $channelEpisodesTransformer
     *
     * @return \Illuminate\Http\Response
     */
    public function getAChannelEpisode($channelName, $episodeName, Request $request, ChannelEpisodesTransformer $channelEpisodesTransformer)
    {
        $episode = null;

        $channel = $this->getChannelByName($channelName);

        if (! is_null($channel)) {
            $episode = $this->getEpisodeByName($episodeName, $channel);

            if (count($episode) <= 0) {
                return Response::json(['message' => 'Episode not found!'], 404);
            }

            $data = $this->createTransformerData($episode, $channelEpisodesTransformer);

            return Response::json($data, 200);

        }

        return Response::json(['message' => 'Channel not found!'], 404);

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

    /**
     * This method takes episode model and appends comments to each of them.
     *
     * @param $episodes
     *
     * @return Episode
     */
    public function formatEpisodes($episodes)
    {
        foreach ($episodes as $key => &$value) {
            $newEpisodes = $episodes->find($value->id)->first();
            $comments = $newEpisodes->comment()->count();
            $value['comments'] = $comments;
        }

        return $episodes;
    }

    /**
     * This method returns episodes under a particular channel.
     * @param $channel
     * @param $episodeName
     *
     * @return Episode
     */
    public function getEpisodeByName($episodeName, $channel)
    {
        return $this->episodeRepository
        ->findEpisodeWhere('episode_name', strtolower(urldecode($episodeName)))
        ->where('channel_id', $channel->id)
        ->get();
    }

    /**
     * This method transforms the episode details.
     *
     * @param $episode
     * @param $channelEpisodesTransformer
     *
     * @return Manager
     */
    public function createTransformerData($episode, $channelEpisodesTransformer)
    {
        $episodeWithComments = $this->formatEpisodes($episode);
        $resource = new Item($episodeWithComments->first(), $channelEpisodesTransformer);

        return $this->fractal->createData($resource)->toArray();

    }
}
