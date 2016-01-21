<?php

namespace Suyabay\Http\Repository;

use Suyabay\Channel;

class ChannelRepository
{

    public function find($id)
    {
        return Channel::find($id);
    }

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

    public function restoreChannel($id)
    {
        Channel::withTrashed()
        ->where('id', $id)
        ->restore();
    }
}
