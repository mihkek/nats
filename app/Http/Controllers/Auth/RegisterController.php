<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\BillingTariffs;
use App\Libs\Helpers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Session\Middleware\StartSession;

use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $passwordPlain = '';
    protected $confirmToken = '';
    protected $apiToken = '';



    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
	//protected $redirectTo = '/admin/settings/personal/new';




    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }




    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        /*return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
        ]);*/
    }




    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
	protected function create(array $data) {

        $this->confirmToken = substr(md5(uniqid('token' . time())), 0, 20);
        $this->apiToken = Str::random(60);
        $tempPassword = "";

		if (Config('auth.global.need_confirm_email') != true) {
			$this->passwordPlain = substr(md5(uniqid('testo' . time())), 0, 4);
			$tempPassword = bcrypt($this->passwordPlain);
		}

		$referal_phone='';
		if (!empty($data['phone_afillate'])) {$ref_id = User::getReferalByPhone($data['phone_afillate']);} // реферрал если телефон
		if (!empty($ref_id)) {$referal_phone = $data['phone_afillate'];}
		if (empty($ref_id)) {$ref_id = Cookie::get('referred');} // получение реферрала из куки
		if (empty($ref_id)) {$ref_id = 0;} // нулевой реферрал используется по умолчанию

        $confirm = NULL;
        if (Config('auth.global.need_confirm_email') != true && Config('auth.global.need_confirm_sms') != true) {
            $confirm = 'on';
        }

        // 090223 поставщик не подвержден без администратора
        /*if ($data['role_id'] === 102) {
        	$confirm = NULL;
        }*/

		return User::create([
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'middle_name' => $data['middle_name'],
			'phone' => $data['phone'],
			'email' => $data['email'],
			'company_name' => $data['company_name'],
			'company_inn' => $data['company_inn'],
			'company_ogrn' => $data['company_ogrn'],
			'company_bank_account' => $data['company_bank_account'],
			'company_correspondent_account' => $data['company_correspondent_account'],
			'company_bank_bik' => $data['company_bank_bik'],
			'company_warehouse_address' => $data['company_warehouse_address'],
			'company_web_site' => $data['company_web_site'],
			'company_description' => $data['company_description'],
			'role_id' => $data['role_id'],
			'password' => $tempPassword,
            'confirm_token' => $this->confirmToken,
            'api_token' => $this->apiToken,
            'confirm' => $confirm,
			'ref_id' => $ref_id,
			'referal_phone' => $referal_phone,
			'ga' => isset($data['ga']) ? $data['ga'] : NULL, // 100423 гектарность
		]);
	}






    // ####################################################################################################################
    // функция успешной регистрации и отправки емейла и SMS пользователю
	protected function registered(Request $request, $user) {


        // ########### если требуется подтверждение по емейлу
        if (Config('auth.global.need_confirm_email') == true) {

            // отправка емейла со ссылкой на подтверждение
            $mail = new \App\Mail\UserNeedConfirm($user, $this->confirmToken);
            $mail->to($user->email);
            Mail::send($mail);
            return true;
        }


        // ########### если требуется подтверждение по SMS
        if (Config('auth.global.need_confirm_sms') == true && Config('smsru.active') == true) {

            // мы решили не делать отправку  SMS с кодом на подтверждение
            // какой в этом смысл? - если человеку по SMS отправляется пароль.
            // Это и есть подтверждение его телефона!
            // Ведь если он не получил пароль, то значит и телефон неправильный.
            // Возможно сюда когда-нибудь будет дописана процедура верификации телефона, но пока нет смысла

            // отправка SMS с паролем если подключены SMS вообще
            if (Config('smsru.active') == true) {
                $api_id = Config('smsru.api_id');
                $phone = $user->phone;
                $message = Config('smsru.message_password_before') . $this->passwordPlain . Config('smsru.message_password_after');
                $body = file_get_contents("https://sms.ru/sms/send?api_id=".$api_id."&to=".$phone."&msg=".urlencode($message)."&json=1");
            }

            return true;
        }


        // ########### если не требуется никаких подтверждений и произошла успешная регистрация и далее отправка пароля

        // отправка емейла с паролем
        $mail = new \App\Mail\UserRegistered($user, $this->passwordPlain);
        $mail->to($user->email);
        Mail::send($mail);

        // отправка SMS с паролем если подключены SMS вообще
        if (Config('smsru.active') == true) {
            $api_id = Config('smsru.api_id');
            $phone = $user->phone;
            $message = Config('smsru.message_password_before') . $this->passwordPlain . Config('smsru.message_password_after');
            $body = file_get_contents("https://sms.ru/sms/send?api_id=".$api_id."&to=".$phone."&msg=".urlencode($message)."&json=1");
        }

        return true;

	}










    // ####################################################################################################################
    public function register(Request $request) {

		//$this->validator($request->all())->validate();

        // Проверка почты
        $user = User::where('email', $request['email'])->first();
        if (!empty($user)) {
            return response([ 'status' => 0, 'text' => 'Пользователь с почтой '.$request['email'].' уже существует' ], 200);
        }

        // Проверка телефона
        $user = User::where('phone', $request['phone'])->first();
        if (!empty($user)) {
            return response([ 'status' => 0, 'text' => 'Пользователь с телефоном '.$request['phone'].' уже существует' ], 200);
        }

        // внесение нового юзера, то есть фактическая регистрация в БД
        event(new Registered($user = $this->create($request->all())));

        // **** ПРИВЯЗКА К ОРГАНИЗАЦИИ ****
        DB::table('users_org_to_user')->insert([
            'org_id' => 2,
            'user_id' => $user->id
        ]);

		//внесение тарифа по умолчанию (всегда "Стандарт")
		//$tariffs = config('tariffs');
		//Billing::orderTariff($user, $tariffs['STANDARD'], true);

		
        // ################## определение куда редиректить после регистрации ##################

		//если регистрируется поставщик (роль 102), ничего ему не отправляем, а редиректим его на сообщение о передае данных на проверку  - о результатах будет сообщего отжено после проверки
        if ($user->role_id == 102) {

            //return response([ 'status' => 1, 'text' => 'Регистрация прошла успешно', 'url' => '/login?needconfirmsupplier' ], 200);
            return response([ 'status' => 1, 'text' => 'Регистрация прошла успешно', 'url' => '/thanksforsupplier' ], 200);

            //return response()->json(['url' => '/login?needconfirm']);
        }


        // если требуется конфирм через Email
        if (Config('auth.global.need_confirm_email') == true) {
            $this->registered($request, $user);

            return response([ 'status' => 1, 'text' => 'Регистрация прошла успешно', 'url' => '/login?needconfirm' ], 200);
            //return response()->json(['url' => '/login?needconfirm']);
        }




        // если требуется конфирм через SMS
        if (Config('auth.global.need_confirm_sms') == true) {
            $this->registered($request, $user);

            Session()->flash('phone', $request['phone']);
            //return response([ 'status' => 1, 'text' => 'Регистрация прошла успешно', 'url' => '/login?needconfirmsms' ], 200);
            return response([ 'status' => 1, 'text' => 'Регистрация прошла успешно', 'url' => '/thanksforregistration' ], 200);

            //return response()->json(['url' => '/login?needconfirmsms']);
        }



        // если воощбе никаких конфирмов не требуется, то сразу переход в админку
        //$this->guard()->login($user);


        return response([ 'status' => 1, 'text' => 'Регистрация прошла успешно', 'url' => '/thanksforregistration' ], 200);

        //$this->registered($request, $user);
//		return response()->json([ 'status' => 1, 'text' => 'Регистрация прошла успешно', 'url' => '/admin/settings/personal/new']);



        

    }











    /*############### СТРАНИЦЫ РЕГИСТРАЦИИ ########################*/
	public function getRegistration() {
		return view('auth.reg');
	}

    public function getThanksForRegistration() {
        return view('auth.thanksforregistration');
    }

    public function getThanksForSupplier() {
        return view('auth.thanksforsupplier');
    }


	/*public function getRegistration() {
		$user = Auth::user();
		$data = [
			'user' =>$user,
			'reg' =>1,
		];
		return view('auth.reg', $data);
		}*/



/*############### СТРАНИЦЫ ПОДТВЕРЖДЕНИЯ РЕГИСТРАЦИИ ########################*/
/*	public function getConfirm() {
		$user = Auth::user();
		$data = [
			'user' =>$user,
			'confirm' =>1,
		];
		return view('auth.login', $data);
		} */
	public function getConfirmed() {
		$user = Auth::user();
		$data = [
			'user' =>$user,
//			'confirm' =>2,
		];
		return view('auth.login', $data);
		}





    /*####### процедура подтверждения верификации по урлу из Email письма ###############*/
	public function verification(Request $request) {
		$this->passwordPlain = substr(md5(uniqid('testo' . time())), 0, 6);

		// если юзер совсем новый и емейл не подтверждал
		if ($user = User::where('confirm_token', $request->confirmToken) -> where('confirm', null) -> first()) {
			$user->confirm = 'on';
			$user->password = bcrypt($this->passwordPlain);
			$user->save();

			$mail = new \App\Mail\UserRegistered($user, $this->passwordPlain);
			$mail->to($user->email);
			Mail::send($mail);
			return redirect('/login?confirmed');

		// если юзер уже подтвердил себя
		} else if ($user = User::where('confirm_token', $request->confirmToken) -> where('confirm', 'on') -> first()) {
			return redirect('/login?confirmedbefore');

		// если токен для подтверждения не найден
		} else {
			return redirect('/login?notfoundconfirm');
		}

	}

	// Mobile Api
	public function apiMobileVerification(Request $request) {
        $this->passwordPlain = substr(md5(uniqid('testo' . time())), 0, 6);

        // если юзер совсем новый и емейл не подтверждал
        if ($user = User::where('confirm_token', $request->confirmToken) -> where('confirm', null) -> first()) {
            $user->confirm = 'on';
            $user->password = bcrypt($this->passwordPlain);
            $user->save();

            $mail = new \App\Mail\UserRegistered($user, $this->passwordPlain);
            $mail->to($user->email);
            Mail::send($mail);
            return response()->json(['status' => 1, 'msg'=>'Для завершения регистрации необходимо проверить почту!' ,'redirect' => '/api/login?needconfirm'], 422);

            // если юзер уже подтвердил себя
        } else if ($user = User::where('confirm_token', $request->confirmToken) -> where('confirm', 'on') -> first()) {
            return response()->json(['status' => 1, 'msg'=>'Уже подтверждено!' ,'redirect' => '/api/login'], 419);

            // если токен для подтверждения не найден
        } else {
            return response()->json(['status' => 1, 'msg'=>'Токен не найден!'], 419 );
        }

    }


// Chernyshkov 20210805 for phone check in reg form
	public function getsmscode(Request $request) {
		
		$smscode = '';
		while (strlen($smscode) < 6) $smscode .= rand(0,9);
		
		$phoneplus = preg_replace("/[^0-9]/","",$request->phone).$smscode;
		$smscheck = array_sum(str_split($phoneplus));

		$phone = preg_replace("/[^+0-9]/","",$request->phone);
		
//		return response([ 'status' => 1, 'smscheck' => $smscheck, 'smscode' => $smscode, 'phone' => $phoneplus ], 200);

		if (Config('smsru.active') == true) {
            $api_id = Config('smsru.api_id');
            
            $message = Config('smsru.message_smscode_before') . $smscode . Config('smsru.message_smscode_after');
            $body = json_decode(file_get_contents("https://sms.ru/sms/send?api_id=".$api_id."&to=".$phone."&msg=".urlencode($message)."&json=1"));
			$key = false;
			$smsid = false;
			if ($body->status == "OK") {
//				$smsstatus = $body->sms->{0}->status;
				reset($body->sms);
				$smskey = key($body->sms);
				if ($body->sms->$smskey)
				if ($body->sms->$smskey->status == 'OK') {
					$smsid = $body->sms->$smskey->sms_id;
				}
			}
			if ($smsid) {
//				return response([ 'status' => 1, 'smscheck' => $smscheck, 'smsid' => $smsid, 'smscode' => $smscode , 'message' => $message, 'response' => $smsid], 200);
				return response([ 'status' => 1, 'smscheck' => $smscheck, 'smsid' => $smsid ], 200);
			}
			else {
				return response([ 'status' => 0, 'response' => $body], 200);
			}
        }
		else {
			return response([ 'status' => 0, 'message' => 'error: smsru not active in config'], 200);
		}
		
	}

	
// Function to check status of sent SMS message - requires $request->smsid where smsid is an id recieved when SMS was sent
	public function getsmsstatus(Request $request) {

		if (empty($request->smsid) || !preg_match("/^[0-9]{6}-[0-9]{7}$/",$request->smsid)) {
			return response([ 'status' => 0, 'message' => 'error: sms_id wrong or missing, can\'t proceed'], 200);
		}
		$smsid = $request->smsid;

		if (Config('smsru.active') == true) {
            $api_id = Config('smsru.api_id');
            
            $body = json_decode(file_get_contents("https://sms.ru/sms/status?api_id=".$api_id."&sms_id=".$smsid."&json=1"));
			if ($body->status == "OK" && $body->sms->$smsid->status == "OK") {
				$status_code = $body->sms->$smsid->status_code;
		return $status_code;
				if ($status_code > 99 && $status_code < 104) { // codes larger then 103 are error codes indicating that message not delivered and will never be
					return response([ 'status' => 1, 'status_code' => $status_code ], 200);
				}
				else {
					return response([ 'status' => 0, 'status_code' => $status_code], 200);
				}
			}
			else {
				return response([ 'status' => 0, 'response' => $body], 200);
			}
        }
		else {
			return response([ 'status' => 0, 'message' => 'error: smsru not active in config'], 200);
		}
/**/		
	}
	
}
