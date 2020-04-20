<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'survey_id','required','type','question','page','order_page'
    ];

    public function surveys()
    {
        return $this->belongsTo('App\Survey','survey_id');
    }

    public function choices()
    {
        return $this
            ->hasMany('App\Choice','question_id', 'id');
    }

}
