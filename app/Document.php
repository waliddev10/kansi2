<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    protected $fillable = [
        'title',
        'year',
        'attachment',
        'category',
    ];
}
