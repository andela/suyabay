<?php

namespace Suyabay\Http\Repository;

use Suyabay\User;

class UserRepository
{

    /**
    * Return all user from the database
    */
    public function getAllUsers()
    {
        return User::all();
    }

    /**
    * Return all online users
    */
    public function getOnlineUsers()
    {
        return $this->getAllUser()->where('active', 1);
    }

    /**
    * Return all offline users
    */
    public function getOfflineUsers()
    {
        return $this->getAllUser()->where('active', 0);
    }
}
