<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use DB;
use File;
use Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as ImageInt;
use Illuminate\Support\Facades\Hash;

class PersonalSettingController extends Controller
{
    public function get(Request $request)
    {
    	$user = User::find($request->id);
		$user->lang = 'ru';
       	return response([ 'status' => 1, 'user' => $user ], 200); 
    }

    public function edit(Request $request)
    {
    	$user = User::find($request->id);
    	$user->first_name = $request->first_name;
    	$user->last_name = $request->last_name;
    	$user->middle_name = $request->middle_name;
    	$user->phone = $request->phone;
    	$user->email = $request->email;
    	$user->lang = 'ru';

        $user->company_name = $request->company_name;
        $user->company_inn = $request->company_inn;
        $user->company_ogrn = $request->company_ogrn;
        $user->company_bank_account = $request->company_bank_account;
        $user->company_correspondent_account = $request->company_correspondent_account;
        $user->company_warehouse_address = $request->company_warehouse_address;
        $user->company_bank_bik = $request->company_bank_bik;
        $user->company_description = $request->company_description;
        $user->notification_off = $request->notification_off;
        if (!empty($request->ga)) {
            $user->ga = $request->ga;
        }

    	$user->save();

    	$text = 'Личные данные успешно изменены';

       	return response([ 'status' => 1, 'text' => $text ], 200); 
    }

    public function edit_img(Request $request)
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

    public function change_pass(Request $request)
    {
    	$user = User::find($request->id);
    	$user->password = bcrypt($request->password);
    	$user->save();

    	$text = 'Пароль успешно изменен';

       	return response([ 'status' => 1, 'text' => $text ], 200); 
    }

    public function get_langs(Request $request)
    {
        return response()->json(['langs' => config('translatable.languages')]);
    }

    public function change_lang(Request $request)
    {
        $user = User::find($request->user_id);
//        $user->lang = $request->code;
        $user->lang = 'ru';
        $user->save();

        return response([ 'status' => 1 ], 200); 
    }





    // Mobile Api Данные пользователя (Поставщик/Покупатель)
    public function apiMobileGet(Request $request)
    {
     $user = User::find(Auth::user()->id);
      $file =  User::ApigetAvatar($user->id,'small');   
      $path = storage_path().'/app/public/avatars/'.$file;
         if ($user->avatar) {
            if (file_exists($path)){
                $adasd=[
		    '600x600'=>url("storage/avatars/600x600.". $user->avatar),
                    '150x150'=>url("storage/avatars/150x150.". $user->avatar),
                    '50x50'=>url("storage/avatars/50x50.". $user->avatar),
                    '48x48'=>url("storage/avatars/48x48.". $user->avatar),                ];
            }else{
                $adasd = [null];
            }
        } else {
             $adasd = [null];
        }

        $user->avatar = $adasd;
        $user->lang = 'ru';
        return response([ 'status' => 1, 'user' => $user ], 200);
    }


    function isValidEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL) == false;
    }
    // Mobile Api Изменение данных пользователей(Поставщик/Покупатель)
    public function apiMobileEdit(Request $request)
    {

        if ($this->isValidEmail($request->email)){
            return response([ 'status' => 401, 'text' => "Неправильная электронная почта!" ], 200);
        }
        if ($request->email == ""  || $request->phone == ""){
            return response([ 'status' => 401, 'text' => "Электронная почта и телефон обязательны" ], 200);
        }

        $user = User::find(Auth::user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->middle_name = $request->middle_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->lang = 'ru';

        $user->company_name = $request->company_name;
        $user->company_inn = $request->company_inn;
        $user->company_ogrn = $request->company_ogrn;
        $user->company_bank_account = $request->company_bank_account;
        $user->company_correspondent_account = $request->company_correspondent_account;
        $user->company_warehouse_address = $request->company_warehouse_address;
        $user->company_bank_bik = $request->company_bank_bik;
        $user->company_description = $request->company_description;

        $user->save();

        $text = 'Личные данные успешно изменены';

        return response([ 'status' => 1, 'text' => $text ], 200);
    }




    // Mobile Api Изменение аватар пользователя(Поставщик/Покупатель)    
    public function apiMobileEditImg(Request $request)
    {
        if (!$request->hasFile('file') || $request->file == ""){
            return response([ 'status' => 404, 'text' => 'Аватар не выбран' ], 200);
        }
        $user = User::find(Auth::user()->id);
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



    //удалить аккаунт 181122
    public function apiMobileDeleteAccount(Request $request)
    {
        $user = User::find($request->id);
        if (!empty($user)) {
            $user->deleted = 'on';
            $user->firebase_token = NULL;
            $user->save();
            $text = 'Аккаунт удален';
            return response([ 'status' => 1, 'text' => $text ], 200);
        }
    }


    //удалить аккаунт 181122
    public function delete_account(Request $request)
    {
        $user = User::find($request->id);
        if (!empty($user)) {            
            //$user->confirm = NULL;
            //$user->password = NULL;
            //$user->api_token = NULL;
            $user->deleted = 'on';
            $user->firebase_token = NULL;
            $user->save();
            $text = 'Аккаунт удален';
            return response([ 'status' => 1, 'text' => $text ], 200);
        }
    }


}
