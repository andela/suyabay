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
    protected $fillable = ['channel_name', 'channel_description', 'user_id'];
    

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

    public function scopePendingEpisodes($query, $id)
    {
        return $query->where('channels.id', '=', $id)
                    ->join('episodes', 'channels.id', '=', 'episodes.channel_id')
                    ->where('episodes.status', '=', 0);
    }

    public function scopeActiveEpisodes($query, $id)
    {
        return $query->where('channels.id', '=', $id)
                    ->join('episodes', 'channels.id', '=', 'episodes.channel_id')
                    ->where('episodes.status', '=', 1);
    }
    
}
