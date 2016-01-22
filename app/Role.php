<?php

namespace Suyabay;

use Suyabay\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    /**
     * Define users table relationship
     */
    public function userRole()
    {
        return $this->hasMany('Suyabay\User');
    }
}
