<?php

namespace Suyabay\Http\Controllers;

use Storage;
use Session;
use Cloudder;
use Validator;
use Suyabay\Channel;
use Suyabay\Episode;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Aws\Exception\AwsException as AWS;
use Illuminate\Database\QueryException;
use Aws\S3\Exception\S3Exception as S3;
use Suyabay\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Filesystem;

class EpisodeManager extends Controller
{

    protected $mail;

    /**
     * Id of 1 is for a regular users
     */
    const REGULAR_USER  = 1;

    /**
     * Id 2 is for premium admin users
     */
    const PREMIUM_USER  = 2;

    /**
     * Id of 3 is for super admin users
     */
    const SUPER_ADMIN   = 3;


    /**
     * Default avatar for episodes
     */
    const DEFUALT_COVER_IMAGE = 'http://goo.gl/8sorZR';

    /**
     * Returns episodes to view all episodes on admin dashbaord
     * @return
     */
    public function index()
    {
        $episodes = $this->episodeRepository->getAllEpisodes();

        return view('dashboard.pages.view_episodes', compact('episodes'));
    }

    /**
     * Get all Episode that belongs to a partticular channel
     */
    public function getEpisode($id)
    {
        $channels = $this->channelRepository->getAllChannels();

        $episodes = $this->episodeRepository->findEpisodeWhere('channel_id', $id)->paginate(5);

        $favorites = $this->likeRepository->getNumberOfUserFavorite();

        return view('app.pages.episodes', compact('episodes', 'channels', 'favorites'));

    }


    /**
    * Display the admin dashboard view
    *
    * @return \Illuminate\Http\Response
    */
    public function stats()
    {
        $data = [

            "user"      =>
            [
                "total"     =>      $this->userRepository->getAllUsers(),
                "online"    =>      $this->userRepository->getOnlineUsers()->count(),
                "offline"   =>      $this->userRepository->getOfflineUsers()->count()
            ],

            "episodes"  =>
            [
                "recent"    => $this->episodeRepository->getAllEpisodes(),
                "active"    => $this->episodeRepository->getActiveEpisodes(),
                "pending"   => $this->episodeRepository->getPendingEpisodes()
            ],

            "channels"  => $this->channelRepository->getAllChannels()
        ];

        return view('dashboard.pages.stats', compact('data'));
    }


    /**
    * return channels list to create_episode view
    *
    * @param  none
    * @return
    */
    public function createEpisode()
    {
        $channels = $this->channelRepository->getAllChannels();

        return view('dashboard.pages.create_episode', compact('channels'));
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $channels   = $this->channelRepository->getAllChannels();
        $episode    = $this->episodeRepository->findEpisodeById($id);

        return view('dashboard.pages.edit_episode', compact('episode', 'channels'));
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
        try {
            $update = Episode::where('id', $request->episode_id)->update(['episode_name' => $request->episode, 'episode_description' => $request->description, 'channel_id' => $request->channel_id]);

            $this->response =['message' => 'Success', 'status_code'   => 200];

        } catch (QueryException $e) {
            $this->response =['message' => $e->getMessage(), 'status_code'   => 400];
        }

        return $this->response;
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title'         => 'required|min:3',
            'description'   => 'required',
            'channel'       => 'required',
            'podcast'       => 'required|size_format|mimes:mpga'
        ]);

        $file = $request->file('podcast');

        $data    = [
            'episode_name'          => $request->title,
            'episode_description'   => $request->description,
            'channel_id'            => $request->channel,
            'image'                 => self::DEFUALT_COVER_IMAGE,
            'audio_mp3'             => $this->upload->audioToAWS($request->file('podcast')),
            'view_count'            => 0,
            'status'                => 0
        ];

        $this->episodeRepository->createEpisode($data);

        return redirect()->back()->with('status', 'Nice Job! ' . $request->title . ' is held for moderation.');
    }

    /**
     * Deleted selected episode
     * @param  Request $request
     * @param  Int $id Episode Id to be deleted
     * @return
     */
    public function destroy(Request $request, $id)
    {
        $episode = Episode::where('id', $id)->delete();

        return redirect()->back();
    }

    /**
     * Update the selected episode
     * @param  Request $request
     * @return
     */
    public function updateEpisodeStatus(Request $request)
    {
        $episode_id     = $request['episode_id'];
        $episode        = $this->episodeRepository->findEpisodeWhere("id", $episode_id)->update(['status' => 1]);

        if ($episode  === 1) {
            $data = [
                "status"    => 200,
                "message"   => "Episode successfully updated"
            ];
        }

        if ($episode  === 0) {
            $data = [
                "status"    => 401,
                "message"   => "episode can not be updated"
            ];
        }

        return $data;
    }

    /**
    * Send email notification
    * @param  none
    * @param $request
    * @return none
    */
    public function sendNotification(Request $request)
    {
        foreach ($this->adminEmails() as $key => $admin) {
            $this->mail->queue('emails.notification', ['title' => $request->title, 'description' => $request->description, 'channel' => $this->getSelectedChannelName($request)], function ($message) use ($admin) {
                $message->from(getenv('SENDER_ADDRESS'), 'New Episode Notification!');
                $message->to($admin->email, $admin->username)->subject('New Notification!');
            });
        }
    }

    /**
    * fetch the admin emails from the users table
    *
    * @param  none
    * @return \Illuminate\Support\Collection
    */
    public function adminEmails()
    {
        return User::where('role_id', '>', self::PREMIUM_USER)->get();
    }

    /**
    * fetch the title of the selected channel
    *
    * @param $request
    * @return \Illuminate\Support\Collection
    */
    public function getSelectedChannelName(Request $request)
    {
        $id = $request->channel;
        $channel = Channel::whereId($id)->first();

        return $channel->channel_name;
    }
}
