<?php

namespace Suyabay\Http\Repository;

use Suyabay\Episode;

class ChannelRepository 
{
	
    /**
    * Return all episode from the database
    */
    public function getAllEpisode()
    {
    	return Episode::all();
    }
	
    /**
    * Return active episode from the database
    */
    public function getActiveEpisode()
    {
    	return $this->getAllEpisode()->where('status', 1);
    }
	
    /**
    * Return active episode from the database
    */
    public function getPendingEpisode()
    {
    	return $this->getAllEpisode()->where('status', 1);
    }


}