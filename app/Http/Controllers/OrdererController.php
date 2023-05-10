<?php 

namespace App\Http\Controllers;

use App\Exceptions\BillingException;
use App\Libs\ZoomUs;
use App\Models\Billing;
use App\Models\OrdererZoomConference;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;

use App\Orderer;
use App\OrdererStatus;
use App\Customer;
use App\DirectoryPerson;
use App\DirectoryFirm;
use App\OrdererAdditionalPlace;
use App\OrdererCustomer;

use DB;

class OrdererController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //############## ОТМЕЧАЕМ ПРИСУТСТВИЕ ПОЛЬЗОВАТЕЛЯ НА ЗАНЯТИИ ##############
    public function mark_customer(Request $request)
    {
        $orderer = Orderer::find($request->order_id);
        $customer = Customer::find($request->id);

        $orderer_customer = OrdererCustomer::where('orderer_id', $orderer->id)
                                            ->where('customer_id', $customer->id)
                                            ->first();

        if (!empty($orderer_customer)) {
            $orderer_customer->delete();
            $text = 'Отметка о присутсвии клиента успешно удалена';
        }
        else {
            $orderer_customer = new OrdererCustomer;
            $orderer_customer->orderer_id = $orderer->id;
            $orderer_customer->customer_id = $customer->id;
            $orderer_customer->save();
            $text = 'Отметка о присутсвии клиента на занятии успешно добавлена';
        }

        return response([ 'status' => 1, 'text' => $text], 200); 
    }


	public function get(Request $request)
    {
        $user = User::find($request->user_id);
        if (!empty($request->id))
        {
            $orderer = Orderer::with('group', 'directory_firm', 'directory_person', 'next_orderer', 'additional_place', 'order_status', 'conferences')->find($request->id);
            if ($orderer->subdivision_id != $user->subdivision_id) {
                return response([ 'status' => 0, 'text' => 'Error' ], 200); 
            }
            else {
                $orderer->format_d1te_time = date('d.m.Y H:i', strtotime($orderer->date_time));
                $today = date('Y-m-d H:i');
                if ($today > $orderer->date_time)
                {
                    $orderer->not_complete = true;
                }   
                foreach ($orderer->group->customers as $customer) {
                    $orderer_customer = OrdererCustomer::where('orderer_id', $orderer->id)
                                                        ->where('customer_id', $customer->id)
                                                        ->first();
    
                    if (!empty($orderer_customer)) {
                        $customer->orderer_mark = true;
                    }
                    else {
                        $customer->orderer_mark = false;
                    }
                }
    
                return response([ 'status' => 1, 'orderer' => $orderer ], 200); 
            }
        }
        else
        {
            if ($user->role_id == 1000)
            {
                $orderers = Orderer::with('group', 'directory_firm', 'directory_person', 'additional_place', 'order_status', 'conferences')
                                    ->whereIn('status', $request->status)
                                    ->where('subdivision_id', $user->subdivision_id)
                                    ->get();
            }
            else if ($user->role_id == 101)
            {
                $customers = Customer::where('user_id', $user->id)->get();
                
                $array_id = array();
                foreach ($customers as $customer) {
                    array_push($array_id, $customer->id);
                }
                
                $orderers = Orderer::with('group', 'directory_firm', 'directory_person', 'additional_place', 'order_status', 'conferences')
                                    ->whereIn('status', $request->status)
                                    ->whereIn('customer_id', $array_id)
                                    ->where('subdivision_id', $user->subdivision_id)
                                    ->get();
            }
            else if ($user->role_id == 102)
            {
                $directory_persons = DirectoryPerson::where('user_id', $user->id)->get();
                
                $array_id = array();
                foreach ($directory_persons as $directory_person) {
                    array_push($array_id, $directory_person->id);
                }

                $orderers = Orderer::with('group', 'directory_firm', 'directory_person', 'additional_place', 'order_status')
                                    ->whereIn('status', $request->status)
                                    ->whereIn('directory_person_id', $array_id)
                                    ->where('subdivision_id', $user->subdivision_id)
                                    ->get();

                return response([ 'status' => 1, 'orderers' => $orderers, 'qq' => $array_id], 200); 
            }
            else if ($user->role_id == 103)
            {
                $directory_firms = DirectoryFirm::where('user_id', $user->id)->get();
                
                $array_id = array();
                foreach ($directory_firms as $directory_firm) {
                    array_push($array_id, $directory_firm->id);
                }
                $orderers = Orderer::with('group', 'directory_firm', 'directory_person', 'additional_place', 'order_status')
                                    ->whereIn('status', $request->status)
                                    ->whereIn('directory_firm_id', $array_id)
                                    ->where('subdivision_id', $user->subdivision_id)
                                    ->get();
            }

            foreach ($orderers as $orderer)
            {
                $orderer->format_date_time = date('d.m.Y H:i', strtotime($orderer->date_time));
            }

            return response([ 'status' => 1, 'orderers' => $orderers], 200); 
        }
    }

    public function get_additional_places(Request $request)
    {
        $orderer_additional_places = OrdererAdditionalPlace::all();
        return response([ 'status' => 1, 'orderer_additional_places' => $orderer_additional_places ], 200); 
    }

    public function get_statuses(Request $request)
    {
        $statuses = OrdererStatus::all();
        return response([ 'status' => 1, 'statuses' => $statuses ], 200); 
    }

    public function get_next(Request $request)
    {
        $user = User::find($request->id);
        $orderer = $user->next_orderer();
        return response([ 'status' => 1, 'orderer' => $orderer ], 200); 
    }

    public function edit(Request $request)
    {
        $user = User::find($request->user_id);
        // Ищем занятие
    	$orderer = Orderer::find($request->id);
        // Если нет то создаем новое
    	if (empty($orderer)){
    		$orderer = new Orderer;
            $orderer->subdivision_id = $user->subdivision_id;
            $orderer->status = 1;
            $text = 'Новое занятие успешно создано';
    	}
        // Если да то берем старое
        else {
            $text = 'Информация о занятии успешно обновлена';
        }

        // Если есть даты
        if ($request->date != null) { 
            $orderer->date_time = $request->date.' '.$request->time.':00'; 
            $orderer->end_date_time = date('Y-m-d H:i:s', strtotime($orderer->date_time.'+ 30 minutes'));
            $orderer->time_to = date('H:i', strtotime($orderer->date_time.'+ 30 minutes'));
        }
        $orderer->date = $request->date;
        $orderer->time = $request->time;

        // Если меняется предодаватель, проверка на занятость
        if ($orderer->directory_person_id != $request->directory_person['id']) {
            $directory_person = DirectoryPerson::find($request->directory_person['id']);
            $orderer->directory_person_id = $request->directory_person['id'];
    
            $directory_person_busy = $directory_person->is_busy($orderer->date_time, $orderer->end_date_time);
    
            if ($directory_person_busy == true) {
                $text = 'Выбранный преподаватель занят в это время';
                return response([ 'status' => 0, 'text' => $text, 'error' => 'directory_person_busy' ], 200); 
            }
        }

        if (!empty($request->directory_firm['option'])) {
            if ($request->directory_firm['option'] == true) {
                $orderer->directory_firm_id = null;
                $orderer->orderer_additional_place_id = $request->directory_firm['id'];
            }
        }
        else if (empty($request->additional_place)) {
            $orderer->orderer_additional_place_id = null;
            if ($orderer->directory_firm_id != $request->directory_firm['id'])
            {
                $directory_firm = DirectoryFirm::find($request->directory_firm['id']);
                $orderer->directory_firm_id = $request->directory_firm['id'];
                $directory_firm_busy = $directory_firm->is_busy($orderer->date_time, $orderer->end_date_time);
                if ($directory_firm_busy == true) {
                    $text = 'Выбранное помещение занято в это время';
                    return response([ 'status' => 0, 'text' => $text, 'error' => 'directory_firm_busy' ], 200); 
                }
            }
        }
        else if (!empty($request->additional_place) && empty($request->directory_firm)){
            $orderer->orderer_additional_place_id = $request->additional_place['id'];
            $orderer->directory_firm_id = null;
        }
        else {
            $orderer->orderer_additional_place_id = null;
            if ($orderer->directory_firm_id != $request->directory_firm['id'])
            {
                $directory_firm = DirectoryFirm::find($request->directory_firm['id']);
                $orderer->directory_firm_id = $request->directory_firm['id'];
                $directory_firm_busy = $directory_firm->is_busy($orderer->date_time, $orderer->end_date_time);
                if ($directory_firm_busy == true) {
                    $text = 'Выбранное помещение занято в это время';
                    return response([ 'status' => 0, 'text' => $text, 'error' => 'directory_firm_busy' ], 200); 
                }
            }
        }

    	
    	$orderer->comment = $request->comment;
    	$orderer->save();

    	$this->processConferences($orderer);

    	return response([ 'status' => 1, 'orderer' => $orderer, 'text' => $text ], 200); 
    }


    public function processConferences(&$orderer) {
	    if ($orderer->orderer_additional_place_id == 2 && $orderer->date_time > date('Y-m-d H:i:s')) {
            $isConference = true;
        } else {
            $isConference = false;
        }

        // Проверяем, есть ли у преподавателя зум. Если нет - дальше делать нечего
        if (!$orderer->directory_person || !$orderer->directory_person->zoom_email) {
            return;
        }

        if ($orderer->status_id == 3) { // Занятие завершено. Дальше делать нечего
            return;
        }

        $conferences = $orderer->conferences;
        $zoom = new ZoomUs();
        $zoomEmail = $orderer->directory_person->zoom_email;

        if ($isConference) {
            if ($conferences->count()) { // Если конференция есть - убеждаемся, что время корректное. Если нет - правим.
                foreach ($conferences as $conference) {
                    if ($conference->date_time != $orderer->date_time) {
                        $data = $zoom->updateMeeting($conference->conference_id, [
                            'name' => 'Урок',
                            'date_time' => $orderer->date_time,
                            'duration' => 30,
                        ]);

                        if ($data) {
                            $conference->date_time = $orderer->date_time;
                            $conference->save();
                        }
                    }
                }

            } else { // Иначе просто создаем
                $data = $zoom->createMeeting($zoomEmail, [
                    'name' => 'Урок',
                    'date_time' => $orderer->date_time,
                    'duration' => 30,
                ]);

                if ($data) {
                    $conference = new OrdererZoomConference();
                    $conference->fill([
                        'conference_id' => $data->id,
                        'url_join' => $data->url_join,
                        'url_start' => $data->url_start,
                        'date_time' => $orderer->date_time,
                    ]);
                    $orderer->conferences()->save($conference);
                }
            }

        } else {
            // Если конференции нет, то смотрим, есть ли у нас конференции, и если есть - подчищаем.
            foreach ($conferences as $conference) {
                $zoom->deleteMeeting($conference->conference_id);
                $conference->delete();
            }
        }
    }


    public function confirm(Request $request)
    {
        DB::beginTransaction();

        $orderer = Orderer::find($request->id);
        //$orderer->is_complete = 1;
        $orderer->status = 3;
        $next_orderer_id = null;

        if (!empty($request->next_orderer_date))
        {
            $next_orderer = new Orderer;
            $next_orderer->customer_id = $orderer->customer_id;

            if ($request->new_place['option'] == false) {
                $next_orderer->directory_firm_id = $request->new_place['id'];
                $next_orderer->orderer_additional_place_id = null;
            }
            else if ($request->new_place['option'] == true) {
                $next_orderer->directory_firm_id = null;
                $next_orderer->orderer_additional_place_id = $request->new_place['id'];
            }

            $next_orderer->directory_person_id = $orderer->directory_person_id;
            $next_orderer->date = $request->next_orderer_date;
            $next_orderer->time = $request->next_orderer_time;
            if ($request->next_orderer_date != null)
            {
                $next_orderer->date_time = $request->next_orderer_date.' '.$request->next_orderer_time.':00';
                $next_orderer->end_date_time = date('Y-m-d H:i:s', strtotime($next_orderer->date_time.'+ 30 minutes'));
                $next_orderer->time_to = date('H:i', strtotime($next_orderer->date_time.'+ 30 minutes'));
            }
            $next_orderer->save();
            $orderer->next_orderer_id = $next_orderer->id;
            $next_orderer_id = $next_orderer->id;
        }
        foreach ($request->subscriptions as $subscription)
        {
            if ($subscription['is_on'] == 1) {
                $orderer->customer_subscription_id = $subscription['id'];
            }
        }
        //$orderer->save();
       	try {
            $orderer->save();
            Billing::buyService($orderer);
        } catch (BillingException $e) {
            DB::rollBack();
            return response([ 'status' => 0, 'text' => $e->getMessage() ], 417);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([ 'status' => 0, 'text' => $e->getMessage() ], 417);
        }

        $text = 'Занятие успешно подтверждено';
        DB::commit();

        return response([ 'status' => 1, 'text' => $text, 'next_orderer_id' => $next_orderer_id ], 200);
    }

    public function close(Request $request)
    {
    	DB::beginTransaction();
    	$orderer = Orderer::find($request->id);
    	$orderer->status = 3;

    	if ($request->subscription != null)
        {
        	if ($request->subscription['is_on'] == 1) {
        		$orderer->customer_subscription_id = $request->subscription['id'];
        	}
        }

    	try {
            $orderer->save();
            Billing::buyService($orderer);
        } catch (BillingException $e) {
            DB::rollBack();
            return response([ 'status' => 0, 'text' => $e->getMessage() ], 417);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([ 'status' => 0, 'text' => $e->getMessage() ], 417);
        }

    	$text = 'Занятие успешно закрыто';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function cancel(Request $request)
    {
        $orderer = Orderer::find($request->id);
        $orderer->status = 4;
        $orderer->action_reason = $request->cancel_reason;
        $orderer->action_comment = $request->cancel_comment;
        $orderer->save();
        $desc = 'Занятие успешно отменено';
        return response([ 'status' => 1, 'text' => $desc ], 200); 
    }

    public function transfer(Request $request)
    {
        $orderer = Orderer::find($request->id);
        $orderer->status = 2;
        $orderer->action_reason = $request->transfer_reason;
        $orderer->action_comment = $request->transfer_comment;
        $orderer->date = $request->next_orderer_date;
        $orderer->time = $request->next_orderer_time;

        if ($request->next_orderer_date != null)
        {
            $orderer->date_time = $request->next_orderer_date.' '.$request->next_orderer_time.':00'; 
            $orderer->end_date_time = date('Y-m-d H:i:s', strtotime($orderer->date_time.'+ 30 minutes'));
            $orderer->time_to = date('H:i', strtotime($orderer->date_time.'+ 30 minutes'));
        }

        if ($request->new_place['option'] == false) {
            $orderer->directory_firm_id = $request->new_place['id'];
            $orderer->orderer_additional_place_id = null;
        }
        else if ($request->new_place['option'] == true) {
            $orderer->directory_firm_id = null;
            $orderer->orderer_additional_place_id = $request->new_place['id'];
        }

        if ($request->new_place['option'] == false) {
            $directory_firm = DirectoryFirm::find($request->new_place['id']);
            $directory_firm_busy = $directory_firm->is_busy($orderer->date_time, $orderer->end_date_time);
            if ($directory_firm_busy == true) {
                $text = 'Выбранное помещение занято в это время';
                return response([ 'status' => 0, 'text' => $text ], 200); 
            }
        }

        $directory_person = DirectoryPerson::find($orderer->directory_person_id);
        $directory_person_busy = $directory_person->is_busy($orderer->date_time, $orderer->end_date_time);
        if ($directory_person_busy == true) {
            $text = 'Выбранный преподаватель занят в это время';
            return response([ 'status' => 0, 'text' => $text ], 200); 
        }

        $orderer->save();
        $desc = 'Занятие успешно перенесено';
        return response([ 'status' => 1, 'text' => $desc ], 200); 
    }



	//############## ПРОСТЫЕ ТЕКСТОВЫЕ СТРАНИЦЫ ##############
	public function getHelp(Request $request) {
		return view('admin.orderer.help');
		}



	//############## ЗАКАЗЫ АКТУАЛЬНЫЕ ##############
	public function getListNow(Request $request) {
		return view('admin.orderer.list_now');
		}

	//############## ЗАКАЗЫ АРХИВ ##############
	public function getList(Request $request) {
		return view('admin.orderer.list');
		}

	//############## ЗАКАЗ ##############
	public function getCard(Request $request) {
		return view('admin.orderer.list_card');
		}

    //############## КАЛЕНДАРЬ ##############
    public function getСalendar(Request $request) {
        return view('admin.orderer.calendar');
    }

    //############## ДОБАВИТЬ ЗАНЯТИЕ ##############
    public function getAdd(Request $request) {
        return view('admin.orderer.add');
    }
}
