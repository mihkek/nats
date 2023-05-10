<?php

namespace App;

use App\Models\Traits\Retranslatable;
use App\Models\Traits\UsersOrgRestrictedTrait;
use Mirronix\FieldAccess\Models\AccessManager;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use Illuminate\Database\Eloquent\Model;

use App\DirectoryFirmBusy;

class DirectoryFirm extends Model implements \JsonSerializable
{
    use LogGlobalTrait, UsersOrgRestrictedTrait, Retranslatable;
    public $translatedAttributes = ['full_name', 'main_city', 'main_address', 'main_metro', 'main_requisites'];

    protected $table = 'directory_firms';

    public function orderers()
    {
        return $this->hasMany('App\Orderer', 'directory_firm_id')->with('customer', 'additional_place', 'directory_firm', 'directory_person', 'order_status');
    }

    public function busy()
    {
        return $this->hasMany('App\DirectoryFirmBusy', 'directory_firm_id');
    }

    public function people()
    {
        return $this->hasMany('App\DirectoryFirmPerson', 'directory_firm_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function subdivision()
    {
        return $this->belongsTo('App\Subdivision', 'subdivision_id');
    }

    public function is_busy($datetime_from, $datetime_to)
    {
        $is_busy = false;

        // Смотрим по датам в таблице занятости
        $busies = DirectoryFirmBusy::where('directory_firm_id', $this->id)
                                    ->whereBetween('start_datetime', [$datetime_from, $datetime_to])
                                    ->get();


        if ($busies->count() > 0) { $is_busy = true; }
        else {

            $busies = DirectoryFirmBusy::where('directory_firm_id', $this->id)
                                        ->whereBetween('end_datetime', [$datetime_from, $datetime_to])
                                        ->get();

            if ($busies->count() > 0) { $is_busy = true; }
            else {
                $busies = DirectoryFirmBusy::where('directory_firm_id', $this->id)
                                            ->where('start_datetime', '<=', $datetime_from)
                                            ->where('end_datetime', '>=', $datetime_to)
                                            ->get();

                if ($busies->count() > 0) { $is_busy = true; }
            }
        }

        // Смотрим по дням недели в таблице занятости
        $week = date('N', strtotime($datetime_from));
        $date = date('Y-m-d', strtotime($datetime_from));
        $busies_days = DirectoryFirmBusy::where('directory_firm_id', $this->id)->where('type', 'once_week')->where('week_day', $week)->get();
        foreach ($busies_days as $busies_day)
        {
            $busies_day->start_datetime = $date.' '.$busies_day->time_from.':00';
            $busies_day->end_datetime = $date.' '.$busies_day->time_to.':00';

            if ($busies_day->end_datetime >= $datetime_from && $busies_day->end_datetime <= $datetime_to) {
                $is_busy = true;
            }
            else if ($busies_day->start_datetime >= $datetime_from && $busies_day->start_datetime <= $datetime_to) {
                $is_busy = true;
            }
            else if ($busies_day->start_datetime <= $datetime_from && $busies_day->end_datetime >= $datetime_to) {
                $is_busy = true;
            }
        }

        // Смотрим по запланированным занятиям
        $orderers = Orderer::where('directory_firm_id', $this->id)
                            ->whereBetween('date_time', [$datetime_from, $datetime_to])
                            ->where('status', '!=', 4)
                            ->get();

        if ($orderers->count() > 0) { $is_busy = true; }
        else {
            $orderers = Orderer::where('directory_firm_id', $this->id)
                            ->whereBetween('end_date_time', [$datetime_from, $datetime_to])
                            ->where('status', '!=', 4)
                            ->get();

            if ($orderers->count() > 0) { $is_busy = true; }
            else {
                $orderers = Orderer::where('directory_firm_id', $this->id)
                                    ->where('date_time', '<=', $datetime_from)
                                    ->where('end_date_time', '>=', $datetime_to)
                                    ->where('status', '!=', 4)
                                    ->get();

                if ($orderers->count() > 0) { $is_busy = true; }
            }            
        }                           

        return $is_busy;
    }


    public static function getFields() {
        // По умолчанию тип - FIELD_TYPE_STRING
        return [
            ['code' => 'full_name', 'name' => 'Название'],
            ['code' => 'main_city', 'name' => 'Город'],
            ['code' => 'main_metro', 'name' => 'Метро'],
            ['code' => 'main_address', 'name' => 'Адрес'],
            ['code' => 'phone', 'name' => 'Телефон'],
            ['code' => 'email', 'name' => 'E-mail'],
            ['code' => 'main_requisites', 'name' => 'Реквизиты'],
            ['code' => 'photo', 'name' => 'Фото', 'type' => AccessManager::FIELD_TYPE_AVATAR],
        ];
    }

    public function jsonSerialize() {

        return [
            'id' => $this->id,
            'type' => $this->type,
            'full_name' => $this->full_name,
            'avatar' => $this->avatar,
            'profile_photo' => $this->avatar,
            'main_city' => $this->main_city,
            'main_address' => $this->main_address,
            'main_metro' => $this->main_metro,
            'price' => $this->price,
            'main_requisites' => $this->main_requisites,
            'main_phone' => $this->main_phone,
            'main_email' => $this->main_email,
            'user' => $this->user,
            'people' => $this->people,
            'created_at' => $this->created_at->format('d.m.Y, H:i'),
            'updated_at' => $this->updated_at->format('d.m.Y, H:i'),
            'deleted' => $this->deleted,
            'city_id' => $this->city_id,
            'city' => $this->city,
            'subdivision' => $this->subdivision,
            'subdivision_id' => $this->subdivision_id,
        ];
    }
}
