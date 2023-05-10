<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DirectoryPerson;
use App\DirectoryFirm;
use App\Orderer;
use App\Customer;
use App\Models\User;
use App\DirectoryPersonBusy;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DirectoryPersonExport;

use DB;
use File;
use Storage;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image as ImageInt;


class DirectoryPersonController extends Controller
{
    protected $passwordPlain = '';
	protected $rejectReason = '';

	public function get(Request $request)
    {
        if (!empty($request->id)) {
            $person = User::find($request->id);
            return response([ 'status' => 1, 'person' => $person ], 200); 
        }
        else {
            $people = User::where('role_id', 102)->where('subdivision_id', $request->subdivision_id);

			if (!empty($request->search)) {
				$searches = explode(" ", $request->search);
				foreach ($searches as $search) {
					$people->where(function ($query) use ($search) {
						$query->orWhere('company_name', 'like', '%'.$search.'%');
						$query->orWhere('company_inn', 'like', '%'.$search.'%');
						$query->orWhere('first_name', 'like', '%'.$search.'%');
						$query->orWhere('last_name', 'like', '%'.$search.'%');
						$query->orWhere('middle_name', 'like', '%'.$search.'%');
						$query->orWhere('email', 'like', '%'.$search.'%');
						$query->orWhere('phone', 'like', '%'.$search.'%');
					});
				}
			}

			if (!empty($request->date_from)) {
            	$people->where('created_at', '>=', $request->date_from);
			}
            if (!empty($request->date_to)) {
            	$people->where('created_at', '<=', $request->date_to);
            }

			if (empty($request->deleted)) {
            	$people->where('deleted', '<>', 'on');

				if (!empty($request->listnew)) {
            		$people->where('confirm', NULL);
//					$people->whereRaw('( company_check_file is NULL or company_check_file = "")');
				}
				else {
//					$people->where('confirm', 'on');
				}
			}
			else {
            	$people->where('deleted', 'on');
			}

			if (!empty($request->region) && is_array($request->region)) {
				$regions = $request->region;
				$people->where(function ($query) use ($regions) {
					foreach ($regions as $region) {
						$query->orWhere('company_inn','like',$region.'%');
					}
				});
			}

			if (!empty($request->excel)) {
				$people->select(
					'id',
					'company_name',
					'company_inn',
					'company_ogrn',
					'company_bank_account',
					'company_correspondent_account',
					'company_bank_bik',
					'company_warehouse_address',
					'company_web_site',
					'company_description',
					'company_check_file',
					'phone',
					'email',
					'last_name',
					'first_name',
					'middle_name',
					'confirm',
					'deleted',
					'created_at',
					'updated_at'
				);
/**/				
				$time = time();
				
				$files = Storage::files('public/excel');
				foreach($files as $file) {
					$filedate = explode('.', $file);
					$filedate = array_shift($filedate);
					$filedate = explode('-',$filedate);
					$filedate = array_pop($filedate);
					if (!preg_match("/^[0-9]{14}$/",$filedate)) continue;
					if ($filedate < date('YmdHis',$time-60)) {
//					return response([ 'status' => 1, 'link' => '/storage/excel/'.basename($file)], 200);
						Storage::delete('public/excel/'.basename($file));
					}
				}
				
				Excel::store(new DirectoryPersonExport($people), 'public/excel/НАТС_Поставщики-'.date('YmdHis',$time).'.xls');
				return response([ 'status' => 1, 'link' => '/storage/excel/НАТС_Поставщики-'.date('YmdHis',$time).'.xls'], 200);
			}

			$people = $people->get(); 
            return response([ 'status' => 1, 'people' => $people ], 200); 
        }
    }

    public function edit(Request $request)
    {
        $user = User::find($request->user_id);
        $person = User::find($request->id);

        if (empty($person)) {
    		$person = new User;
            $api_token = Str::random(60);
            $confirm_token = substr(md5(uniqid('token' . time())), 0, 20);
            if (!empty($request->subdivision_id)) {
                $person->subdivision_id = $request->subdivision_id;
            }
            else {
                $person->subdivision_id = $user->subdivision_id;
            }
            $person->role_id = 102;
            $person->api_token = $api_token;
            $person->confirm_token = $confirm_token;
            $person->password = '';
            $text = 'Новый поставщик успешно добавлен';
        }
        else {
            $text = 'Информация о поставщике успешно обновлена';
        }
        $person->first_name = $request->first_name;
        $person->last_name = $request->last_name;
        $person->phone = $request->phone;
        $person->email = $request->email;
        $person->company_name = $request->company_name;
        $person->company_inn = $request->company_inn;
        $person->company_ogrn = $request->company_ogrn;
        $person->company_bank_account = $request->company_bank_account;
        $person->company_correspondent_account = $request->company_correspondent_account;
        $person->company_warehouse_address = $request->company_warehouse_address;
        $person->company_bank_bik = $request->company_bank_bik;
        $person->company_description = $request->company_description;
        $person->company_web_site = $request->company_web_site;
        $person->company_check_file = $request->company_check_file;
        $person->save();

    	return response([ 'status' => 1, 'person' => $person, 'text' => $text ], 200); 
    }

    public function edit_img(Request $request)
    {
        $person = User::find($request->id);

        if (!empty($person))
        {
            if ($person->avatar != null)
            {
                Storage::disk('local')->delete('avatars/600x600.'.$person->avatar);
                Storage::disk('local')->delete('avatars/150x150.'.$person->avatar);
                Storage::disk('local')->delete('avatars/50x50.'.$person->avatar);
                Storage::disk('local')->delete('avatars/48x48.'.$person->avatar);
            }

            $path = storage_path('app/avatars/');
            $rand = rand(100,999);
            $fileName = $person->id.'-'.$rand.'.'.$request->file->getClientOriginalExtension();

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

            $person->avatar = $fileName;
            $person->save();

            $text = 'Фотография поставщика успешно обновлена';
            return response([ 'status' => 1, 'text' => $text ], 200);
        }
    }

    public function edit_check_file(Request $request)
    {
        $customer = User::find($request->id);

        if (!empty($customer) && $request->file)
        {

			if ($customer->company_check_file != null)
            {
                Storage::disk('local')->delete('public/proofs/'.$customer->company_check_file);
            }

            $path = storage_path('app/public/proofs/');
            $fileName = 'NATS-'.$customer->company_inn.'-Check-'.$customer->id.'.'.$request->file->getClientOriginalExtension();
			
			Storage::disk('local')->put('public/proofs/'.$fileName, file_get_contents($request->file), 'public');

			$customer->company_check_file = $fileName;
            $customer->save();

            $text = 'Файл с результатами проверки успешно обновлен';
            return response([ 'status' => 1, 'text' => $text ], 200);
        }
    }

	public function get2(Request $request)
    {
        $user = User::find($request->user_id);

        if (!empty($request->id)) {
            $person = DirectoryPerson::with('user', 'busy')->find($request->id);
            if ($user->role_id != 1000 && $user->subdivision_id != $person->subdivision_id) {
                return response([ 'status' => 0, 'text' => 'Error' ], 200); 
            }
            else {
                $orderers = Orderer::with('directory_firm', 'directory_person', 'additional_place')->where('directory_person_id', $person->id)->get();
    
                $res = array(
                    'person' => $person,
                    'orderers' => $orderers
                );
                return response([ 'status' => 1, 'person' => $res ], 200); 
            }
        }
        else {

            $people = DirectoryPerson::with('user', 'orderers')->where('subdivision_id', $request->subdivision_id); 
            
            if ($request->limit > 0) {
                $people = $people->take($request->limit);
            }
            if ($request->is_delete == true) {
                $people = $people->where('deleted', 'on');
            }
            else {
                $people = $people->where('deleted', '!=', 'on');
            }

            if ($user->role_id == 101) {
                $customers = Customer::where('user_id', $user->id)->get();
                $array_id = array();
                foreach ($customers as $customer) {
                    array_push($array_id, $customer->id);
                }
                $orderers = Orderer::whereIn('customer_id', $array_id)->get();
                $people_array_id = array();
                foreach ($orderers as $orderer) {
                    array_push($people_array_id, $orderer->directory_person_id);
                }
                $uniq = array_unique($people_array_id);

                $people = $people->whereIn('id', $uniq);
            }

            if ($user->role_id == 102) {
                $people = $people->where('user_id', $user->id);
            }

            if ( $user->role_id == 103) { 
                $directory_firms = DirectoryFirm::where('user_id', $user->id)->get();
                $array_id = array();
                foreach ($directory_firms as $directory_firm) {
                    array_push($array_id, $directory_firm->id);
                }

                $orderers = Orderer::whereIn('directory_firm_id', $array_id)->get();
                $people_array_id = array();
                foreach ($orderers as $orderer) {
                    array_push($people_array_id, $orderer->directory_person_id);
                }
                $uniq = array_unique($people_array_id);
                $people = $people->whereIn('id', $uniq);
            }

            $people = $people->get();

            return response([ 'status' => 1, 'people' => $people ], 200); 
        }
    }

    public function edit2(Request $request)
    {
        $user = User::find($request->user_id);
    	$person = DirectoryPerson::find($request->id);

    	if (empty($person)){
    		$person = new DirectoryPerson;
            if (!empty($request->subdivision_id)) {
                $person->subdivision_id = $request->subdivision_id;
            }
            else {
                $person->subdivision_id = $user->subdivision_id;
            }
            
            $text = 'Новый преподаватель '.$request->full_name.' успешно добавлен';
            if ($request->role_id == 102) { $person->user_id = $request->user_id; }
            else if ( $request->role_id == 1000 ) { $person->user_id = $request->user['id']; }
    	}
        else {
            $text = 'Информация о преподавателе - '.$request->full_name.' успешно обновлена';
            $person->user_id = $request->user['id'];
        }
    	$person->full_name = $request->full_name;
    	$person->main_city = $request->main_city;
    	$person->main_metro = $request->main_metro;
    	$person->main_address = $request->main_address;
    	$person->work_location = $request->work_location;
        $person->main_phone = $request->main_phone;
        $person->main_email = $request->main_email;
        $person->specialist_level = $request->specialist_level;
        $person->zoom_email = $request->zoom_email;
        $person->save();

    	return response([ 'status' => 1, 'person' => $person, 'text' => $text ], 200); 
    }

    public function edit_img2(Request $request)
    {
        $person = DirectoryPerson::with('user')->find($request->id);

        if (!empty($person))
        {
            if ($person->avatar != null)
            {
                Storage::disk('local')->delete('avatars/600x600.'.$person->avatar);
                Storage::disk('local')->delete('avatars/150x150.'.$person->avatar);
                Storage::disk('local')->delete('avatars/50x50.'.$person->avatar);
                Storage::disk('local')->delete('avatars/48x48.'.$person->avatar);
            }

            $path = storage_path('app/avatars/');
            $rand = rand(100,999);
            $fileName = $person->id.'-'.$rand.'.'.$request->file->getClientOriginalExtension();

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

            $person->avatar = $fileName;
            $person->save();

            $text = 'Фотография преподавателя '.$person->full_name.' - успешно обновлена';
            return response([ 'status' => 1, 'text' => $text ], 200);
        }
    }

    public function delete(Request $request)
    {
        $person = DirectoryPerson::find($request->id);
        $person->deleted = 'on';
        $person->save();
        $text = 'Преподаватель "'.$person->full_name.'" успешно помещен в архив';
        return response([ 'status' => 1, 'person' => $person, 'text' => $text ], 200); 
    }

    public function restore(Request $request)
    {
        $person = DirectoryPerson::find($request->id);
        $person->deleted = '';
        $person->save();
        $text = 'Преподаватель "'.$person->full_name.'" успешно восстановлен из архива';
        return response([ 'status' => 1, 'person' => $person, 'text' => $text ], 200); 
    }

// Chernyshkov 20210821 Для подтверждения поставщиков (до готовности остальных компонентов пока ничего не делает)
	public function confirm(Request $request)
    {
		$this->passwordPlain = substr(md5(uniqid('testo' . time())), 0, 4);

		$user = User::find($request->id);
		$user->password = bcrypt($this->passwordPlain);
		$user->confirm = 'on';
        $user->save();
		
		// Если активна отправка по SMS - отправляем SMS
        if (Config('smsru.active') == true) {
            $api_id = Config('smsru.api_id');
            $phone = $user->phone;
            $message = Config('smsru.message_supplier_password_before') . $this->passwordPlain . Config('smsru.message_password_after');
            $body = file_get_contents("https://sms.ru/sms/send?api_id=".$api_id."&to=".$phone."&msg=".urlencode($message)."&json=1");
        }
		// Если SMS не ативна - отправляем E-mail
		else {
			$mail = new \App\Mail\SupplierConfirmed($user, $this->passwordPlain);
        	$mail->to($user->email);
        	Mail::send($mail);
		}
//        $text = 'Эта функция пока не работает, но скоро будет';
        $text = 'Поставщик '.$user->phone.' (id:'.$user->id.') подтвержден';
        return response([ 'status' => 1, 'person' => $user, 'text' => $text ], 200); 
    }

// Chernyshkov 20210821 Для подтверждения поставщиков (до готовности остальных компонентов пока ничего не делает)
	public function reject(Request $request)
    {
		$user = User::find($request->id);
		$user->deleted = 'on';
        $user->save();
		
		if (!empty($request->reason)) {
			$this->rejectReason = Config('smsru.message_supplier_before_reject_reason') . $request->reason;
		}
		
		// Если активна отправка по SMS - отправляем SMS
        if (Config('smsru.active') == true) {
            $api_id = Config('smsru.api_id');
            $phone = $user->phone;
            $message = Config('smsru.message_supplier_reject') . $this->rejectReason;
            $body = file_get_contents("https://sms.ru/sms/send?api_id=".$api_id."&to=".$phone."&msg=".urlencode($message)."&json=1");
        }
		// Если SMS не ативна - отправляем E-mail
		else {
			$mail = new \App\Mail\SupplierRejected($user, $this->rejectReason);
        	$mail->to($user->email);
        	Mail::send($mail);
		}
//        $text = 'Эта функция пока не работает, но скоро будет';
        $text = 'Поставщик '.$user->phone.' (id:'.$user->id.') отклонен и перемещен в архив '.$request->rejectReason;
        return response([ 'status' => 1, 'person' => $user, 'reason' => $this->rejectReason, 'text' => $text ], 200); 
    }


    public function get_busy_times(Request $request)
    {
        $date = date('Y-m-d');
        $busy_times = DirectoryPersonBusy::where('directory_person_id', $request->id)
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

        $busy_days_of_week = DirectoryPersonBusy::where('directory_person_id', $request->id)
                                        ->where('type', 'once_week')
                                        ->orderBy('week_day')
                                        ->get();

        $busy_times = DirectoryPersonBusy::where('directory_person_id', $request->id)
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
        $busy_time = DirectoryPersonBusy::find($request->id);
        if (empty($busy_time)) {
            $busy_time = new DirectoryPersonBusy;
            $busy_time->directory_person_id = $request->directory_person_id;
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

        $text = 'Данные о свободном времени преподавателя успешно обновлены';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function delete_busy_time(Request $request)
    {
        $busy_time = DirectoryPersonBusy::find($request->id);
        $busy_time->delete();

        $text = 'Данные о свободном времени преподавателя успешно обновлены';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }
}
