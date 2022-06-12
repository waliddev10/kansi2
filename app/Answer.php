<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    //

    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
