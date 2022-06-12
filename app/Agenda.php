<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'start',
        'end',
        'link',
        'attachment',
        'status_agenda_id'
    ];

    protected $appends = [
        'url',
        'workunit'
    ];

    public function presents()
    {
        return $this->hasMany('App\Present');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status_agenda()
    {
        return $this->belongsTo('App\StatusAgenda');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('start', 'asc')->get();
    }

    public function getUrlAttribute()
    {
        return route('agenda_detail', $this->slug);
    }

    public function getWorkunitAttribute()
    {
        return Workunit::whereIn('id', explode(',', $this->workunit_id))->get();
    }
}
