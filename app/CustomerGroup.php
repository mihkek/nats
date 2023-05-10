<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
	public function subdivision()
    {
        return $this->belongsTo('App\Subdivision', 'subdivision_id');
    }
	public function customers()
	{
        return $this->hasMany('App\Customer', 'group_id')->with('user');
    }
    public function orderers()
    {
        return $this->hasMany('App\Orderer', 'customer_group_id')->with('directory_firm', 'directory_person', 'discipline')->orderBy('date_time');
    }
}
