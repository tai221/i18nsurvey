<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'user_id','email','code','active',
    ];

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
