<?php

namespace Mirronix\LogGlobal\Http\Controllers;

use App\Auction;
use App\CustomerPerson;
use App\DirectoryFirm;
use App\DirectoryFirmPerson;
use App\DirectoryPerson;
use App\Orderer;
use App\Customer;
use App\Requester;
use App\Models\Billing;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    public function getChanges(Request $request) {
	    $aliases = [
	        'directory_firm' => DirectoryFirm::class,
            'directory_firm_person' => DirectoryFirmPerson::class,
            'directory_person' => DirectoryPerson::class,
            'orderer' => Orderer::class,
            'customer_person' => CustomerPerson::class,
            'customer' => Customer::class,
            'billing' => Billing::class,
            'user' => User::class,
            'requester' => Requester::class,
            'auction' => Auction::class,
        ]; 

	    $data = [];
	    if (isset($aliases[$request->model])) {
	        $model = $aliases[$request->model];
	        $data = $model::getChangeLog(['model_id' => $request->id, 'compact' => true]);
        }

	    return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
