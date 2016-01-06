<?php

namespace Suyabay\Http\Repository;

use Suyabay\Channel;

class ChannelRepository 
{
	
    /**
    * Return all episode from the database
    */
    public function getAllChannel()
    {
    	return Channel::all();
    }
}