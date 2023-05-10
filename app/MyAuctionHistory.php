<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use DB;
use File;

use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use App\Models\Traits\UsersOrgRestrictedTrait;
use Illuminate\Support\Facades\Storage;
use App\Models\Scopes\UsersOrgRestrictedScope;
use Intervention\Image\Facades\Image as ImageInt;

class MyAuctionHistory extends Model
{

    protected $table = "my_auction_history";

    public $timestamps = false;
    protected $guarded = array('id', 'created');
}

