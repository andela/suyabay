<?php

namespace Suyabay\Http\Repository;

use Suyabay\Episode;

class EpisodeRepository
{

    /**
    * Return all episode from the database
    */
    public function getAllEpisodes()
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
    * Find episode via field = value
    */
    public function findEpisodeWhere($field, $value)
    {
        return Episode::where($field, $value)->get();
    }

    /**
    * Return active episode from the database
    */
    public function getActiveEpisodes()
    {
        return $this->getAllEpisodes()->where('status', 1);
    }

    /**
    * Return pending episode from the database
    */
    public function getPendingEpisodes()
    {
        return $this->getAllEpisodes()->where('status', 1);
    }

    /**
     * [createEpisode description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function createEpisode($data)
    {
        Episode::create($data);
    }

    /**
     * [updateEpisode description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function updateEpisode($id, $field, $value)
    {
        $this->findEpisodeById($id)->update([$field => $value]);
    }
}
