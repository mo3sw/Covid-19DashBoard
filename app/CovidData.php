<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CovidData extends Model
{
    //
    protected $fillable = [
        'country_id',
        'total_confirmed',
        'new_confirmed',
        'total_deaths',
        'new_deaths',
        'total_recovered',
        'new_recovered',
    ];

    public function country(){
        return $this->belongsTo('App\Country');
    }

}
