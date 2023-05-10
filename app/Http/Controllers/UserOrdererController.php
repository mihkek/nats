<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserOrdererController extends Controller
{
	public function get_next_orderer(Request $request)
    {
        $user = User::find($request->id);
        $orderer = $user->next_orderer();
        return response([ 'status' => 1, 'orderer' => $orderer ], 200); 
    }

    public function get_today_orderers(Request $request)
    {
        $user = User::find($request->id);
        $orderers = $user->today_orderers();
        return response([ 'status' => 1, 'orderers' => $orderers ], 200); 
    }
}
