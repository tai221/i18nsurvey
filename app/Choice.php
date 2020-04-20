<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = [
        'question_id','key','content'
    ];

    public function questions()
    {
        return $this->belongsTo('App\Question','quesiton_id');
    }
}
