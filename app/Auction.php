<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SaleRate;
use DB;
use File;

use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use App\Models\Traits\UsersOrgRestrictedTrait;
use Illuminate\Support\Facades\Storage;
use App\Models\Scopes\UsersOrgRestrictedScope;
use Intervention\Image\Facades\Image as ImageInt;

class Auction extends Model
{
    use LogGlobalTrait;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function rates()
    {
        return $this->hasMany('App\AuctionRate', 'auction_id')->with('user')->orderBy('price')->where('deleted', '');
    }
    public function win_rate()
    {
        return $this->belongsTo('App\AuctionRate', 'win_rate_id')->with('user');
    }
    
    public function price()
    {

        $price = null;
        $price_date_time = null;
        $rate = DB::table('auction_rates')
                    ->where('auction_id', $this->id)
                    ->orderBy('id', 'desc')
                    ->first();

        if (!empty($rate)) {
            $price = $rate->price;
            $price_date_time = date('d.m.Y H:i', strtotime($rate->created_at));
        }
        else {
            $price = $this->start_price;
        }
        $res = array(
            'price' => $price,
            'price_date_time' => $price_date_time,
        );

        return $res;
    }

    //распродажа цена
    /*public function sale_price() {    
        $sale_rate_price = 0;    
        $date_now = date('Y-m-d H:i:s');
            if ($this->type == 'sale') {
                $sale_rate_item = SaleRate::where('auction_id', $auction->id)->where('date_price', '<=',  $date_now)->orderBy('id','desc')->first();                  
                if (!empty($sale_rate_item)) {
                    $sale_rate_price =  $sale_rate_item->price;                    
                } 
            }
        return $sale_rate_price;
    }*/



    
}
