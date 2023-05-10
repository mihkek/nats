<?php

namespace App\Models;

use App\Exceptions\BillingException;
use App\Libs\Helpers;
use App\Libs\Robokassa;
use App\Models\Traits\UsersOrgRestrictedTrait;
use App\Orderer;
use App\Customer;
use App\CustomerSubscription;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Mirronix\LogGlobal\Traits\LogGlobalTrait;

class BlockSuplier extends CachedModel {
    protected $table = 'block_supliers';
    public $timestamps = false;
    protected $guarded = array('id','created');

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'suplier_id');
    }


}
