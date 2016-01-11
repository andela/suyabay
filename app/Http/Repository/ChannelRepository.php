<?php

namespace Suyabay\Http\Repository;

use Suyabay\Channel;

class ChannelRepository
{

    /**
    * Return all episode from the database
    */
    public function getAllChannels()
    {
        return Channel::all();
    }
}
