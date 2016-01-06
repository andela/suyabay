<?php

namespace Suyabay\Http\Repository;

use Suyabay\Episode;

class EpisodeRepository 
{
	
    /**
    * Return all episode from the database
    */
    public function getAllEpisode($id)
    {
        return Episode::find($id);
    }
    
    /**
    * Find episode by id
    */
    public function findEpisodeById()
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
    * Return pending episode from the database
    */
    public function getPendingEpisode()
    {
    	return $this->getAllEpisode()->where('status', 1);
    }


}