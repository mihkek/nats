<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Firm;

class FirmController extends Controller
{
    public function get(Request $request)
    {
        if (!empty($request->id)) {
            $firm = Firm::find($request->id);
            return response([ 'status' => 1, 'firm' => $firm ], 200); 
        }
        else {
            $firms = Firm::where('deleted', '!=', 'on')->get();
            return response([ 'status' => 1, 'firms' => $firms ], 200); 
        }
    }

    public function edit(Request $request)
    {
    	$firm = Firm::find($request->id);
    	if (empty($firm)){
    		$firm = new Firm;
            $desc = 'Новое помещение "'.$request->title.'" успешно создано';
    	}
        else {
            $desc = 'Помещение "'.$request->title.'" успешно обновлено';
        }
    	$firm->title = $request->title;
    	$firm->city = $request->city;
    	$firm->metro = $request->metro;
    	$firm->address = $request->address;
    	$firm->phone = '7'.$request->phone;
    	$firm->email = $request->email;
    	$firm->requisites = $request->requisites;
    	$firm->save();

    	return response([ 'status' => 1, 'firm' => $firm, 'desc' => $desc ], 200); 
    }
}
