<?php

namespace Suyabay;

use Suyabay\Role;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'active' ,'email', 'password', 'facebookID', 'twitterID', 'avatar', 'has_viewed_new'];

    /**
     * Set the looged_out_at timestamp to be treated as a Carbon instance.
     */
    protected $dates = ['logged_out_at'];

    
    /**
     * Define roles table relationship
     *
     * @return object
     */
    public function role()
    {
        return $this->belongsTo('Suyabay\Role');
    }

    public function likes()
    {
        return $this->hasMany('Suyabay\Like');
    }

    /**
     * Get the avatar from gravatar.
     * @return string
     */
    private function getAvatarFromGravatar()
    {
        return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim(env('GRAVAR_EMAIL')))).'?d=mm&s=500';
    }

    /**
     * Get avatar from the model.
     * @return string
     */
    public function getAvatar()
    {
        return (! is_null($this->avatar)) ? $this->avatar : $this->getAvatarFromGravatar();
    }

    //upload custom avatar
    public function updateAvatar($img)
    {
        $this->avatar = $img;
        $this->save();
    }

    /**
     * Define appDetail table relationship.
     * @return object
     */
    public function appDetail()
    {
        return $this->hasMany('Suyabay\AppDetail');
    }

    /**
     * Return the number of likes that the user has for episodes.
     * @return integer
     */
    public function likesCount()
    {
        return $this->likes()->count();
    }

    /**
     * Set the Logged Out At column to use Carbon timestamps
     */
    public function setLoggedOutAtAttriute($date)
    {
        $this->attributes['logged_out_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    /**
    * Get all the new channels that were added between the
    * user's logged_out_time and the current time.
    * @return A collection of all the channels between the two points in time.
    */
    public function newChannels()
    {
        $loggedOut = $this->logged_out_at;
        $now = Carbon::now();

        return Channel::whereBetween('created_at', [$loggedOut, $now]);
    }

    /**
    * Get the count of all the notification channels for this particular user.
    * @return The count of all notification channels.
    */
    public function newChannelsCount()
    {
        return $this->newChannels()->count();
    }

    /**
    * Check if the user has not viewed his notifications page.
    * @return Return TRUE if user has not viewed or FALSE otherwise.
    */
    public function hasNotViewedNew()
    {
        return !$this->has_viewed_new;
    }

    /**
    * Set that the user has viewed his notifications page.
    * This is called once the user visits the notifications route.
    */
    public function setHasViewNew()
    {
        $this->has_viewed_new = 1;
        $this->save();
    }

    /**
    * Check if the user has some channel notifications.
    * @return TRUE if the user has notificationsm and has not viewed them. FASLE otherwise.
    */
    public function hasChannelNotifications()
    {
        return $this->newChannelsCount() > 0 and $this->hasNotViewedNew();
    }
}
