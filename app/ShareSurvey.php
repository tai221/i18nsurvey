<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareSurvey extends Model
{
    protected $fillable = [
        'survey_id','email_id','is_send','is_submit'
    ];

}
