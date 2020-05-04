<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'user_id','active','public','start_date','expire','ref_url','title','dear','greeting',
    ];

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function questions()
    {
        return $this
            ->hasMany('App\Question','survey_id', 'id');
    }
}
