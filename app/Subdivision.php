<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subdivision extends Model
{
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }
}
