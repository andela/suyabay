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

    /**
     * [findChannel description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteChannel($id) 
    {
        Channel::find($id)->delete();
    }
}
