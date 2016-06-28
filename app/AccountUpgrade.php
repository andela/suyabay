<?php

namespace Suyabay;

use Illuminate\Database\Eloquent\Model;

class AccountUpgrade extends Model
{
    protected $fillable = ['user_id', 'request'];
}
