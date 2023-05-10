<?php

namespace App\Models;

class MetroStation extends CachedModel {
    protected $table = 'metro_stations';
	public $timestamps = false;
	protected $guarded = array('id');
}