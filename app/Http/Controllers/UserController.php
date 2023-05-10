<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use File;
use Storage;


use App\Models\Billing;
use App\Customer;
use App\DirectoryPerson;
use App\DirectoryFirm;
use App\Models\User;
use PHPMailer\PHPMailer;
use Intervention\Image\Facades\Image as ImageInt;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function get(Request $request)
    {
        if (!empty($request->id)) {
            $user = User::find($request->id);

            if ($user->role_id == 101) {
                $customer = Customer::where('user_id', $user->id)->first();
                $user->customer = $customer;
            }
            if ($user->role_id == 102) {
                $directory_person = DirectoryPerson::where('user_id', $user->id)->first();
                $user->directory_person = $directory_person;
            }
            if ($user->role_id == 103) {
                $directory_firm = DirectoryFirm::where('user_id', $user->id)->first();
                $user->directory_firm = $directory_firm;
            }
            return response([ 'status' => '1', 'user' => $user ], 200);
        }
    }

    //170522
    public function get_info(Request $request)
    {
        if (!empty($request->id)) {
            $user = User::find($request->id);
            return response([ 'status' => '1', 'user' => $user ], 200);
        }
    }

    //261022
    public function get_current(Request $request)
    {
        if (!empty(Auth::user()->id)) {
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            return response([ 'status' => '1', 'user' => $user ], 200);
        }
    }


    public function check_complete(Request $request)
    {
        $user = User::find($request->id);
        $errors = array();

        // ЕСЛИ ЭТО КЛИЕНТ
        if ($user->role_id == 101) {

            // Проверка на наличие активных клиентов
            $clients = Customer::where('user_id', $user->id)->get();
            if ($clients->count() < 1) {
                $error = 'empty_customer';
                array_push($errors, $error);
            }
        }

        // ЕСЛИ ЭТО преподаватель
        if ($user->role_id == 102) {

            // Проверка на наличие активных преподавателей
            $directory_people = DirectoryPerson::where('user_id', $user->id)->get();
            if ($directory_people->count() < 1) {
                $error = 'empty_directory_person';
                array_push($errors, $error);
            }
        }

        // ЕСЛИ ЭТО помещение
        if ($user->role_id == 103) {

            // Проверка на наличие активных помещений
            $directory_firms = DirectoryFirm::where('user_id', $user->id)->get();
            if ($directory_firms->count() < 1) {
                $error = 'empty_directory_firm';
                array_push($errors, $error);
            }
        }

        return response([ 'status' => '1', 'errors' => $errors ], 200);
    }


    public function get_account_statement(Request $request)
    {
        $billing_items = Billing::where('user_id', $request->id)->get();
        $total = 0;

        foreach ($billing_items as $item) {
            $total = $total + $item->sum;
        }

        $account_statement = array(
            'total' => $total,
        );

        return response([ 'status' => '1', 'account_statement' => $account_statement ], 200);
    }



    // Mobile Api Получение пользователя
    public function apiMobileGet(Request $request) 
    {
        $user = Auth::user();

        if ($user->role_id = 101) {
            $customer = Customer::where('user_id', $user->id)->first();
            $user->customer = $customer;
        }

        if ($user->role_id == 102) {
            $directory_person = DirectoryPerson::where('user_id', $user->id)->first();
            $user->directory_person = $directory_person;
        }

        if ($user->role_id == 103) {
            $directory_firm = DirectoryFirm::where('user_id', $user->id)->first();
            $user->directory_firm = $directory_firm;
        }

        return response(['status'=>'1', 'user' => $user], 200);
    }








}
