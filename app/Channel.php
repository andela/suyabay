<?php
namespace Suyabay;

use Suyabay\Episode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

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
    public function user()
    {
        return $this->belongsTo('Suyabay\User');
    }

    public function episode()
    {
        return $this->hasMany('Suyabay\Episode');
    }
}
