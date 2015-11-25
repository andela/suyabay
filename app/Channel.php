<?php
namespace Suyabay;

use Suyabay\Episode;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function episodes()
    {
        return $this->hasMany('Suyabay\Episode');
    }

}
