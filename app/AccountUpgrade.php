<?php

namespace Suyabay;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountUpgrade extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'reason'];

    public function user()
    {
        return $this->belongsTo('Suyabay\User');
    }
}
