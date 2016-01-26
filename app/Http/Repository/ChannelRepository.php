<?php

namespace Suyabay\Http\Repository;

use Suyabay\Channel;

class ChannelRepository
{
    /**
     * Find a particular channel by its id
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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
    * Find channel via field = value
    */
    public function findChannelWhere($field, $value)
    {
        return Channel::where($field, $value);
    }

    /**
     * delete a channel based on $id
     * @param  int $id
     */
    public function deleteChannel($id) 
    {
        $this->find($id)->delete();
    }

    /**
     * restore soft deleted chanel
     * @param int $id
     */
    public function restoreChannel($id)
    {
        Channel::withTrashed()->where('id', $id)->restore();
    }
}
