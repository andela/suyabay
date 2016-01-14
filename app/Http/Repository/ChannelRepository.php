<?php

namespace Suyabay\Http\Repository;

use Suyabay\Channel;

class ChannelRepository
{

    /**
    * Return all channel from the database
    */
    public function getAllChannels()
    {
        return Channel::all();
    }

    /**
     * Return channels by order
     */
    public function getOrderedChannels($value, $order_by)
    {
    	return Channel::orderBy($value, $order_by);
    }

    /**
     * Return channel for a particular field
     */
    public function getChannelByField($field, $value)
    {
    	return Channel::where($field, $value);
    }
}
