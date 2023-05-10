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
use Illuminate\Support\Str;

use App\Orderer;
use App\Customer;
use App\CustomerType;
use App\CustomerPay;
use App\CustomerGroup;
use App\CustomerPerson;
use App\DirectoryPerson;
use App\DirectoryFirm;
use App\CustomerSubscription;
use App\Models\Billing;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerExport;

use DB;
use File;
use Storage;
use PDF;

use Intervention\Image\Facades\Image as ImageInt;

class CustomerController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //############## ПОЛУЧЕНИЕ ДОГОВОРА PDF ##############
    public function get_contract_pdf(Request $request)
    {
        $customer = Customer::find($request->id);
        $pays = CustomerPay::where('customer_id', $customer->id)->get();
        $total_amount = 0;
        foreach ($pays as $pay)
        {
            $total_amount = $total_amount + $pay->amount;
        }

        $pdf_data = array(
            'customer' => $customer,
            'total_amount' => $total_amount,
            'contract_date' => date('d.m.Y', strtotime($customer->contract_date)),
        );

//        $pdf = PDF::loadView('admin.customer.pdf.contract', ['data' => $pdf_data]);
//        $pdf->save(storage_path().'/app/contracts/'.$customer->id.'.pdf');
//        return Storage::disk('local')->download('contracts/'.$customer->id.'.pdf');
return;
    }


    //############## ПОЛУЧЕНИЕ УВЕДОМЛЕНИЙ ##############
    public function get_notifications(Request $request)
    {
        $now = date('Y-m-d');
        $pays = CustomerPay::where('is_paid', 0)->where('date', '<', $now)->get();
        $notifications = array(
            'pays' => $pays->count(),
        );

        return response([ 'status' => 1, 'notifications' => $notifications ], 200);
    }

    //############## ДОБАВЛЕНИЕ ПЛАТЕЖА ##############
    public function add_pay(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        DB::table('billing')->insert([
            'user_id' => $customer->user_id,
            'lang' => 'ru',
            'created' => date('Y-m-d H:i:s'),
            'sum' => $request->amount,
            'payment_option' => $request->payment_option,
            'type' => 'payment',
            'description' => 'Платеж от клиента',
            'customer_id' => $customer->id,
            'org_id' => $customer->org_id,
        ]);

        $billing = DB::table('billing')->where('user_id', $customer->user_id)->orderBy('id', 'desc')->first();

        $pays = CustomerPay::where('customer_id', $customer->id)->where('is_paid', 0)->orderBy('date')->get();

        $amount = $request->amount;

        foreach ($pays as $pay) {
            if ($amount > 0) {
                // Считаем сколько нужно еще доплатить
                $due = $pay->amount - $pay->income;
                // Когда доплата больше 0
                if ($due > 0) {
                    // Если сумма больше чем нужная оплата
                    if ($amount > $due) {
                        // Сколько останется после оплаты
                        $amount = $amount - $due;
                        $pay->income = $pay->amount;
                        $pay->is_paid = 1;
                        $pay->paid_date = date('Y-m-d');
                    	$pay->billing_id = $billing->id;
                    }
                    // Если сумма меньше или равна нужной оплате
                    else {
                        // Прибавляем к уже оплаченым остаток суммы
                        $pay->income = $pay->income + $amount;
                        // Полностью ли оплачен платеж
                        $delta = $pay->amount - $pay->income;
                        // Если не полностью
                        if ($delta > 0) {
                            $pay->is_paid = 0;
                        }
                        else {
                            $pay->is_paid = 1;
                            $pay->paid_date = date('Y-m-d');
                    		$pay->billing_id = $billing->id;
                        }
                        $amount = 0;
                    }
                }
                else {
                    $pay->is_paid = 1;
                    $pay->paid_date = date('Y-m-d');
                    $pay->billing_id = $billing->id;
                }
                $pay->save();
            }
        }

        $text = 'Платеж от клиента успешно добавлен';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

	//############## ДОБАВЛЕНИЕ КЛИЕНТА ##############
	public function getAddCardRepresents(Request $request) {
		return view('admin.customer.list_represents_card_add');
		}

	//############## СПИСОК ФИРМ ##############
	public function getgetListFirms(Request $request) {
		return view('admin.customer.list_firms');
	}

    //############## ФИРМА ##############
    public function getCardFirm(Request $request) {
        return view('admin.customer.list_firms_card');
    }

	//############## СПИСОК ЛЮДЕЙ ##############
	public function getgetListPeoples(Request $request) {
		return view('admin.customer.list_peoples');
	}

	//############## ЧЕЛОВЕК ##############
	public function getCardPeople(Request $request) {
		return view('admin.customer.list_peoples_card');
	}

    //############## СПИСОК НОВЫХ КЛИЕНТОВ-ПАЦИЕНТОВ ##############
    public function getgetListNewRepresents(Request $request) {
        return view('admin.customer.list_new_represents');
    }
    //############## СПИСОК КЛИЕНТОВ-ПАЦИЕНТОВ ##############
    public function getgetListRepresents(Request $request) {
        return view('admin.customer.list_represents');
    }
    //############## ЧЕЛОВЕК ##############
    public function getCardRepresents(Request $request) {
        return view('admin.customer.list_represents_card');
    }

    //############## СПИСОК АРХИВ-ПАЦИЕНТОВ ##############
    public function getArchive(Request $request) {
        return view('admin.customer.archive');
    }

    //############## СПИСОК ГРУПП ##############
    public function getGroups(Request $request) {
        return view('admin.customer.groups');
    }

    //############## НОВАЯ ГРУППА ##############
    public function getNewGroup(Request $request) {
        return view('admin.customer.new_group');
    }

    //############## ГРУППА ##############
    public function getGroupCard(Request $request) {
        return view('admin.customer.group');
    }

    public function add_customer_paytable(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $customer->price = $request->price;

        $pays = CustomerPay::where('customer_id', $customer->id)->get();
        if ($pays->count() > 0) {
            $pays->each->delete();
        }
        foreach ($request->pays as $key => $pay)
        {
            $new_pay = new CustomerPay;
            $new_pay->group_id = $customer->group_id;
            $new_pay->customer_id = $customer->id;
            $new_pay->date = $pay['date_to'];
            $new_pay->amount = $pay['price'];
            $new_pay->save();
        }

        $customer->save();
        $text = 'График платежей для клиента успешно сохранен';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function edit_customer_paytable(Request $request)
    {
        $pay = CustomerPay::find($request->id);
        $pay->date = $request->date;
        $pay->amount = $request->amount;
        $pay->save();

        $text = 'Информация о платеже успешно изменена';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function clear_customer_paytable(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $customer->price = null;
        $pays = CustomerPay::where('customer_id', $customer->id)->get();
        if ($pays->count() > 0) {
            $pays->each->delete();
        }
        $customer->save();
        $text = 'График платежей для клиента успешно очищен';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function get_subscription_price(Request $request)
    {
        if ($request->id == 'standart') {
            $price = config('tariffs.STANDARD');
        }
        else if ($request->id == 'home') {
            $price = config('tariffs.HOME');
        }
        else if ($request->id == 'skype') {
            $price = config('tariffs.SKYPE');
        }

        return response([ 'status' => 1, 'pricelist' => $price ], 200);
    }

    public function add_subscription(Request $request)
    {
    	$customer = Customer::find($request->customer_id);
        $subscription = new CustomerSubscription;
        $subscription->user_id = $customer->user_id;
        $subscription->customer_id = $request->customer_id;
        $subscription->type = $request->type;
        $subscription->specialist_lvl = $request->specialist_lvl;
        $subscription->number_of_paid_orderers = $request->key;
        $subscription->price = $request->price;
        $subscription->orderer_price = $request->price/$request->key;
        $subscription->save();

        $text = 'Абонемент успешно предложен клиенту';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function del_subscription(Request $request)
    {
        $subscription = CustomerSubscription::find($request->id);
        $subscription->delete();

        $text = 'Предложение успешно отменено';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function pay_subscription(Request $request)
    {
        DB::beginTransaction();
        $subscription = CustomerSubscription::find($request->id);
        $subscription->is_active = 1;

        try {
            $subscription->save();
            Billing::buySubscription($subscription);
        } catch (BillingException $e) {
            DB::rollBack();
            return response([ 'status' => 0, 'text' => $e->getMessage() ], 417);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([ 'status' => 0, 'text' => $e->getMessage() ], 417);
        }
        DB::commit();
        $text = 'Абонемент успешно оплачен';

        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function edit_customer_subscription (Request $request)
    {
        $subscription = CustomerSubscription::find($request->id);
        if ($request->is_multiple == true) {
        	$subscription->is_multiple = 1;
        }
        else if ($request->is_multiple == false){
        	$subscription->is_multiple = 0;
        }
        else {
        	$subscription->is_multiple = $request->is_multiple;
        }
       /* $orderers_left = $subscription->number_of_paid_orderers - $subscription->number_of_completed_classes;
        $amount_left = $orderers_left*$subscription->orderer_price;
        $new_orderers_left = $amount_left/$request->orderer_price;*/
        $subscription->save();
        $text = 'Абонемент успешно изменен';

        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function get_types(Request $request)
    {
        $types = CustomerType::all();
        return response([ 'status' => 1, 'types' => $types ], 200);
    }

    public function get(Request $request)
    {
        if (!empty($request->id)) {
            $customer = User::find($request->id);
            return response([ 'status' => 1, 'customer' => $customer ], 200);
        }
        else {
            $customers = User::where('role_id', 101)->where('subdivision_id', $request->subdivision_id);

			if (!empty($request->search)) {
				$searches = explode(" ", $request->search);
				foreach ($searches as $search) {
					$customers->where(function ($query) use ($search) {
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
            	$customers->where('created_at', '>=', $request->date_from);
			}
            if (!empty($request->date_to)) {
            	$customers->where('created_at', '<=', $request->date_to);
            }

			if (empty($request->deleted)) {
            	$customers->where('deleted', '<>', 'on');
			}
			else {
            	$customers->where('deleted', 'on');
			}

			if (!empty($request->listnew)) {
            	$customers->whereRaw('( company_check_file is NULL or company_check_file = "")');
			}

			if (!empty($request->region) && is_array($request->region)) {
				$regions = $request->region;
				$customers->where(function ($query) use ($regions) {
					foreach ($regions as $region) {
						$query->orWhere('company_inn','like',$region.'%');
					}
				});
			}

			if (!empty($request->excel)) {
				$customers->select(
					'id',
					'company_name',
					'company_place',
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

				Excel::store(new CustomerExport($customers), 'public/excel/НАТС_Покупатели-'.date('YmdHis',$time).'.xls');
				return response([ 'status' => 1, 'link' => '/storage/excel/НАТС_Покупатели-'.date('YmdHis',$time).'.xls'], 200);
			}


            $customers = $customers->get();
            return response([ 'status' => 1, 'customers' => $customers ], 200);
        }
    }

    public function edit(Request $request)
    {
        $user = User::find($request->user_id);
        $customer = User::find($request->id);

        if (empty($customer)) {
    		$customer = new User;
            $api_token = Str::random(60);
            $confirm_token = substr(md5(uniqid('token' . time())), 0, 20);
            if (!empty($request->subdivision_id)) {
                $customer->subdivision_id = $request->subdivision_id;
            }
            else {
                $customer->subdivision_id = $user->subdivision_id;
            }
            $customer->role_id = 101;
            $customer->api_token = $api_token;
            $customer->confirm_token = $confirm_token;
            $customer->password = '';
            $text = 'Новый покупатель успешно добавлен';
        }
        else {
            $text = 'Информация о покупателе успешно обновлена';
        }
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->company_name = $request->company_name;
        $customer->company_inn = $request->company_inn;
        $customer->company_ogrn = $request->company_ogrn;
        $customer->company_bank_account = $request->company_bank_account;
        $customer->company_correspondent_account = $request->company_correspondent_account;
        $customer->company_bank_bik = $request->company_bank_bik;
        $customer->company_description = $request->company_description;
        $customer->company_check_file = $request->company_check_file;
        $customer->company_place = $request->company_place;

        if (!empty($request->ga)) {
        $customer->ga = $request->ga; //100423
        }

        $customer->save();

    	return response([ 'status' => 1, 'customer' => $customer, 'text' => $text ], 200);
    }

    public function edit_img(Request $request)
    {
        $customer = User::find($request->id);

        if (!empty($customer))
        {
            if ($customer->avatar != null)
            {
                Storage::disk('local')->delete('public/avatars/600x600.'.$customer->avatar);
                Storage::disk('local')->delete('public/avatars/150x150.'.$customer->avatar);
                Storage::disk('local')->delete('public/avatars/50x50.'.$customer->avatar);
                Storage::disk('local')->delete('public/avatars/48x48.'.$customer->avatar);
            }

            $path = storage_path('app/public/avatars/');
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


            $img->resize(600, 600)->save($path.'600x600.'.$fileName);
            $img->resize(150, 150)->save($path.'150x150.'.$fileName);
            $img->resize(50, 50)->save($path.'50x50.'.$fileName);
            $img->resize(48, 48)->save($path.'48x48.'.$fileName);

            $customer->avatar = $fileName;
            $customer->save();

            $text = 'Фотография покупателя успешно обновлена';
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
            $customer = Customer::with('type', 'directory_firm', 'directory_person', 'user', 'people', 'subscriptions', 'group')->find($request->id);
            if (!empty($customer->group)) {
                foreach ($customer->group->orderers as $orderer) {
                    $orderer->customer_status = 1;
                }
            }
            if ($customer->subdivision_id != $user->subdivision_id) {
                # code...
                return response([ 'status' => 0, 'text' => 'Error' ], 200);
            }
            else {
                $res = array( 'customer' => $customer );
                return response([ 'status' => 1, 'customer' => $res ], 200);
            }
        }
        else {
            $customers = DB::table('customers')->where('subdivision_id', $request->subdivision_id);

            if ($request->limit > 0) {
                $customers->take($request->limit);
            }
            if ($user->role_id == 101) {
                $customers->where('user_id', $user->id);
            }
            if ($request->is_delete == true) {
                $customers->where('deleted', 'on')
                        ->whereIn('successful', $request->successful);
            }
            else {
                $customers->where('deleted', '!=', 'on');
            }
            if (!empty($request->group_id)) {
                if ($request->group_id < 0) {
                    $customers->whereNull('group_id');
                }
                else {
                    $customers->where('group_id', $request->group_id);
                }
            }
            if (!empty($request->status)) {
                $customers->whereIn('status', $request->status);
            }

            if ($user->role_id == 102) {

                $directory_persons = DirectoryPerson::where('user_id', $user->id)->get();
                $array_id = array();
                foreach ($directory_persons as $directory_person) {
                    array_push($array_id, $directory_person->id);
                }
                $orderers = Orderer::whereIn('directory_person_id', $array_id)->get();
                $customer_array_id = array();
                foreach ($orderers as $orderer) {
                    array_push($customer_array_id, $orderer->customer_id);
                }

                $uniq = array_unique($customer_array_id);

                $customers->whereIn('directory_person_id', $array_id)
                          ->orWhereIn('id', $uniq);
            }

            if (!empty($request->group_id)) {
                if ($request->group_id == -1) {
                    $customers->where('group_id', NULL);
                }
            }

            $customers = $customers->get();
            $res = array();

            foreach ($customers as $customer)
            {
                $total_due = 0;
                $total_income = 0;

                $pays = CustomerPay::where('customer_id', $customer->id)->orderBy('date')->get();

                foreach ($pays as $pay) {
                    if ($pay->income > 0) {
                        $total_income = $total_income + $pay->income;
                        if ($pay->income != $pay->amount) {
                            $total_due = $pay->amount - $pay->income;
                        }
                    }
                    else {
                        $total_due = $total_due + $pay->amount;
                    }
                }

                $customer->total_due = $total_due;
                $customer->total_income = $total_income;
                $now = date('Y-m-d');
                $group = CustomerGroup::find($customer->group_id);
                $next_pay = CustomerPay::where('customer_id', $customer->id)
                                                ->where('is_paid', 0)
                                                ->orderBy('date')
                                                ->first();

                $customer_translation = DB::table('customer_translation')->where('customer_id', $customer->id)->where('locale', $request->_lang)->first();

                if (!empty($customer_translation)) {
                    $customer->full_name = $customer_translation->full_name;
                    $customer->child_full_name = $customer_translation->child_full_name;
                }
                if (!empty($next_pay)) {
                    $customer->next_pay = $next_pay;
                    $customer->next_pay_date = $next_pay->date;
                    $customer->next_pay_amount = $next_pay->amount - $next_pay->income;
                }
                if (!empty($group)) {
                    $customer->group = $group;
                }

                if (!empty($request->notifications_filter)) {
                    if ($request->notifications_filter == 1) {
                        if (!empty($next_pay)) {
                            if ($next_pay->date < $now) {
                                array_push($res, $customer);
                            }
                        }
                    }
                }
                else {
                    array_push($res, $customer);
                }
            }

            return response([ 'status' => 1, 'customers' => $res ], 200);
        }
    }

    public function edit2(Request $request)
    {
        $user = User::find($request->user_id);
        $customer = Customer::find($request->id);

        if (empty($customer)){
            $customer = new Customer;
            $customer->subdivision_id = $user->subdivision_id;
            $text = 'Новый клиент '.$request->full_name.' успешно добавлен';
            if ($request->role_id == 101) { $customer->user_id = $request->user_id; }
            else if ( $request->role_id == 1000 ) { $customer->user_id = $request->user['id']; }
        }
        else {
            $text = 'Информация о клиенте - '.$request->full_name.' успешно обновлена';
            $customer->user_id = $request->user['id'];
            $customer->comment = $request->comment;
            $customer->status = $request->status;
            $customer->status_option = $request->status_option;
        }
        $customer->nationality = $request->nationality;
        $customer->passport_number = $request->passport_number;
        $customer->passport_issued = $request->passport_issued;
        if ($customer->fact_address == null || $customer->fact_address == $customer->reg_address) {
            $customer->fact_address = $request->reg_address;
        }
        else {
            $customer->fact_address = $request->fact_address;
        }
        $customer->contract_number = $request->contract_number;
        $customer->contract_date = $request->contract_date;
        $customer->reg_address = $request->reg_address;
        $customer->group_id = $request->group['id'];
        $customer->full_name = $request->full_name;
        $customer->child_full_name = $request->child_full_name;
        $customer->main_city = $request->main_city;
        $customer->main_metro = $request->main_metro;
        $customer->main_address = $request->main_address;
        $customer->age = $request->age;
        $customer->gender = $request->gender;
        $customer->type_id = $request->type_id;
        $customer->main_phone = $request->main_phone;
        $customer->main_email = $request->main_email;
        $customer->directory_firm_id = $request->directory_firm['id'];
        $customer->directory_person_id = $request->directory_person['id'];
        $customer->save();

        return response([ 'status' => 1, 'customer' => $customer, 'text' => $text ], 200);
    }

    public function edit_img2(Request $request)
    {
        $customer = Customer::with('user')->find($request->id);

        if (!empty($customer))
        {
            if ($customer->avatar != null)
            {
                Storage::disk('local')->delete('avatars/600x600.'.$customer->avatar);
                Storage::disk('local')->delete('avatars/150x150.'.$customer->avatar);
                Storage::disk('local')->delete('avatars/50x50.'.$customer->avatar);
                Storage::disk('local')->delete('avatars/48x48.'.$customer->avatar);
            }

            $path = storage_path('app/avatars/');
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

            $img->resize(600, 600)->save($path.'600x600.'.$fileName);
            $img->resize(150, 150)->save($path.'150x150.'.$fileName);
            $img->resize(50, 50)->save($path.'50x50.'.$fileName);
            $img->resize(48, 48)->save($path.'48x48.'.$fileName);

            $customer->avatar = $fileName;
            $customer->save();

            $text = 'Фотография помещения '.$customer->full_name.' - успешно обновлена';
            return response([ 'status' => 1, 'text' => $text ], 200);
        }
    }

    public function delete(Request $request)
    {
    	$customer = Customer::find($request->id);
        $customer->deleted = 'on';
        $customer->successful = $request->successful;
        $customer->save();
        $text = 'Клиент "'.$customer->full_name.'" успешно помещен в архив';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function restore(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->deleted = '';
        $customer->successful = null;
        $customer->save();

        $text = 'Клиент "'.$customer->full_name.'" успешно восстановлен из архива';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function edit_customer_person(Request $request)
    {
        $person = CustomerPerson::find($request->id);
        if (empty($person)) {
            $person = new CustomerPerson;
            $person->customer_id = $request->customer_id;
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

    public function delete_customer_person(Request $request)
    {
        $person = CustomerPerson::find($request->id);
        $text = 'Информация о персоне '.$person->full_name.' успешно удалена';
        $person->delete();

        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function get_customer_subscriptios(Request $request)
    {
        $subscriptions = CustomerSubscription::where('user_id', $request->user_id)->where('is_active', 1)->get();
        $orders_total = 0;
        $orders_completed = 0;
        $orders_left = 0;

        foreach ($subscriptions as $subscription)
        {
            $orders_total = $orders_total + $subscription->number_of_paid_orderers;
            $orders_completed = $orders_completed + $subscription->number_of_completed_classes;
            $orders_left = $orders_left + ($subscription->number_of_paid_orderers - $subscription->number_of_completed_classes);
        }
        $res = array(
            'orders_total' => $orders_total,
            'orders_completed' => $orders_completed,
            'orders_left' => $orders_left,
        );

        return response([ 'status' => 1, 'subscriptions' => $res ], 200);
    }

}
