<?php

namespace Suyabay\Http\Controllers;

use Suyabay\User;
use Suyabay\Channel;
use Suyabay\Episode;
use Illuminate\Mail\Mailer as Mail;
use Suyabay\Http\Repository\UserRepository;
use Suyabay\Http\Repository\LikeRepository;
use Suyabay\Http\Repository\FilesRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Suyabay\Http\Repository\EpisodeRepository;
use Suyabay\Http\Repository\ChannelRepository;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Mail $mail)
    {
        $this->mail                 = $mail;
        $this->userRepository       = new UserRepository;
        $this->episodeRepository    = new EpisodeRepository;
        $this->channelRepository    = new ChannelRepository;
        $this->likeRepository       = new LikeRepository;
        $this->upload               = new FilesRepository;
    }
}
