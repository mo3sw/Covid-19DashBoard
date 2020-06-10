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
    ];

    public function covidData(){
        return $this->hasMany('App\CovidData');
    }
}
