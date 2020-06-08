<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $fillable = [
        'name',
        'code',
        'slug',
        'total_confirmed',
        'new_confirmed',
        'total_deaths',
        'new_deaths',
        'total_recovered',
        'new_recovered',
    ];
}
