<?php

namespace App;

use App\Models\Traits\UsersOrgRestrictedTrait;
use App\Models\Scopes\UsersOrgRestrictedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use App\Models\Traits\Retranslatable;

use App\Models\User;
use App\Customer;
use App\RequesterCustomer;
use Illuminate\Support\Str;

use DB;
use File;

use Intervention\Image\Facades\Image as ImageInt;


class Requester extends Model implements \JsonSerializable
{
    use LogGlobalTrait, UsersOrgRestrictedTrait, Retranslatable;
    public $translatedAttributes = [''];

    public function customer()
    {
        return $this->hasOne('App\RequesterCustomer', 'requester_id');
    }

    public function additional_place()
    {
        return $this->belongsTo('App\OrdererAdditionalPlace', 'additional_place_id');
    }

    public function directory_person()
    {
        return $this->belongsTo('App\DirectoryPerson', 'directory_person_id');
    }

    public function directory_firm()
    {
        return $this->belongsTo('App\DirectoryFirm', 'directory_firm_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function manager()
    {
        return $this->belongsTo('App\Models\User', 'manager_id');
    }

    public function promoter()
    {
        return $this->belongsTo('App\Promoter', 'promoter_id');
    }

    public function add_customer()
    {
        $requester_customer = RequesterCustomer::where('requester_id', $this->id)->first();

        $user = new User;
        $password = Str::random(8);
        $user->password = bcrypt($password);
        $user->role_id = 101;
        $user->name_family = $requester_customer->last_name;
        $user->name = $requester_customer->first_name;
        $user->name_patronymic = $requester_customer->middle_name;
        $user->gender = $requester_customer->gender;
        $user->phone = $requester_customer->main_phone;
        $user->confirm = 'on';
        $user->api_token = Str::random(60);
        $user->subdivision_id = $this->subdivision_id;
        $user->save();

        // ЗАГЛУШКА НА ПРИВЯЗКУ ЮЗЕРА К ОРГАНИЗАЦИИ
        DB::table('users_org_to_user')->insert([
            'org_id' => 2,
            'user_id' => $user->id
        ]);

        $customer = new Customer;
        $customer->full_name = $this->customer->last_name.' '.$this->customer->first_name.' '.$this->customer->middle_name;
        $customer->child_full_name = $this->customer->child_last_name.' '.$this->customer->child_first_name;
        $customer->age = $this->customer->age;
        $customer->main_phone = $this->customer->main_phone;
        $customer->gender = $this->customer->gender;
        $customer->user_id  = $user->id;
        $customer->subdivision_id  = $user->subdivision_id;
        $customer->save();

        $requester_customer->customer_id = $customer->id;
        $requester_customer->save();

        $this->status = 7;
        $this->save();

        /*$requester_customer = RequesterCustomer::where('requester_id', $this->id)->first();
        
        $user = new User;
        $password = Str::random(8);
        $user->password = bcrypt($password);
        $user->role_id = 101;
        $full_name = explode(' ', $requester_customer->full_name);
        $user->name_family = $full_name[0];
        if (!empty($full_name[1])) {
            $user->name = $full_name[1];
        }
        if (!empty($full_name[2])) {
            $user->name_patronymic = $full_name[2];
        }
        $user->gender = $requester_customer->gender;
        $user->address = $requester_customer->main_address;
        $user->email = $requester_customer->main_email;
        $user->phone = $requester_customer->main_phone;
        $user->confirm = 'on';
        $user->api_token = Str::random(60);
        $user->save();

        // ЗАГЛУШКА НА ПРИВЯЗКУ ЮЗЕРА К ОРГАНИЗАЦИИ
        DB::table('users_org_to_user')->insert([
            'org_id' => 2,
            'user_id' => $user->id
        ]);

        $customer = new Customer;
        $customer->full_name = $requester_customer->full_name;
        $customer->age = $requester_customer->age;
        $customer->gender = $requester_customer->gender;
        $customer->main_address = $requester_customer->main_address;
        $customer->main_city = $requester_customer->main_city;
        $customer->main_metro = $requester_customer->main_metro;
        $customer->main_email  = $requester_customer->main_email;
        $customer->main_phone  = $requester_customer->main_phone;
        $customer->directory_person_id  = $this->directory_person_id;
        $customer->directory_firm_id  = $this->directory_firm_id;
        $customer->user_id  = $user->id;
        $customer->save();

        $requester_customer->is_customer = '1';
        $requester_customer->save();*/
    }

    public static function getFields() {
        // По умолчанию тип - FIELD_TYPE_STRING
        return [
            ['code' => 'status', 'name' => 'Статус'],
            ['code' => 'directory_firm_id', 'name' => 'ID Помещения'],
            ['code' => 'directory_person_id', 'name' => 'ID Преподавателя'],
            ['code' => 'main_comment', 'name' => 'Комментарий'],
            ['code' => 'projected_amount', 'name' => 'Прогнозируемая сумма'],
            ['code' => 'next_call_date', 'name' => 'Дата следующего контакта'],
            ['code' => 'test_one', 'name' => 'Ответы на первый тест'],
            ['code' => 'test_two', 'name' => 'Ответы на второй тест'],
            ['code' => 'test_three', 'name' => 'Ответы на третий тест'],
            ['code' => 'user_id', 'name' => 'Ответственный'],
            ['code' => 'deal_date_time', 'name' => 'Дата назначенного дела'],
        ];
    }

    public function jsonSerialize() {

        return [
            'id' => $this->id,
            'status' => $this->status,
            'is_false' => $this->is_false,
            'claim' => $this->claim,
            'first_test' => $this->first_test,
            'second_test' => $this->second_test,
            'third_test' => $this->third_test,
            'projected_amount' => $this->projected_amount,
            'main_comment' => $this->main_comment,
            'directory_person_id' => $this->directory_person_id,
            'directory_person' => $this->directory_person,
            'directory_firm_id' => $this->directory_firm_id,
            'directory_firm' => $this->directory_firm,
            'additional_place_id' => $this->additional_place_id,
            'additional_place' => $this->additional_place,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'promoter_id' => $this->promoter_id,
            'promoter' => $this->promoter,
            'created_at' => $this->created_at->format('d.m.Y, H:i'),
            'created' => $this->created_at,
            'updated_at' => $this->updated_at->format('d.m.Y, H:i'),
            'customer' => $this->customer,
            'deal_date_time' => $this->deal_date_time,
            'deal_date' => $this->deal_date,
            'deal_time' => $this->deal_time,
            'is_deal' => $this->is_deal,
            'customer_photo_one' => $this->customer->photo_one,
            'customer_photo_two' => $this->customer->photo_two,
            'customer_photo_three' => $this->customer->photo_three,
            'customer_first_name' => $this->customer->first_name,
            'customer_middle_name' => $this->customer->middle_name,
            'customer_last_name' => $this->customer->last_name,
            'customer_full_name' => $this->customer->last_name.' '.$this->customer->first_name.' '.$this->customer->middle_name,
            'customer_child_first_name' => $this->customer->child_first_name,
            'customer_child_last_name' => $this->customer->child_last_name,
            'customer_child_full_name' => $this->customer->child_last_name.' '.$this->customer->child_first_name,
            'customer_child_hobbies' => $this->customer->child_hobbies,
            'customer_main_phone' => $this->customer->main_phone,
            'customer_main_phone_formated' => preg_replace('/[^0-9]/', '', $this->customer->main_phone),
            'customer_main_email' => $this->customer->main_email,
            'customer_age' => $this->customer->age,
            'customer_gender' => $this->customer->gender,
            'customer_main_city' => $this->customer->main_city,
            'customer_main_address' => $this->customer->main_address,
            'customer_main_metro' => $this->customer->main_metro,
            'manager_id' => $this->manager_id,
            'manager' => $this->manager,
            'confirmed' => $this->confirmed,
        ];
    }
}
