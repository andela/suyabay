<?php
namespace Suyabay;

use Suyabay\Episode;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'channels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['channel_name', 'channel_description', 'subscription_count', 'user_id'];

    /**
     * Channel/Episode relationship
     */
    public function episodes()
    {
        return $this->hasMany('Suyabay\Episode');
    }

}
