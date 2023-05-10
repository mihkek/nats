<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
//use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\Mail;
use DB;

use App\Promoter;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers; 
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

	protected function attemptLogin(Request $request) {

		// preg_replace('~\D+~','', $string);
		$identity = $request->post("email");
		$password = $request->post("password");

		if (!filter_var($identity, FILTER_VALIDATE_EMAIL)) {
			$identity = preg_replace('~\D+~','', $identity);
			$identity = '+'.substr($identity, 0, 1).'('.substr($identity, 1, 3).')'.substr($identity, 4, 3).'-'.substr($identity, 7, 2).'-'.substr($identity, 9, 2);
		}

		return \Auth::attempt([
			filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone' => $identity,
			'password' => $password
		]);
	}

    public function go(Request $request)
    {
    	$promoter = DB::table('promoters')->where('code_opc', $request->id)->where('deleted', '!=', 'on')->first();

    	if (!empty($promoter)) {
    		
    		$subdivision = DB::table('subdivisions')->where('id', $promoter->subdivision_id)->first();

    		if ($request->city_id == $subdivision->city_id) {

    			$user = User::where('id', $promoter->user_id)->first();
    		
    			if (!empty($user)) {
    				DB::table('promoters')->where('code_opc', $request->id)->update(['directory_firm_id' => $request->directory_firm_id]);
    				Auth::login($user, false);
					return response()->json([ 'status' => 1, 'redirect' => '/promouter' ], 200);
    			}
    			else {
        			return response([ 'status' => 0, 'text' => 'Пользователь не найден' ], 200); 
    			}
    		}
    	}
    	else {
        	return response([ 'status' => 0, 'text' => 'Пользователь не найден' ], 200); 
    	}
    }

    	/*################## если логин успешно прошёл, но ещё ДО отправки пользователю события ####*/
	protected function authenticated(Request $request, $user) {




		if (Config('auth.global.need_confirm_email') == true && $user->confirm != 'on') {
			$this->registeredNoConfirm($request, $user);
			Auth::logout();
			//$request->session()->regenerateToken();
			return response()->json(['redirect' => '/login?needconfirm'], 422);

			throw ValidationException::withMessages([
				'redirect' => '/login?needconfirm',
			]);
		}

		if ($user->role_id == 1000) {
		    Cookie::queue('superuser_id', $user->id, 60 * 24 * 30 * 12);
        }
        
        //090223 покупатель подвержен, поставщик на проверке
        if ($user->role_id == 101) {
	        if ($user->confirm != 'on') {
				$user->confirm = 'on';
				$user->save();
			}
		}
		//090223 неправильно
        // при первом логине меняем на подтвержденный (раз смог получить пароль, занчит можно подтверждать)
		/*if ($user->confirm != 'on') {
			$user->confirm = 'on';
			$user->save();
		}*/

		//если в архиве
		if ($user->deleted === 'on') {
			Auth::logout();
			return response()->json([
				'message' => 'The given data was invalid.',
				'errors' => [
					'email' => 'Ваш аккаунт удален',
				],
			], 401);
		}

		//если не подвержен
		if ($user->confirm != 'on') {
			Auth::logout();
			return response()->json([
				'message' => 'The given data was invalid.',
				'errors' => [
					'email' => 'Ваши данный на проверке, дождитесь звонка администратора',
				],
			], 401);
		}




		
		// при логине из мобильных приложений
		if (Route::currentRouteName() == "mobile") {

			/* это пригодится потом в других модулях когда обращаются за запросом
			if ($request->session) {
			    $session=addslashes($request->session);
			    $_COOKIE['PHPSESSID'] = $session;
			    $_SESSION['PHPSESSID'] = $session;
			    $minutes = 60*24*30;
			    Cookie::queue('PHPSESSID', $session, $minutes);
			} */

			$session = $user->id . ":" . substr(md5(uniqid('1st' . time())), 0, 32) . ":" . substr(md5(uniqid('2nd' . time())), 0, 32);
            $minutes = 60*24*30*12; // на год
			Cookie::queue('PHPSESSID', $session, $minutes);
			$_SESSION['PHPSESSID'] = $session;

            if (!$user->api_token) {
                $user->api_token = Str::random(60);
            }
            $user->save();

            return response()->json([
                'session' => $session,
				'time' => time(),
				'error' => 0,
				'errorMessage' => '',
				'data' => [
					'session' => $session,
					'user' => [
						'id' => $user->id,
                        'api_token' => $user->api_token, // MRNX: используется в моб приложении
						'login' => $user->email,
						'email' => $user->email,
						'_name' => $user->name,
						'name' => $user->name,
						'username' => $user->name,
						'_url' => "https://getlaw.ru",
						'create_time' => $user->created,
						'lang' => 'ru', // важно для моб.приложения
						'delete' => '',
						'country' => $user->country,
						'country_ru' => $user->country, // потом переделать на языки
						'region' => '',
						'region_ru' => '',
						'city' => $user->city,
						'city_ru' => $user->city, // потом переделать на языки
						'address' => $user->address,
						'phone' => $user->phone,
						'company' => '',
						'position' => '',
						'sex' => $user->sex,
						'avatar' => 'https://getlaw.ru/img_public/test_avatar.jpg', // потом заменить
						'real' => '',
						'birthday' => '',
						'age' => 0,
						'height' => 0,
						'weight' => 0,
						'is_moderator' => '',
						'code' => '',
						'unique' => 'e581cc0bf16f697c6e2446b7146d7d61', // потом заменить
						'bann_unique' => '',
						'moderator' => '',
						'rating' => 0,
						'relogin' => '',
						'text' => '',
						'displayname' => $user->name . " " . $user->name_patronymic . " " . $user->name_family,
						'discount_cumulative' => '',
						'discount_percent' => '',
						'discount_rur' => '',
						'discount_usd' => '',
						'discount_eur' => '',
						'confirmed' => true, // важно для моб.приложения
						'photos' => [],
						'photosCount' => 0,
						'billing' => 999999, // биллинг добавить сюда
					],
					'globalstat' => [
						'active_total' => 999,
						'user_total' => 999,
						'photo_total' => 999,
						'love_total' => 999,
						'traveler_total' => 999,
						'traveler_total' => 999,
						'soderzhanki_total' => 999,
						'friends_total' => 999,
						'job_total' => 999,
						'blog_total' => 999,
						'users_total' => 999,
						'real-love_total' => 999,
						'bq-new-year-2018_total' => 999,
					]
				],
			]);





		// при логине из веб-сайта
		} else {
		    $intendedUrl = $request->session()->pull('url.intended');
			return response()->json(['redirect' => $intendedUrl ? $intendedUrl : '/admin'], 422);
		}
	}
	/*############################################################################*/



	/*################## отправка мейла если человек зарегистрирован но ещё не подтвердил себя ####*/
	protected function registeredNoConfirm(Request $request, $user) { 
		$mail = new \App\Mail\UserNeedConfirm($user, $user->confirm_token);
		$mail->to($user->email);
		Mail::send($mail);
		return true;
	}
	/*############################################################################*/



	/*############### при неудачной аутентификации пользователя ########################*/
	protected function sendFailedLoginResponse(Request $request) {

		// при логине из мобильных приложений
		if (Route::currentRouteName() == "mobile") {
			return response()->json([
				'time' => time(),
				'error' => 1,
				'errorMessage' => 'Неправильный логин и/или пароль',
				'data' => [
					'ok' => 'empty',
				],
				'session' => '',
				'debug' => [
					'request' => $request,
				],
			], 401);

		// при логине из веб-сайта
		} else {
			return response()->json([
				'message' => 'The given data was invalid.',
				'errors' => [
					'email' => 'Неправильный логин и/или пароль',
				],
			], 401);
		}

	}
	/*############################################################################*/



	/**/
	// возможно пригодится если нужно будет логиниться с проверкой каких-нибудь жестких параметров
	/*public function credentials(Request $request) {
		$credentials = $request->only($this->username(), 'password');
		$credentials = array_add($credentials, 'confirm', 'on');
		return $credentials;
		$credentials = $request->only($this->email(), 'password');
        //$credentials = array_add($credentials, 'deleted', 'on');
        $credentials['deleted'] = 'on';
        return $credentials;
	}*/

	/*
	// это ответ после успешной аутентификации пользователя, может быть пригодится потом
	protected function sendLoginResponse(Request $request) {
		$this->clearLoginAttempts($request);
		return response()->json(['url' => $this->redirectPath()]);
	}
	*/

	public function getGo(Request $request) {
	    $user = Auth::user();
		$data = [
			'user' =>$user,
		];
		return view('auth.go', $data);
		}

	/*############### СТАТИЧНЫЕ СТРАНИЦЫ ЛОГИНА ########################*/
	public function getLogin(Request $request) {
	    $user = Auth::user();
		$data = [
			'user' =>$user,
		];
		return view('auth.login', $data);
		}
	/*############################################################################*/


    // Эта функция выполняется при логауте пользователя. Удаляем админскую куку
    protected function loggedOut(Request $request) {
        Cookie::queue(Cookie::forget('superuser_id'));
    }


    public function getRelogin(Request $request) {
        if (User::isSuperUser()) {
            $user = User::find(User::isSuperUser());
            if ($user) {
                Auth::login($user, true);
            }
        }

        return redirect()->to($request->back);
    }

    public function postRelogin(Request $request) {
        if (!User::isSuperUser()) {
            return response()->json(['success' => false, 'reason' => 'Доступ запрещен']);
        }

        $user = User::find($request->id)->where('deleted', '!=', 'on');
        if (!$user) {
            return response()->json(['success' => false, 'reason' => 'Нет такого пользователя']);
        }
        Auth::loginUsingId($request->id);
//        Auth::login($user, true);
        return response()->json(['success' => true]);
    }



    // Mobile Api login
    public function apiMobileLogin(Request $request)
    {

        $credentials='email';

        $identity = $request->email;
		$password = $request->password;

		if(!empty($request->firebase_token)) { $firebase_token = $request->firebase_token; }
		else { $firebase_token = NULL; }

        if(is_numeric($identity)){
            $credentials = 'phone';
        }
        $data = [
            $credentials => $identity,
            'password' => $password,
        ];
        if (\Auth::attempt($data)) {
            $user = auth()->user();

            if ($user->deleted === 'on') {
            	return response()->json(['error' => 'Неправильный логин и/или пароль'], 401);
            }
            
            if(!empty($firebase_token)) { $user->firebase_token = $firebase_token;  $user->save(); }
            if (Config('auth.global.need_confirm_email') == true && $user->confirm != 'on') {
                $this->registeredNoConfirm($request, $user);
                Auth::logout();
                //$request->session()->regenerateToken();
                return response()->json(['status' => 1, 'msg'=>'Для завершения регистрации необходимо проверить почту!' ,'redirect' => '/api/login?needconfirm'], 422);

                throw ValidationException::withMessages([
                    'redirect' => '/login?needconfirm',
                ]);
            }
            $token = auth()->user()->api_token;
            
            
            return response()->json(['token' => $token,'user_id'=>auth()->user()->id,'role_id'=>auth()->user()->role_id ,'status'=>200], 200);
        } else {
            return response()->json(['error' => 'Неправильный логин и/или пароль'], 401);
        }
    }
}
