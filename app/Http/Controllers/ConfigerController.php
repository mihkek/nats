<?php

namespace App\Http\Controllers;

use App\Subdivision;
use App\Models\ConfigerUsers;
use App\Models\ConfigerUsersRoles;
use App\Models\Drugs;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConfigerExport;

use DB;
use File;
use Storage;

use Intervention\Image\Facades\Image as ImageInt;

use App\Models\User;

use \ConvertApi\ConvertApi;



class ConfigerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get_subdivisions(Request $request)
    {
    	if (!empty($request->id)) {
    		$subdivision = Subdivision::with('city')->find($request->id);
        	return response([ 'status' => 1, 'subdivision' => $subdivision ], 200); 
    	}
    	else {
    		$subdivisions = Subdivision::with('city')->where('deleted', '!=', 'on')->get();
        	return response([ 'status' => 1, 'subdivisions' => $subdivisions ], 200); 
    	}
    }

    public function edit_subdivision(Request $request)
    {
    	if (!empty($request->id)) {
    		$subdivision = Subdivision::find($request->id);
    		$text = 'Информация о подразделении успешно изменена';
    	}
    	else {
    		$subdivision = new Subdivision;
    		$text = 'Новое подразделение успешно добавлено';
    	}
    	$subdivision->city_id = $request->city_id;
    	$subdivision->full_name = $request->full_name;
    	$subdivision->name = $request->name;
    	$subdivision->legal_address = $request->legal_address;
    	$subdivision->physical_address = $request->physical_address;
    	$subdivision->inn = $request->inn;
    	$subdivision->kpp = $request->kpp;
    	$subdivision->ogrn = $request->ogrn;
    	$subdivision->checking_account = $request->checking_account;
    	$subdivision->correspondence_account = $request->correspondence_account;
    	$subdivision->bik = $request->bik;
    	$subdivision->save();

        return response([ 'status' => 1, 'text' => $text, 'subdivision' => $subdivision ], 200); 
    }

    public function delete_subdivision(Request $request)
    {
    	$subdivision = Subdivision::find($request->id);
    	$subdivision->deleted = 'on';
    	$subdivision->save();
    	$text = 'Подразделение успешно удалено';
        return response([ 'status' => 1, 'text' => $text ], 200); 
    }

	//############## ПРОСТЫЕ ТЕКСТОВЫЕ СТРАНИЦЫ ##############
	public function getHelp(Request $request) {
		return view('admin.configer.help');
		}
	public function getConvertapi(Request $request) {
		ConvertApi::setApiSecret( Config('convertapi.ApiSecret') );
		$info = ConvertApi::getUser();
		$data = [
			'SecondsLeft' => $info['SecondsLeft'],
			];
		return view('admin.configer.convertapi', $data);
		}


	public function get_cities()
	{
		$cities = DB::table('cities')->get();
		foreach ($cities as $city) {
			$items = DB::table('directory_firms')
						->join('directory_firms_translation', 'directory_firms_translation.directory_firm_id', 'directory_firms.id')
						->where('directory_firms.city_id', $city->id)
						->where('directory_firms.type', 2)
						->select('directory_firms.id', 'directory_firms_translation.full_name')
						->get();
			$city->items = $items;
		}
        return response()->json(['cities' => $cities]);
	}


	//############## ШАГ 1 ЗАПРОСА НОВОГО ТОКЕНА ДЛЯ API ЧУЖОГО САЙТА ##############
	public function getToken(Request $request) {
		$data = [
			'step' => 1,
			];
		return view('admin.configer.api_token', $data);
		}

	//############## ШАГ 2 ЗАПРОСА НОВОГО ТОКЕНА ДЛЯ API ЧУЖОГО САЙТА ##############
	public function postToken(Request $request) {

		// простейшие проверки
		if (!($request->name) || !($request->url)) {
			return redirect('/admin/configer/token');
		}

		// внесение сайта в базу данных
		$oauth_client = new \App\Models\oAuthClient();
		$oauth_client->name = $request->name;
		$oauth_client->secret = hash_hmac('md5', time(), "secret", false);
		$oauth_client->redirect = $request->url; // "https://circleerp.ru/callback";
		$oauth_client->password_client = 0;
		$oauth_client->personal_access_client = 0;
		$oauth_client->revoked = 0;
		$oauth_client->save();

		// формирование ссылки для запроса авторизации
		$oauth_url = '/oauth/authorize?' . http_build_query([
			'client_id' => $oauth_client->id,
			'redirect_uri' => $oauth_client->redirect,
			'response_type' => 'code',
			'scope' => '',
		]);

		// финальная передача данных
		$data = [
			'step' => 2,
			'oauth_client_redirect' => $oauth_client->redirect,
			'oauth_client_id' => $oauth_client->id,
			'oauth_client_secret' => $oauth_client->secret,
			'oauth_url' => $oauth_url,
			];
		return view('admin.configer.api_token', $data);
		}


	//############## СПИСОК ПОЛЬЗОВАТЕЛЕЙ ##############
	public function getSubdivisions(Request $request)
	{
		return view('admin.configer.subdivisions');
	}
	public function getSubdivisionCard(Request $request)
	{
		return view('admin.configer.subdivision_card');
	}
	public function getNewSubdivision(Request $request)
	{
		return view('admin.configer.subdivision_card_add');
	}

	//############## СПИСОК ПОЛЬЗОВАТЕЛЕЙ ##############
	public function getUsers(Request $request) {

		// получение юзеров
		$rows = ConfigerUsers::orderBy('id', 'desc')->get();

		// финальная передача данных
		$data = [
			'rows' => $rows,
			];
		return view('admin.configer.users', $data);
		}

	//############## КАРТОЧКА ПОЛЬЗОВАТЕЛЯ #############
	public function getUserCard(Request $request) {
		return view('admin.configer.user_card');
	}

	//############## НОВЫЙ ПОЛЬЗОВАТЕЛЬ #############
	public function getNewUser(Request $request) {
		return view('admin.configer.user_card_add');
	}

	//############## АРХИВ ПОЛЬЗОВАТЕЛЕЙ #############
	public function getUsersArchive(Request $request) {
		return view('admin.configer.user_archive');
	}

	//############## КАРТОЧКА РОЛИ #############
	public function getRoleCard(Request $request) {
		return view('admin.configer.role_card');
	}

	//############## НОВАЯ РОЛЬ #############
	public function getNewRole(Request $request) {
		return view('admin.configer.role_card_add');
	}



	//############## СПИСОК РОЛЕЙ ##############
	public function getRoles(Request $request) {

		// получение юзеров
		$rows = ConfigerUsersRoles::orderBy('id', 'asc')->get();

		// финальная передача данных
		$data = [
			'rows' => $rows,
			];
		return view('admin.configer.roles', $data);
		}


	//############## РОЛИ ##############

	public function get_roles(Request $request)
	{
		$roles = ConfigerUsersRoles::orderBy('id', 'asc')->get();
        return response([ 'status' => 1, 'roles' => $roles ], 200); 
	}

	public function edit_role(Request $request)
	{
		if (!empty($request->id)) {
			$role = ConfigerUsersRoles::find($request->id);
			$text = 'Роль успешно изменена';
			if ($request->id != $request->new_id) {
				$role->id = $request->new_id;
			}
		}
		else {
			$role = new ConfigerUsersRoles;
			$text = 'Новая роль успешно добавлена';
			$role->id = $request->new_id;
		}
		
		$role->name = $request->name;
		$role->description = $request->description;
		$role->save();

        return response([ 'status' => 1, 'text' => $text ], 200); 
	}

	//############## ПОЛЬЗОВАТЕЛИ ##############
	public function get_users(Request $request)
	{
		if (!empty($request->id)) {
			$user = User::with('role')->find($request->id);
        	return response([ 'status' => 1, 'user' => $user ], 200); 
		}
		else {
//			$user = User::find($request->user_id);

			$users = User::with('role')->orderBy('id', 'asc')->where('subdivision_id', $request->subdivision_id);
			if (!empty($request->role_id)) {
				$users->where('role_id', $request->role_id);
			}

			if (!empty($request->search)) {
				$searches = explode(" ", $request->search);
				foreach ($searches as $search) {
					$users->where(function ($query) use ($search) {
						$query->orWhere('company_name', 'like', '%'.$search.'%');
						$query->orWhere('first_name', 'like', '%'.$search.'%');
						$query->orWhere('last_name', 'like', '%'.$search.'%');
						$query->orWhere('middle_name', 'like', '%'.$search.'%');
						$query->orWhere('email', 'like', '%'.$search.'%');
						$query->orWhere('phone', 'like', '%'.$search.'%');
					});
				}
			}

			if (empty($request->deleted)) {
				$users->where('deleted', '!=', 'on');
			}
			else {
				$users->where('deleted', 'on');
			}
			
			if (!empty($request->date_from)) {
            	$users->where('created_at', '>=', $request->date_from);
			}
            if (!empty($request->date_to)) {
            	$users->where('created_at', '<=', $request->date_to);
            }
			if (!empty($request->region) && is_array($request->region)) {
				$regions = $request->region;
				$users->where(function ($query) use ($regions) {
					foreach ($regions as $region) {
						$query->orWhere('company_inn','like',$region.'%');
					}
				});
			}

			// Если выгрузка в Эксель
			
			if (!empty($request->excel)) {
				$users->select(
					'id',
					'role_id',
					'last_name',
					'first_name',
					'middle_name',
					'phone',
					'email',
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
				
				Excel::store(new ConfigerExport($users), 'public/excel/НАТС_Пользователи-'.date('YmdHis',$time).'.xls');
				return response([ 'status' => 1, 'link' => '/storage/excel/НАТС_Пользователи-'.date('YmdHis',$time).'.xls'], 200);
			}

			
			$users = $users->get();
        	return response([ 'status' => 1, 'users' => $users ], 200);
		}
	}
/*
	private function users_list_query(Request $request) {
		
		$users = User::with('role')->orderBy('id', 'asc')->where('subdivision_id', $request->subdivision_id);
		
			if (!empty($request->role_id)) {
				$users->where('role_id', $request->role_id);
			}

			if (!empty($request->search)) {
				$search = $request->search;
				$users->where(function ($query) use ($search) {
					$query->orWhere('first_name', 'like', '%'.$search.'%');
					$query->orWhere('last_name', 'like', '%'.$search.'%');
					$query->orWhere('middle_name', 'like', '%'.$search.'%');
					$query->orWhere('email', 'like', '%'.$search.'%');
					$query->orWhere('phone', 'like', '%'.$search.'%');
				});
			}

			if (empty($request->deleted)) {
				$users->where('deleted', '!=', 'on');
			}
			else {
				$users->where('deleted', 'on');
			}
			
			if (!empty($request->date_from)) {
            	$users->where('created_at', '>=', $request->date_from);
			}
		
            if (!empty($request->date_to)) {
            	$users->where('created_at', '<=', $request->date_to);
            }
		
			if (!empty($request->region) && is_array($request->region)) {
				$regions = $request->region;
				$users->where(function ($query) use ($regions) {
					foreach ($regions as $region) {
						$query->orWhere('company_inn','like',$region.'%');
					}
				});
			}

			return $users;
	}
/**/
	public function edit_user(Request $request)
	{
		$auth_user = User::find($request->user_id);
		if (!empty($request->id)) {
			$text = 'Информация о сотруднике успешно изменена';
			$user = User::find($request->id);
			$user->role_id = $request->role_id;
			$user->subdivision_id = $request->subdivision_id;
			$user->first_name = $request->first_name;
    		$user->last_name = $request->last_name;
    		$user->phone = $request->phone;
    		$user->email = $request->email;
			$user->company_name = $request->company_name;
        	$user->company_inn = $request->company_inn;
        	$user->company_ogrn = $request->company_ogrn;
        	$user->company_bank_account = $request->company_bank_account;
        	$user->company_correspondent_account = $request->company_correspondent_account;
        	$user->company_warehouse_address = $request->company_warehouse_address;
        	$user->company_bank_bik = $request->company_bank_bik;
        	$user->company_description = $request->company_description;
			$user->confirm = $request->confirm;
			$user->save();
		}
		else {
			$user = new User;
			$password = Str::random(6);
			$user->password = bcrypt($password);
			$user->role_id = $request->role_id;
			$user->subdivision_id = $request->subdivision_id;
			$text = 'Новый сотрудник успешно добавлен';
			$user->first_name = $request->first_name;
    		$user->last_name = $request->last_name;
    		$user->phone = $request->phone;
    		$user->email = $request->email;
			$user->company_name = $request->company_name;
        	$user->company_inn = $request->company_inn;
        	$user->company_ogrn = $request->company_ogrn;
        	$user->company_bank_account = $request->company_bank_account;
        	$user->company_correspondent_account = $request->company_correspondent_account;
        	$user->company_warehouse_address = $request->company_warehouse_address;
        	$user->company_bank_bik = $request->company_bank_bik;
        	$user->company_description = $request->company_description;
			$user->save();

			// ЗАГЛУШКА НА ПРИВЯЗКУ ЮЗЕРА К ОРГАНИЗАЦИИ
			DB::table('users_org_to_user')->insert([
				'org_id' => 2,
				'user_id' => $user->id
			]);

			// ОТПРАВКА НА ПОЧТУ
			$mail = new \App\Mail\CreateUser($request->email, $password);
			$mail->to($request->email);
			Mail::send($mail);
		}
        return response([ 'status' => 1, 'text' => $text, 'user' => $user ], 200); 
	}

	public function delete_user(Request $request)
	{
		$user = User::find($request->id);
		$user->deleted = 'on';
		$user->save();

		$text = 'Пользователь успешно помещен в архив';
        return response([ 'status' => 1, 'text' => $text ], 200); 
	}

	public function restore_user(Request $request)
	{
		$user = User::find($request->id);
		$user->deleted = '';
		$user->save();

		$text = 'Пользователь успешно восстановлен из архива';
        return response([ 'status' => 1, 'text' => $text ], 200); 
	}

	public function edit_user_img(Request $request)
    {
    	$user = User::find($request->id);
    	if ($user->avatar != null)
        {
            Storage::disk('local')->delete('public/avatars/600x600.'.$user->avatar);
            Storage::disk('local')->delete('public/avatars/150x150.'.$user->avatar);
            Storage::disk('local')->delete('public/avatars/50x50.'.$user->avatar);
            Storage::disk('local')->delete('public/avatars/48x48.'.$user->avatar);
        }

        $path = storage_path('app/public/avatars/');
        $rand = rand(100,999);
        $fileName = $user->id.'-'.$rand.'.'.$request->file->getClientOriginalExtension();

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

        $user->avatar = $fileName;
        $user->save();

    	$text = 'Личная фотография успешно изменена';

       	return response([ 'status' => 1, 'text' => $text ], 200); 
    }

	public function edit_user_pass(Request $request)
	{
		$user = User::find($request->id);
		$user->password = bcrypt($request->password);
		$user->save();
		
		$text = 'Пароль успешно изменен';
        return response([ 'status' => 1, 'text' => $text ], 200); 
    }

    public function get_directory_person_users(Request $request)
	{
		$user = User::find($request->user_id);
		$users = User::where('role_id', 102)->where('subdivision_id', $user->subdivision_id)->get();
        return response([ 'status' => 1, 'users' => $users ], 200); 
	}

	public function get_directory_firm_users(Request $request)
	{
		$user = User::find($request->user_id);
		$users = User::where('role_id', 103)->where('subdivision_id', $user->subdivision_id)->get();
        return response([ 'status' => 1, 'users' => $users ], 200); 
	}

	public function get_customer_users(Request $request)
	{
		$user = User::find($request->user_id);
		$users = User::where('role_id', 101)->where('subdivision_id', $user->subdivision_id)->get();
        return response([ 'status' => 1, 'users' => $users ], 200); 
	}

	public function get_company_users(Request $request)
	{
		$user = User::find($request->user_id);
		$users = User::whereIn('role_id', [1004])->where('subdivision_id', $user->subdivision_id)->get();
        return response([ 'status' => 1, 'users' => $users ], 200); 
	}

	public function get_directory_users(Request $request)
	{
		$user = User::find($request->user_id);
		$users = User::whereIn('role_id', [102, 103])->where('subdivision_id', $user->subdivision_id)->get();
        return response([ 'status' => 1, 'users' => $users ], 200); 
	}

	public function get_managers_users(Request $request)
	{
		$user = User::find($request->user_id);
		$users = User::whereIn('role_id', [1005])->where('subdivision_id', $user->subdivision_id)->get();
        return response([ 'status' => 1, 'users' => $users ], 200); 
	}

	// СОЗДАЕМ СТАНДАРТНЫЙ КОНФИГ ДОСТУПА К СТРАНИЦАМ И ПОЛЯМ 
	public function create_access_config(Request $request)
	{
		
	}



    // УПРАВЛЕНИЕ СМС АПИ
    public function getSms(Request $request)
    {
        return view('admin.configer.sms.index');
    }

    public function get_sms_balance(Request $request)
    {
        $api_id = Config('smsru.api_id');
        $balance = 0;
        $body = file_get_contents("https://sms.ru/my/balance?api_id=".$api_id."&json=1");
        $balance = json_decode($body);

        return response([ 'status' => 1, 'balance' => $balance ], 200);
    }

	// УПРАВЛЕНИЕ ПРЕПАРАТАМИ/СРЕДСТВАМИ
	
	
	//############## СПИСОК СРЕДСТВ ##############
	public function getDrugs(Request $request) {

		// получение списка
		$rows = Drugs::orderBy('title', 'asc')->get();

		/*foreach ($rows as $row) {
			$row->analogs = !empty($row->analogs) ? json_decode($row->analogs) : NULL;
		}*/

		// финальная передача данных
		$data = [
			'rows' => $rows,
			];
		return view('admin.configer.drugs', $data);
		}


	//############## СРЕДСТВА ##############

	public function get_drugs(Request $request)
	{
		$drugs = Drugs::orderBy('title', 'asc')->get();

		/*foreach ($drugs as $row) {
			$row->analogs = !empty($row->analogs) ? json_decode($row->analogs) : NULL;
		}*/

        return response([ 'status' => 1, 'drugs' => $drugs ], 200); 
	}

	//060423
	public function getDvDrugs(Request $request)
	{
		$drug_options = array();
		if (!empty($request->active_material)) {
			$drugs = Drugs::where("active_material",$request->active_material)->get();
			foreach ($drugs as $drug) {
				if (!empty($drug->title)) {
			        array_push($drug_options, trim($drug->title));
			    }
			}				
		}	
		return response([ 'status' => 1, 'drugs' => $drug_options ], 200); 
	}	


	
	public function getAnalogsDrugs(Request $request)
	{
		$drug_options = array();

		//290822
		/*if (!empty($request->title)) {
			$drug = Drugs::where("title",$request->title)->first();
			$analogs = !empty($drug->analogs) ? json_decode($drug->analogs) : NULL;
			if (!empty($analogs)) {
				$drugs = Drugs::whereIn('id',$analogs)->orderBy('title', 'asc')->get();				
			} else {
				$drugs = Drugs::all();
			}
			foreach ($drugs as $drug_val) {
		        array_push($drug_options, ['id' => trim($drug_val->id),'title' => trim($drug_val->title)]);
		     }
		}*/

		//141022		
		if (!empty($request->title)) {
			$drug = Drugs::where("title",$request->title)->first();
			$analogs = !empty($drug->analogs) ? explode(";",$drug->analogs) : NULL;
			if (!empty($analogs)) {									
				foreach ($analogs as $drug_val) {
			        array_push($drug_options,  trim($drug_val));
			    }	
			} else {
				/*$drugs = Drugs::all();
				foreach ($drugs as $drug_val) {
			        array_push($drug_options, trim($drug_val->title));
			    }*/
			}			
		}

		//old
		/*if (!empty($request->analogs))) {
			$arr_drugs = $request->analogs;
		} else {
			$arr_drugs = ["1","3"];
		}		
		$drugs = Drugs::whereIn('id',$arr_drugs)->orderBy('title', 'asc')->get();
		$options = array();
		foreach ($drugs as $drug) {
            array_push($options, ['id' => trim($drug->id),'title' => trim($drug->title)]);
        }*/ 
		/*foreach ($drugs as $row) {
			$row->analogs = !empty($row->analogs) ? json_decode($row->analogs) : NULL;
		}*/
        return response([ 'status' => 1, 'drugs' => $drug_options ], 200); 
	}



	public function edit_drug(Request $request)
	{
		$analogs = !empty($request->analogs) ? $request->analogs : NULL;
		$dv1 = !empty($request->dv1) ? $request->dv1 : NULL;
		$dv2 = !empty($request->dv2) ? $request->dv2 : NULL;

		if (!empty($request->id)) {
			
			Drugs::where('id',$request->id)->update(['title'=>$request->title, 'active_material'=>$request->active_material, 'analogs'=>$analogs, 'dv1' => $dv1, 'dv2' => $dv2]);
			$text = 'Средство изменено';
		}
		else {
			$drug = new Drugs;
			$drug->title = $request->title;
			$drug->active_material = $request->active_material;
			$drug->analogs = $analogs;
			$drug->dv1 = $dv1;
			$drug->dv2 = $dv2;

//        return response([ 'status' => 1, 'text' => print_r($drug,true) ], 200); 
			$drug->save();
			$text = 'Новое средство добавлено';
		}
		
        return response([ 'status' => 1, 'text' => $text ], 200); 
	}

	public function delete_drug(Request $request)
	{
		if (!empty($request->id)) {
			$drug = Drugs::find($request->id);
			$drug->delete();
			$text = 'Средство удалено';
		}
		else {
			$text = 'Ошибка удаления средства, попробуйте еще раз';
		}
		
        return response([ 'status' => 1, 'text' => $text ], 200); 
	}

	// Mobile Api Роли
	public function apiMobileGetRoles(Request $request)
    {
        $roles = ConfigerUsersRoles::whereRaw('id in (101,102)')->orderBy('id', 'asc')->get();
        return response([ 'status' => 1, 'roles' => $roles ], 200);
    }


    // Mobile Api Изменить пароль
    public function apiMobileEditUserPass(Request $request) {
    	if ($request->password == $request->passwordConfirm){
                $user = User::find(Auth::user()->id);
                $user->password = bcrypt($request->password);
                $user->save();
                $text = 'Пароль успешно изменен';
                return response([ 'status' => 1, 'text' => $text ], 200);
        }    	
	}

	
}
