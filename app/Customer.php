<?php

namespace App;

use App\Models\Traits\UsersOrgRestrictedTrait;
use App\Models\Scopes\UsersOrgRestrictedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use App\Models\Traits\Retranslatable;

class Customer extends Model implements \JsonSerializable
{
    use LogGlobalTrait, UsersOrgRestrictedTrait, Retranslatable;
    public $translatedAttributes = ['full_name', 'child_full_name', 'main_address', 'main_city', 'main_metro'];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function people()
    {
        return $this->hasMany('App\CustomerPerson', 'customer_id');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\CustomerSubscription', 'customer_id');
    }

    public function type()
    {
    	return $this->belongsTo('App\CustomerType', 'type_id');
    }

    public function directory_firm()
    {
    	return $this->belongsTo('App\DirectoryFirm', 'directory_firm_id');
    }

    public function group()
    {
        return $this->belongsTo('App\CustomerGroup', 'group_id')->with('orderers');
    }

    public function subdivision()
    {
        return $this->belongsTo('App\Subdivision', 'subdivision_id');
    }

    public function directory_person()
    {
    	return $this->belongsTo('App\DirectoryPerson', 'directory_person_id');
    }

    public function pays()
    {
        return $this->hasMany('App\CustomerPay', 'customer_id')->orderBy('date');
    }

    public function jsonSerialize() {

        return [
            'id' => $this->id,
            'contract_number' => $this->contract_number,
            'contract_date' => $this->contract_date,
            'nationality' => $this->nationality,
            'passport_number' => $this->passport_number,
            'passport_issued' => $this->passport_issued,
            'reg_address' => $this->reg_address,
            'fact_address' => $this->fact_address,
            'type' => $this->type,
            'type_id' => $this->type_id,
            'full_name' => $this->full_name,
            'child_full_name' => $this->child_full_name,
            'group_id' => $this->group_id,
            'group' => $this->group,
            'age' => $this->age,
            'gender' => $this->gender,
            'profile_photo' => $this->avatar,
            'avatar' => $this->avatar,
            'main_city' => $this->main_city,
            'main_address' => $this->main_address,
            'main_metro' => $this->main_metro,
            'main_phone' => $this->main_phone,
            'main_email' => $this->main_email,
            'user' => $this->user,
            'directory_firm' => $this->directory_firm,
            'directory_firm_id' => $this->directory_firm_id,
            'directory_person' => $this->directory_person,
            'directory_person_id' => $this->directory_person_id,
            'people' => $this->people,
            'subscriptions' => $this->subscriptions,
            'pays' => $this->pays,
            'comment' => $this->comment,
            'status' => $this->status,
            'status_option' => $this->status_option,
            'created_at' => $this->created_at->format('d.m.Y, H:i'),
            'updated_at' => $this->updated_at->format('d.m.Y, H:i'),
            'deleted' => $this->deleted,
            'successful' => $this->successful,
            'subdivision_id' => $this->subdivision_id,
            'subdivision' => $this->subdivision,
        ];
    }

    /*public function jsonSerialize() {
        return array_merge(
            $this->only(['id', 'photo', 'type', 'type_id', 'manager', 'manager_id',
                'directory_firm', 'directory_firm_id', 'directory_person', 'directory_person_id',
                'metro', 'address', 'city', 'age', 'phone', 'email', 'gender',
            ]), ['name' => $this->full_name]
        );
    }*/
}
