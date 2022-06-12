<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Present extends Model
{
    public function agenda()
    {
        return $this->belongsTo('App\Agenda');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
