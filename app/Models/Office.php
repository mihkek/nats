<?php

namespace App\Models;

use App\Models\Traits\LogGlobalTrait;

class Office extends CachedModel {
    use LogGlobalTrait;

    protected $table = 'offices';
	public $timestamps = false;
	protected $guarded = array('id');
}