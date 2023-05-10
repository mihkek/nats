<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DirectoryFirm;
use App\DirectoryFirmPerson;
use App\Customer;
use App\Orderer;
use App\DirectoryFirmBusy;
use App\Subdivision;



use App\Models\User;

use File;
use Storage;

use Intervention\Image\Facades\Image as ImageInt;

class DirectoryFirmController extends Controller
{
    public function get(Request $request)
    {
        $user = User::find($request->user_id);
        
        if (!empty($request->id)) {
            $firm = DirectoryFirm::with('user', 'people', 'city')->find($request->id);
            $orderers = Orderer::with('directory_firm', 'directory_person')->where('directory_firm_id', $firm->id)->get();
            if ($user->role_id != 1000 && $firm->subdivision_id != $user->subdivision_id) {
                return response([ 'status' => 0, 'text' => 'Error' ], 200); 
            }
            else {
                $res = array(
                    'firm' => $firm,
                    'orderers' => $orderers,
                );
                return response([ 'status' => 1, 'firm' => $res ], 200); 
            }
        }
        else {
            $firms = DirectoryFirm::with('user', 'people', 'city'); 

            if (!empty($request->type)) {
                $firms->where('type', $request->type);
                if ($request->type == 1) {
                    $firms->where('subdivision_id', $request->subdivision_id);
                }
                else {
                    $subdivision = Subdivision::find($request->subdivision_id);
                    $firms->where('city_id', $subdivision->city_id);
                }
            }

            if ($request->limit > 0) {
                $firms->take($request->limit);
            }

            if ($request->is_delete == true) {
                $firms->where('deleted', 'on');
            }
            else {
                $firms->where('deleted', '!=', 'on');
            }

            if ( $user->role_id == 103) { 
                $firms->where('user_id', $user->id);
            }
            else if ($user->role_id == 101) {
                $customers = Customer::where('user_id', $user->id)->get();
                $firm_array_id = array();
                $array_id = array();
                foreach ($customers as $customer) {
                    array_push($array_id, $customer->id);
                    array_push($firm_array_id, $customer->directory_firm_id);
                }
                $orderers = Orderer::whereIn('customer_id', $array_id)->get();
                foreach ($orderers as $orderer) {
                    array_push($firm_array_id, $orderer->id);
                }
                $uniq = array_unique($firm_array_id);

                $firms->whereIn('id', $firm_array_id);
            }
            $firms = $firms->get();
            return response([ 'status' => 1, 'firms' => $firms ], 200); 
        }
    }

    public function edit(Request $request)
    {
        $user = User::find($request->user_id);
        $firm = DirectoryFirm::find($request->id);

        if (empty($firm)){
            $price = config('tariffs.STANDARD.payouts[0].price');
            $firm = new DirectoryFirm;
            if (!empty($request->subdivision_id)) {
                $firm->subdivision_id = $request->subdivision_id;
            }
            else {
                if ($request->type != 2) {
                    $firm->subdivision_id = $user->subdivision_id;
                }
            }
            $text = 'Новое помещение '.$request->full_name.' успешно добавлено';
            if ($request->role_id == 103) { $firm->user_id = $request->user_id; }
            else { $firm->user_id = $request->user['id']; }
            $firm->price = $price;
        }
        else {
            $text = 'Информация о помещении - '.$request->full_name.' успешно обновлена';
            $firm->user_id = $request->user['id'];
            $firm->price = $request->price;
        }
        $firm->type = $request->type;
        $firm->full_name = $request->full_name;
        $firm->city_id = $request->city_id;
        $firm->main_metro = $request->main_metro;
        $firm->main_address = $request->main_address;
        $firm->main_phone = $request->main_phone;
        $firm->main_email = $request->main_email;
        $firm->main_requisites = $request->main_requisites;
        $firm->save();

        return response([ 'status' => 1, 'firm' => $firm, 'text' => $text ], 200); 
    }

    public function edit_img(Request $request)
    {
        $firm = DirectoryFirm::with('user')->find($request->id);

        if (!empty($firm))
        {
            if ($firm->avatar != null)
            {
                Storage::disk('local')->delete('avatars/600x600.'.$firm->avatar);
                Storage::disk('local')->delete('avatars/150x150.'.$firm->avatar);
                Storage::disk('local')->delete('avatars/50x50.'.$firm->avatar);
                Storage::disk('local')->delete('avatars/48x48.'.$firm->avatar);
            }

            $path = storage_path('app/avatars/');
            $rand = rand(100,999);
            $fileName = $firm->id.'-'.$rand.'.'.$request->file->getClientOriginalExtension();

            $img = ImageInt::make($request->file);
            $height = $img->height();
            $width = $img->width();
            
            if ($width > $height) {
                $img->crop($height, $height);
            }
            else {
                $img->crop($width, $width);
            }

            $img->resize(600, 600)->save($path.'600x600.'.$fileName);
            $img->resize(150, 150)->save($path.'150x150.'.$fileName);
            $img->resize(50, 50)->save($path.'50x50.'.$fileName);
            $img->resize(48, 48)->save($path.'48x48.'.$fileName);

            $firm->avatar = $fileName;
            $firm->save();

            $text = 'Фотография помещения '.$firm->full_name.' - успешно обновлена';
            return response([ 'status' => 1, 'text' => $text ], 200);
        }
    }

    public function delete(Request $request)
    {
        $firm = DirectoryFirm::find($request->id);
        $firm->deleted = 'on';
        $firm->save();
        $text = 'Помещение "'.$firm->full_name.'" успешно помещено в архив';
        return response([ 'status' => 1, 'firm' => $firm, 'text' => $text ], 200); 
    }

    public function restore(Request $request)
    {
        $firm = DirectoryFirm::find($request->id);
        $firm->deleted = '';
        $firm->save();
        $text = 'Помещение "'.$firm->full_name.'" успешно восстановлено из архива';
        return response([ 'status' => 1, 'firm' => $firm, 'text' => $text ], 200); 
    }

    public function edit_firm_person(Request $request)
    {
        $person = DirectoryFirmPerson::find($request->id);
        if (empty($person)) {
            $person = new DirectoryFirmPerson;
            $person->directory_firm_id = $request->directory_firm_id;
            $text = 'Информация о новой персоне '.$request->full_name.' успешно сохранена';
        }
        else {
            $text = 'Информация о персоне '.$request->full_name.' успешно сохранена';
        }
        $person->position = $request->position;
        $person->full_name = $request->full_name;
        $person->main_phone = $request->main_phone;
        $person->main_email = $request->main_email;
        $person->save();

        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function delete_firm_person(Request $request)
    {
        $person = DirectoryFirmPerson::find($request->id);
        $text = 'Информация о персоне '.$person->full_name.' успешно удалена';
        $person->delete();

        return response([ 'status' => 1, 'text' => $text ], 200);
    }


    public function get_busy_times(Request $request)
    {
        $date = date('Y-m-d');
        $busy_times = DirectoryFirmBusy::where('directory_firm_id', $request->id)
                                        ->where(function($query) use ($date) {
                                            $query->where('type', 'once_week')
                                                ->orWhere('date', '>=', $date);
                                        })
                                        ->orderBy('week_day')
                                        ->get();



        return response([ 'status' => 1, 'busy_times' => $busy_times ], 200);

    }

    public function get_busy_calendar_times(Request $request)
    {
        $date = date('Y-m-d H:i:s');
        $res = array();

        $busy_days_of_week = DirectoryFirmBusy::where('directory_firm_id', $request->id)
                                        ->where('type', 'once_week')
                                        ->orderBy('week_day')
                                        ->get();

        $busy_times = DirectoryFirmBusy::where('directory_firm_id', $request->id)
                                        ->where('type', 'one_time')
                                        ->where('end_datetime', '>=', $date)
                                        ->orderBy('week_day')
                                        ->get();

        $over_date = date('Y-m-d', strtotime($date. '+ 365 day'));
        foreach ($busy_days_of_week as $busy_day)
        {
            $start_date = $date;
            $i = 0;
            while ($i < 1)
            {
                $week = date('N', strtotime($start_date));
                if ($week == $busy_day->week_day)
                {
                    $busy_day->date =  date('Y-m-d', strtotime($start_date));
                    $start_date =  date('Y-m-d', strtotime($start_date));
                    $end_date =  date('Y-m-d', strtotime($start_date));
                    $busy_day->start_datetime =  date('Y-m-d H:i', strtotime($start_date.' '.$busy_day->time_from));
                    $busy_day->end_datetime =  date('Y-m-d H:i', strtotime($end_date.' '.$busy_day->time_to));
                    $i = 1;
                }
                else {
                    $start_date = date('Y-m-d H:i', strtotime($start_date.' + 1 day'));
                }
            }

            array_push($res, $busy_day);

            $start_date = date('Y-m-d H:i', strtotime($start_date.' + 7 day'));
            while ($start_date <= $over_date)
            {
                $busy_day->date =  date('Y-m-d', strtotime($start_date));
                $start_datetime =  date('Y-m-d', strtotime($start_date));
                $end_datetime =  date('Y-m-d', strtotime($start_date));
                $item = array(
                    'date' => date('Y-m-d', strtotime($start_date)),
                    'start_datetime' => date('Y-m-d H:i', strtotime($start_datetime.' '.$busy_day->time_from)),
                    'end_datetime' => date('Y-m-d H:i', strtotime($end_datetime.' '.$busy_day->time_to)),
                    'time_from' => $busy_day->time_from,
                    'time_to' => $busy_day->time_to,
                    'hour' => substr($busy_day->time_from, 0, 2),
                    'minute' => substr($busy_day->time_from, -2),
                );
                $start_date = date('Y-m-d H:i', strtotime($start_date.' + 7 day'));

                array_push($res, $item);
            }
        }

        foreach ($busy_times as $busy_time)
        {
            $item = array(
                'date' => date('Y-m-d', strtotime($busy_time->date)),
                'start_datetime' => date('Y-m-d H:i', strtotime($busy_time->date.' '.$busy_time->time_from)),
                'end_datetime' => date('Y-m-d H:i', strtotime($busy_time->date.' '.$busy_time->time_to)),
                'hour' => substr($busy_time->time_from, 0, 2),
                'minute' => substr($busy_time->time_from, -2),
                'time_from' => $busy_time->time_from,
                'time_to' => $busy_time->time_to,
            );
            array_push($res, $item);
        }

        return response([ 'status' => 1, 'busy_times' => $res ], 200);

    }


    public function edit_busy_time(Request $request)
    {
        $busy_time = DirectoryFirmBusy::find($request->id);
        if (empty($busy_time)) {
            $busy_time = new DirectoryFirmBusy;
            $busy_time->directory_firm_id = $request->directory_firm_id;
        }
        $busy_time->type = $request->type;
        
        if ($busy_time->type == 'one_time')
        {
            $week = date('N', strtotime($request->date));

            $busy_time->date = $request->date;
            $busy_time->start_datetime = $request->date.' '.$request->time_from.':00';
            $busy_time->end_datetime = $request->date.' '.$request->time_to.':00';
            $busy_time->week_day = $week;
        }
        else
        {
            $busy_time->week_day = $request->week_day;
        }
        $busy_time->time_from = $request->time_from;
        $busy_time->time_to = $request->time_to;
        $busy_time->save();

        $text = 'Данные о свободном времени помещения успешно обновлены';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function delete_busy_time(Request $request)
    {
        $busy_time = DirectoryFirmBusy::find($request->id);
        $busy_time->delete();

        $text = 'Данные о свободном времени помещения успешно обновлены';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

}
