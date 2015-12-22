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
use Illuminate\Contracts\Filesystem\Filesystem;

class EpisodeManager extends Controller
{
    protected $mail;

    /**
     * Id of 1 is for a regular users
     */
    const REGULAR_USER = 1;

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
        $this->mail = $mail;
    }

    /**
    * Display a listing of the resource to view_episodes
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $episodes = Episode::all();

        return view('dashboard/pages/view_episodes', compact('episodes'));
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
        $channels = Channel::all();

        return view('dashboard/pages/create_episode', compact('channels'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $this->sendNotification($request);
        die();
        $v = Validator::make($request->all(), [
            'title'         => 'required|min:3',
            'description'   => 'required|min:50',
            'channel'       => 'required',
            'cover'         => 'required',
            'podcast'       => 'required|size_format'
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        try {
            $podcast = $this->uploadAudioFileToS3($request);
            $cover = $this->uploadImageFileToCloudinary($request->cover);
        } catch (S3 $e) {
            return redirect('dashboard/episode/create')->with('status', $e->getMessage());
        } catch (AWS $e) {
            return redirect('dashboard/episode/create')->with('status', $e->getMessage());
        }

        Episode::create([
            'episode_name'         => $request->title,
            'episode_description'  => $request->description,
            'image'                => $cover,
            'audio_mp3'            => $podcast,
            'view_count'           => 0,
            'channel_id'           => $request->channel,
            'status'               => 0
        ]);

        $this->sendNotification($request);

        return redirect('dashboard/episode/create')
        ->with('status', 'Nice Job! ' . $request->title . ' is held for moderation.');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $episode = Episode::find($id);
        $channels = Channel::all();

        return view('dashboard/pages/edit_episode')
        ->with('episode', $episode)->with('channels', $channels);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        try {
            $episode = Episode::find($id);
            $episode->episode_name = $request->title;
            $episode->episode_description = $request->description;
            $episode->channel_id = $request->channel;
            $episode->save();
            //redirect
            return back()->with('status', 'Updated!');
        } catch (QueryException $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    /**
    * Deletes episode
    *
    * @param  int $id
    * @return
    */
    public function destroy($id)
    {
        Episode::find($id)->delete();

        return back()->with('status', 'Deleted!');
    }

    /**
    * Upload image to cloudinary
    *
    * @param  \Illuminate\Http\Request  $request
    * @return
    */
    protected function uploadImageFileToCloudinary($cover)
    {
        Cloudder::upload($cover, null, ["width" => 500, "height" => 375, "crop" => "scale"]);
        $coverUrl = Cloudder::getResult()['url'];

        return $coverUrl;
    }

    /**
    * Upload audio to amazon S3
    *
    * @param  \Illuminate\Http\Request  $request
    * @return
    */
    public function uploadAudioFileToS3(Request $request)
    {
        $fileName = time() . '.' . $request->podcast->getClientOriginalExtension();
        $s3 = Storage::disk('s3');

        // Upload large files
        $s3->put($fileName, fopen($request->podcast, 'r+'));

        return $s3->getDriver()->getAdapter()->getClient()->getObjectUrl('suyabay', $fileName);
    }

    /**
    * Send email notification
    * domain_name helper function
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
