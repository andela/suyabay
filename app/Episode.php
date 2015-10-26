<?php

namespace Suyabay;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = array('episode_name', 'episode_description', 'view_count');
}
