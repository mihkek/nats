<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionRate extends Model
{
    public function auction()
    {
        return $this->belongsTo('App\Auction', 'auction_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
