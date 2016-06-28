<?php

namespace Suyabay;

use Illuminate\Database\Eloquent\Model;

class AccountUpgrade extends Model
{
    protected $fillable = ['user_id', 'reason'];

    public function user()
    {
        return $this->belongsTo('Suyabay\User');
    }
}
