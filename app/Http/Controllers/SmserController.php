<?php

namespace App\Http\Controllers;

use App\Smser;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

use DB;
use File;
use Storage;

use Intervention\Image\Facades\Image as ImageInt;

use App\Models\User;

use \ConvertApi\ConvertApi;

class SmserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	// УПРАВЛЕНИЕ СМС АПИ
	public function getSms(Request $request)
	{
		return view('admin.configer.sms.index');
	}

	// ПОЛУЧИТЬ ИСТОРИЮ СМС
	public function get(Request $request)
	{
		$items = Smser::with('sender')->orderBy('created_at', 'desc')->get();
        return response([ 'status' => 1, 'items' => $items ], 200);
	}
	// НАПИСАТЬ НОВОЕ СМС
	public function new(Request $request)
	{
		$api_id = Config('smsru.api_id');
		$sms = new Smser;
		$sms->phone = $request->phone;
		$sms->text = $request->text;
		$sms->sender_id = $request->sender_id;
		
		$val = preg_replace('/[^0-9]/', '', $request->phone);
		$body = file_get_contents("https://sms.ru/sms/send?api_id=".$api_id."&to=".$val."&msg=".urlencode($request->text)."&json=1"); 
		$json = json_decode($body);

		$sms->save();
		$text = 'СМС успешно отправлено';
        return response([ 'status' => 1, 'text' => $text ], 200); 
	}
	// ПОЛУЧИТЬ БАЛАНС
	public function get_balance(Request $request)
	{
		$api_id = Config('smsru.api_id');
		$balance = 0;
		$body = file_get_contents("https://sms.ru/my/balance?api_id=".$api_id."&json=1"); 
		$balance = json_decode($body);

        return response([ 'status' => 1, 'balance' => $balance ], 200); 
	}

	// ОТПРАВКА ПО ПРИСЛАНЫМ ИД КЛИЕНТОВ
	public function send_customer_sms(Request $request)
	{
		$api_id = Config('smsru.api_id');
		$customers = DB::table('customers')->whereIn('id', $request->items)->get();
		$phones = '';
		
		$i = 0;
		foreach ($customers as $customer) {

			$sms = new Smser;
			$sms->phone = $customer->main_phone;
			$sms->text = $request->text;
			$sms->sender_id = $request->sender_id;

			$val = preg_replace('/[^0-9]/', '', $customer->main_phone);
			if ($i == 0) {
				$phones = $phones.$val;
			}
			else {
				$phones = $phones.','.$val;
			}
			$sms->save();
			$i++;
		}

		$body = file_get_contents("https://sms.ru/sms/send?api_id=".$api_id."&to=".$phones."&msg=".urlencode($request->text)."&json=1"); 
		$json = json_decode($body);

		$text = 'СМС рассылка успешно осуществлена';
        return response([ 'status' => 1, 'text' => $text ], 200); 
	}
}
