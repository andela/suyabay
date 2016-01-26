<?php

namespace Suyabay\Http\Controllers;

use Storage;
use Session;
use Cloudder;
use Validator;
use Suyabay\User;
use Suyabay\Channel;
use Suyabay\Episode;
use Suyabay\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer as Mail;
use Illuminate\Database\QueryException;
use Aws\S3\Exception\S3Exception as S3;
use Aws\Exception\AwsException as AWS;
use Suyabay\Http\Controllers\Controller;
use Suyabay\Http\Repository\UserRepository;
use Suyabay\Http\Repository\EpisodeRepository;
use Suyabay\Http\Repository\FilesRepository;
use Suyabay\Http\Repository\ChannelRepository;
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

    public function __construct(Mail $mail)
    {
        $this->middleware('auth');
        $this->mail                 = $mail;
        $this->userRepository       = new UserRepository;
        $this->episodeRepository    = new EpisodeRepository;
        $this->channelRepository    = new ChannelRepository;
        $this->upload               = new FilesRepository;
    }

    public function index()
    {
        $episodes = $this->episodeRepository->getAllEpisodes();
        return view('dashboard.pages.view_episodes', compact('episodes'));
    }

    /**
    * Display a listing of the resource to view_episodes
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
    * Show create episode view
    */
    public function showIndex()
    {
        return view('dashboard.pages.create_episode');
    }

    /**
    * return channels list to create_episode view
    *
    * @param  none
    * @return
    */
    public function showChannelsForCreate()
    {
        $channels = $this->channelRepository->getAllChannels();

        return view('dashboard.pages.create_episode', compact('channels'));
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
            'cover'         => 'required',
            'podcast'       => 'required|size_format'
        ]);

        $data    = [
            'episode_name' => $request->title,
            'episode_description' => $request->description,
            'channel_id' => $request->channel,
            'image' => $this->upload->imageToCloudinary($request->cover),
            'audio_mp3' => $this->upload->videoToCloudinary($request->podcast),
            'view_count' => 0,
            'status' => 0
        ];

        $this->episodeRepository->createEpisode($data);

        return redirect()->back()->with('status', 'Nice Job! ' . $request->title . ' is held for moderation.');
    }

    public function destroy(Request $request)
    {
        $episode_id  = $request['episode_id'];
        $episode     = $this->episodeRepository->findEpisodeWhere("id", $episode_id)->delete();

        if ($episode  === 1) {
            $data = [
                "status"    => 200,
                "message"   => "Episode successfully deleted"
            ];
        }

        if ($episode  === 0) {
            $data = [
                "status"    => 401,
                "message"   => "Episode can not be deleted"
            ];
        }

        return $data;
    }

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
