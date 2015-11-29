<?php

namespace Suyabay;

use Suyabay\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Define users table relationship
     */
    public function userRole()
    {
        return $this->hasMany('Suyabay\User');
    }
}
