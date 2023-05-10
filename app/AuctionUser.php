<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionUser extends Model
{
	public $timestamps = false;
    protected $table = 'auction_users';

    public function auction()
    {
        return $this->belongsTo('App\Auction', 'auction_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
