<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class AuctionTranslation extends Model {
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'auction_translation';
}