<?php

namespace App\Models;

class City extends CachedModel {
	protected $table = 'cities';
	public $timestamps = false;
	protected $guarded = array('id');
}