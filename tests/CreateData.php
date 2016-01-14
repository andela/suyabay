<?php

namespace Suyabay\Tests;

use Suyabay\User;
use Suyabay\Channel;
use Suyabay\Episode;
use Suyabay\Password_reset;

trait CreateData
{
    /**
     * Create test user sample data
     */
    public function createUser($role)
    {
        return User::create([
            'username'   => 'test',
            'email'      => 'test@test.com',
            'password'   => 'test',
            'facebookID' => 0,
            'twitterID'  => 0,
            'role_id'    => $role,
            'avatar'     => 'image',
            'active'     => 1
        ]);
    }

    /**
     * Create Password-reset test sample data
     */
    public function createPasswordResetUser()
    {
        return Password_reset::create([
            'email' => 'test@test.com',
            'token' => 12345
            ]);
    }

    /**
     * Create channel test sample data
     */
    public function createChannel()
    {
        return Channel::create([
            'channel_name'         => 'Channel name',
            'channel_description'  => 'Channel description',
            'user_id'              => 1,
            'subscription_count'   => 0
        ]);
    }

    /**
     * Create Episode test sample data
     */
    public function createEpisode()
    {
        return Episode::create([
            'episode_name'          => 'test',
            'episode_description'   => 'test',
            'channel_id'            => 1,
            'view_count'            => 0,
            'image'                 => 'dummy url',
            'audio_mp3'             => 'dummy url',
            'status'                => 0
        ]);
    }
}