<?php 

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;

use App\Promoter;
use App\Requester;
use App\RequesterCustomer;
use App\Customer;

use DB;
use File;
use Storage;

use Intervention\Image\Facades\Image as ImageInt;

class RequesterController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    //############## НОВАЯ ЗАЯВКА ##############
    public function getAddCard(Request $request) {
        return view('admin.requester.list_represents_card_add');
    }

    //############## ЗАЯВКИ АКТУАЛЬНЫЕ ##############
    public function getListNow(Request $request) {
        return view('admin.requester.list_represents_now');
    }
    //############## ЗАЯВКИ АРХИВ ##############
    public function getList(Request $request) {
        return view('admin.requester.list_represents');
    }
    //############## ЗАЯВКА ##############
    public function getCard(Request $request) {
        return view('admin.requester.list_represents_card');
    }
    //############## ОТЧЕТ ##############
    public function getReport(Request $request) {
        return view('admin.requester.report');
    }

    public function delete_items(Request $request)
    {
        foreach ($request->items as $item)
        {
            $requester = Requester::find($item['id']);
            $requester_customer = RequesterCustomer::where('requester_id', $requester->id)->delete();
            $requester->delete();
        }
        $text = 'Заявки успешно удалены';
        return response([ 'status' => 1, 'text' => $text ], 200); 
    }

    public function edit_items(Request $request)
    {
        foreach ($request->items as $item)
        {
            $requester = Requester::find($item['id']);
            $requester->confirmed = $item['confirmed'];
            if (!empty($request->user)) {
                $requester->user_id = $request->user['id'];
            }
            else {
                $requester->user_id = null;
            }
            if (!empty($request->is_false)) {
                $requester->status = -1;
                $requester->is_false = $request->is_false;
                $requester->is_deal = 0;
                $requester->deal_date = null;
                $requester->deal_time = null;
                $requester->deal_date_time = null;
            }
            if (!empty($request->status)) {
                if ($request->status == 5) {
                    $requester->is_deal = 0;
                    $requester->deal_date = null;
                    $requester->deal_time = null;
                    $requester->deal_date_time = null;
                }
                $requester->status = $request->status;
            }
            if (!empty($request->deal_date)) {
                $requester->is_deal = 1;
                $requester->deal_date_time = $request->deal_date.' '.$request->deal_time.':00'; 
                $requester->deal_date = $request->deal_date;
                $requester->deal_time = $request->deal_time;
            }
            $requester->save();
        }
        $text = 'Информация о заявках успешно обновлена';
        return response([ 'status' => 1, 'text' => $text ], 200); 
    }

    public function get_notifications(Request $request)
    {
        $now = date('Y-m-d H:i:s');
        $calls_items = Requester::whereIn('status', [1, 2, 3, 4])
                                ->where('deal_date_time', '<', $now)
                                ->get();

        $records_items = Requester::where('status', 6)
                                    ->where('deal_date_time', '<', $now)
                                    ->get();

        $calls = $calls_items->count();
        $records = $records_items->count();

        $notifications = array(
            'calls' => $calls,
            'records' => $records
        );

        return response([ 'status' => 1, 'notifications' => $notifications ], 200); 
    }

    public function get_report(Request $request)
    {
        $promoters = Promoter::where('deleted', '!=', 'on')->get();
        $items = array();
        $total_qnt = 0;
        $total_false = 0;
        $total_cancel = 0;
        $total_successfull = 0;
        $date_from = null;
        $date_to = null;

        foreach ($promoters as $promoter)
        {
            $requesters = Requester::where('promoter_id', $promoter->id);

            if (!empty($request->date_from) && !empty($request->date_to)) {
                $requesters = $requesters->whereBetween('created_at', [$request->date_from, $request->date_to]);
            }
            else if (!empty($request->date_from) && empty($request->date_to)) {
                $requesters = $requesters->where('created_at', '>=', $request->date_from);
            }
            else if (empty($request->date_from) && !empty($request->date_to)) {
                $requesters = $requesters->where('created_at', '<=', $request->date_to);
            }
            else if (empty($request->date_from) && empty($request->date_to)) {
                $date_from = date('Y-m-01');
                $date_to = date('Y-m-t');
                $requesters = $requesters->whereBetween('created_at', [$date_from, $date_to]);
            }

            $requesters = $requesters->get();
            $qnt = 0;
            $false = 0;
            $cancel = 0;
            $successfull = 0;
            $successfull_percent = 0;
            $false_percent = 0;
            $cancel_percent = 0;

            foreach ($requesters as $requester)
            {
                if ($requester->is_false == 1) {
                    $false = $false + 1;
                }
                if ($requester->status == 5 ) {
                    $cancel = $cancel + 1;
                }
                if ($requester->status == 6 ) {
                    $successfull = $successfull + 1;
                }
                $qnt = $qnt + 1;
            }

            if ($qnt > 0) {
                $successfull_percent = $successfull*100/$qnt;
                $false_percent = $false*100/$qnt;
                $cancel_percent = $cancel*100/$qnt;
            }

            $item = array(
                'promoter' => $promoter,
                'qnt' => $qnt,
                'false' => $false,
                'cancel' => $cancel,
                'successfull' => $successfull,
                'successfull_percent' => $successfull_percent,
                'false_percent' => $false_percent,
                'cancel_percent' => $cancel_percent,
            );
            array_push($items, $item);

            $total_qnt = $total_qnt + $qnt;
            $total_false = $total_false + $false;
            $total_cancel = $total_cancel + $cancel;
            $total_successfull = $total_successfull + $successfull;
        }
        $total = array(
            'qnt' => $total_qnt,
            'false' => $total_false,
            'cancel' => $total_cancel,
            'successfull' => $total_successfull,
        );

        $report = array(
            'items' => $items,
            'total' => $total,
            'date_from' => $date_from,
            'date_to' => $date_to,
        );
        return response([ 'status' => 1, 'report' => $report ], 200); 
    }
    
    public function get(Request $request)
    {
        if (!empty($request->id)) {
            $user = User::find($request->user_id);
            $requester = Requester::with('customer', 'promoter')->find($request->id);
            $customer = RequesterCustomer::where('requester_id', $requester->id)->first();
            if ($user->subdivision_id != $requester->subdivision_id) {
                return response([ 'status' => 0, 'text' => 'Error' ], 200); 
            }
            else {
                return response([ 'status' => 1, 'requester' => $requester ], 200); 
            }
        }
        else {
            $user = User::find($request->user_id);
            $requesters = Requester::with('customer', 'promoter');
            $requesters->where('subdivision_id', $request->subdivision_id);

            if (!empty($request->notifications_filter)) {
                $now = date('Y-m-d H:i:s');
                if ($request->notifications_filter == 1) {
                    $requesters = Requester::whereIn('status', [1, 2, 3, 4])
                                            ->where('deal_date_time', '<', $now);
                }
                else if ($request->notifications_filter == 2) {
                    $requesters = Requester::whereIn('status', [6])
                                            ->where('deal_date_time', '<', $now);
                }
            }
            else {
                if (!empty($request->status)) {
                    $requesters = $requesters->whereIn('status', $request->status);
                }
                if (!empty($request->promoter_id)) {
                    $requesters = $requesters->where('promoter_id', $request->promoter_id);
                }
    
                if (!empty($request->date)) {
                    if ($request->date == 'today') {
                        $requesters = $requesters->whereBetween('created_at', [date('Y-m-d 00:00:01'), date('Y-m-d 23:59:59')]);
                    }
                    else {
                        if ($request->date_from != '') {
                            $date_from = date('Y-m-d 00:00:00', strtotime($request->date_from));
                            if ($request->date_filter == 1) {
                                $requesters = $requesters->where('created_at', '>=', $date_from);
                            }
                            if ($request->date_filter == 2) {
                                $requesters = $requesters->where('deal_date_time', '>=', $date_from)->where('status', '!=', 6);
                            }
                            if ($request->date_filter == 3) {
                                $requesters = $requesters->where('deal_date_time', '>=', $date_from)->where('status', 6);
                            }
                        }
                        if ($request->date_to != '') {
                            $date_to = date('Y-m-d 23:59:59', strtotime($request->date_to));
                            if ($request->date_filter == 1) {
                                $requesters = $requesters->where('created_at', '<=', $date_to);
                            }
                            if ($request->date_filter == 2) {
                                $requesters = $requesters->where('deal_date_time', '<=', $date_to)->where('status', '!=', 6);
                            }
                            if ($request->date_filter == 3) {
                                $requesters = $requesters->where('deal_date_time', '<=', $date_to)->where('status', 6);
                            }
                        }
                    }
                }
                if (!empty($request->deal_filter)) {
                    if ($request->deal_filter == 1) {
                        $requesters = $requesters->where('is_deal', 0);
                    }
                    if ($request->deal_filter == 2) {
                        $now = date('Y-m-d H:i:s');
                        $requesters = $requesters->where('deal_date_time', '<=', $now);
                    }
                    if ($request->deal_filter == 3) {
                        $requesters = $requesters->whereNull('user_id');
                    }
                    if ($request->deal_filter == 4) {
                        $requesters = $requesters->whereNotNull('claim');
                    }
                }
            }

            if ($user->role_id == 1004) {
                $requesters->where('user_id', $user->id)
                            ->orWhere(function($query){
                                    $query->where('status', 6)
                                          ->where('confirmed', 0)
                                          ->where('deal_date', date('Y-m-d'));
                                    });;
            }

            $requesters = $requesters->orderBy('id', 'desc')->get();
            
            return response([ 'status' => 1, 'requesters' => $requesters ], 200); 
        }
    }

    public function edit(Request $request)
    {
        $user = User::find($request->user_id);
        $promoter = Promoter::find($request->promoter_id);
        $new = false;

        if (!empty($request->id)) {
            $requester = Requester::with('customer')->find($request->id);
            $requester->status = $request->status;
            if ($request->status == 5) {
                $requester->is_deal = 0;
                $requester->deal_date = null;
                $requester->deal_time = null;
                $requester->deal_date_time = null;
            }
            $customer = RequesterCustomer::where('requester_id', $requester->id)->first();
            $text = 'Информация о заявке успешно изменена';
        }
        else {
            $new = true;
            $requester = new Requester;
            $requester->subdivision_id = $promoter->subdivision_id;
            $requester->status = 1;
            $customer = new RequesterCustomer;
            $requester->promoter_id = $request->promoter_id;
            $text = 'Новая заявка успешно создана';
        }
        $requester->promoter_id = $request->promoter_id;
        $requester->projected_amount = $request->projected_amount;
        $requester->first_test = $request->first_test;
        $requester->second_test = $request->second_test;

        if (!empty($request->third_test)) {
            $requester->third_test = implode(",", $request->third_test);
        }

        if ($request->is_deal > 0 && $request->status != 5) {
            $requester->is_deal = 1;
            if ($request->deal_date != null) { 
                $requester->deal_date_time = $request->deal_date.' '.$request->deal_time.':00'; 
                $requester->deal_date = $request->deal_date;
                $requester->deal_time = $request->deal_time;
            }
        }
        
        $requester->main_comment = $request->main_comment;

        if (!empty($request->directory_firm)) {
            $requester->directory_firm_id = $request->directory_firm['id'];
        }
        else {
            $requester->directory_firm_id = $promoter->directory_firm_id;
        }

        /*if (!empty($request->directory_firm['option'])) {
            if ($request->directory_firm['option'] == true) {
                $requester->directory_firm_id = null;
                $requester->additional_place_id = $request->directory_firm['id'];
            }
        }
        else if (empty($request->additional_place)) {
            $requester->additional_place_id = null;
            $requester->directory_firm_id = $request->directory_firm['id'];
        }
        else if (!empty($request->additional_place) && empty($request->directory_firm)){
            $requester->additional_place_id = $request->additional_place['id'];
            $requester->directory_firm_id = null;
        }
        else {
            $requester->additional_place_id = null;
            $requester->directory_firm_id = $request->directory_firm['id'];
        }*/
        
        $requester->directory_person_id = $request->directory_person['id'];
        $requester->user_id = $request->user['id'];
        $requester->manager_id = $request->manager['id'];
        $requester->save();

        $customer->requester_id = $requester->id;
        $customer->first_name = $request->customer_first_name;
        $customer->middle_name = $request->customer_middle_name;
        $customer->last_name = $request->customer_last_name;
        $customer->child_first_name = $request->customer_child_first_name;
        $customer->child_last_name = $request->customer_child_last_name;
        $customer->child_hobbies = $request->customer_child_hobbies;
        $customer->age = $request->customer_age;
        $customer->gender = $request->customer_gender;
        $customer->main_phone = $request->customer_main_phone;
        $customer->main_email = $request->customer_main_email;
        $customer->main_city = $request->customer_main_city;
        $customer->main_address = $request->customer_main_address;
        $customer->main_metro = $request->customer_main_metro;
        $customer->save();

        $path = storage_path('app/avatars/children/');

    

        if (!empty($request->file_one)) {
            $first_image = chunk_split($request->file_one); 
            preg_match("/data:image\/(.*?);/",$first_image, $image_extension); // extract the image extension
            $first_image = preg_replace('/data:image\/(.*?);base64,/','',$first_image); // remove the type part
            $first_image = str_replace(' ', '+', $first_image);
            $firstImageName = 'first_image_' . time() . '.' . $image_extension[1]; //generating unique file name;
            Storage::disk('local')->put('avatars/children/'.$firstImageName,base64_decode($first_image));
            $customer->photo_one = $firstImageName;
        }
        if (!empty($request->file_two)) {
            $second_image = chunk_split($request->file_two); 
            preg_match("/data:image\/(.*?);/",$second_image, $image_extension); // extract the image extension
            $second_image = preg_replace('/data:image\/(.*?);base64,/','',$second_image); // remove the type part
            $second_image = str_replace(' ', '+', $second_image);
            $secondImageName = 'second_image_' . time() . '.' . $image_extension[1]; //generating unique file name;
            Storage::disk('local')->put('avatars/children/'.$secondImageName,base64_decode($second_image));
            $customer->photo_two = $secondImageName;
        }
        if (!empty($request->file_three)) {
            $third_image = chunk_split($request->file_three); 
            preg_match("/data:image\/(.*?);/",$third_image, $image_extension); // extract the image extension
            $third_image = preg_replace('/data:image\/(.*?);base64,/','',$third_image); // remove the type part
            $third_image = str_replace(' ', '+', $third_image);
            $thirdImageName = 'third_image_' . time() . '.' . $image_extension[1]; //generating unique file name;
            Storage::disk('local')->put('avatars/children/'.$thirdImageName,base64_decode($third_image));
            $customer->photo_three = $thirdImageName;
        }

        $customer->save();

        $requester = Requester::with('customer')->find($requester->id);
        return response([ 'status' => 1, 'requester' => $requester, 'text' => $text ], 200); 
    }

    public function add_customer(Request $request)
    {
        $requester = Requester::find($request->id);
        $requester->add_customer();
        $requester_customer = RequesterCustomer::where('requester_id', $requester->id)->first();
        $customer = Customer::find($requester_customer->customer_id);

        $text = 'Клиент успешно создан';

        return response([ 'status' => 1, 'text' => $text, 'customer' => $customer ], 200); 
    }

    public function add_photo(Request $request)
    {
        $requester = Requester::find($request->id);
        $customer = RequesterCustomer::where('requester_id', $requester->id)->first();
        $path = storage_path('app/avatars/children/');
        $rand = rand(100,999);
        $fileName = $customer->id.'-'.$rand.'.'.$request->file->getClientOriginalExtension();
        $img = ImageInt::make($request->file);
        $height = $img->height();
        $width = $img->width();
        if ($width > $height) {
            $img->crop($height, $height);
        }
        else {
            $img->crop($width, $width);
        }
        $img->resize(600, 600)->save($path.$fileName);

        if ($request->number == 1) {
            $customer->photo_one = $fileName;
        }
        else if ($request->number == 2) {
            $customer->photo_two = $fileName;
        }
        else if ($request->number == 3) {
            $customer->photo_three = $fileName;
        }
        $customer->save();
        $text = 'Фотография успешно добавлена';
        return response([ 'status' => 1, 'text' => $text ], 200); 
    }

    public function del_photo(Request $request)
    {
        $requester = Requester::find($request->id);
        $customer = RequesterCustomer::where('requester_id', $requester->id)->first();
        if ($request->number == 1) {
            Storage::disk('local')->delete('avatars/children/'.$customer->photo_one);
            $customer->photo_one = null;
        }
        else if ($request->number == 2) {
            Storage::disk('local')->delete('avatars/children/'.$customer->photo_two);
            $customer->photo_two = null;
        }
        else if ($request->number == 3) {
            Storage::disk('local')->delete('avatars/children/'.$customer->photo_three);
            $customer->photo_three = null;
        }
        $customer->save();
        $text = 'Фотография успешно удалена';
        return response([ 'status' => 1, 'text' => $text ], 200); 
    }

    public function is_false(Request $request)
    {
        $requester = Requester::find($request->id);
        $requester->is_false = $request->is_false;
        $requester->status = -1;
        $requester->is_deal = 0;
        $requester->deal_date = null;
        $requester->deal_time = null;
        $requester->deal_date_time = null;
        $requester->save();

        $text = 'Заявка успешно помечена ложной';
        return response([ 'status' => 1, 'text' => $text ], 200); 
    }

    public function is_claim(Request $request)
    {
        $requester = Requester::find($request->id);
        $requester->claim = $request->claim;
        $requester->save();

        $text = 'Жалоба успешно зафиксирована';
        return response([ 'status' => 1, 'text' => $text ], 200); 
    }

    public function confirm_record(Request $request)
    {
        $requester = Requester::find($request->id);
        $requester->confirmed = 1;
        $requester->save();

        $text = 'Запись клиента успешно подтверждена';
        return response([ 'status' => 1, 'text' => $text ], 200); 
    }
}
