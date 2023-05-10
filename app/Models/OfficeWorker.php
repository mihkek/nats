<?php

namespace App\Models;

class OfficeWorker extends CachedModel {
	protected $table = 'office_workers';
	public $timestamps = false;
	protected $guarded = array('id');

}