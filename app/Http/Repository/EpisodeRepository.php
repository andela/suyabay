<?php

namespace Suyabay\Http\Repository;

use Suyabay\Episode;

class EpisodeRepository
{

    /**
    * Return all episode from the database
    */
    public function getAllEpisode()
    {
        return Episode::all();
    }

    /**
    * Find episode by id
    */
    public function findEpisodeById($id)
    {
        return Episode::find($id);
    }

    /**
    * Find episode where
    */
    public function findEpisodeWhere($field, $id)
    {
    	return Episode::where($field, $id);
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