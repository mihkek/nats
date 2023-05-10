<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//FED
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\News;
use App\Models\Drugs;

use App\AuctionCounter;

use App\Auction;
use App\AuctionRate;
use App\SaleRate;
use DB;
use File;
use Storage;

use Intervention\Image\Facades\Image as ImageInt;

class TestController extends Controller
{

    public function api() {
        return view("test.api");
    }

    









}
