<?php

namespace App;

use App\Models\CachedModel;
use App\Models\OrdererZoomConference;
use App\Models\Traits\UsersOrgRestrictedTrait;
use Illuminate\Database\Eloquent\Model;
use Mirronix\FieldAccess\Models\AccessManager;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use App\Models\Traits\Retranslatable;
use App\Orderer;
use App\Models\User;
use DB;

class Orderer extends CachedModel implements \JsonSerializable
{
    use LogGlobalTrait, UsersOrgRestrictedTrait, Retranslatable;
    public $translatedAttributes = ['action_reason', 'action_comment', 'customer_review'];

    public function group()
    {
        return $this->belongsTo('App\CustomerGroup', 'customer_group_id')->with('customers');
    }

    public function discipline()
    {
        return $this->belongsTo('App\Discipline', 'discipline_id');
    }

    public function additional_place()
    {
        return $this->belongsTo('App\OrdererAdditionalPlace', 'orderer_additional_place_id');
    }

    public function directory_firm()
    {
        return $this->belongsTo('App\DirectoryFirm', 'directory_firm_id')->with('user');
    }

    public function directory_person()
    {
        return $this->belongsTo('App\DirectoryPerson', 'directory_person_id')->with('user');
    }

    public function conferences() {
        return $this->hasMany(OrdererZoomConference::class, 'orderer_id');
    }

    public function next_orderer()
    {
        return $this->belongsTo('App\Orderer', 'next_orderer_id', 'id');
    }

    public function order_status() {
        return $this->belongsTo(OrdererStatus::class, 'status');
    }

    public function getPricingDataAttributeCached() {
/*        $pricingData = (object) [
            'directory_firm' => 0,
            'directory_person' => 0,
            'price' => 0,
            'tariff' => null,
            'subscriptions' => null,
        ];

        $tariffs = config('tariffs');
        $tariffKey = $this->additional_place->tariff ?? 'STANDARD';

        if (!isset($tariffs[$tariffKey])) {
            return $pricingData;
        }

        $tariff = (object) $tariffs[$tariffKey];

        // ПРОВЕРКА НА НАЛИЧИЕ АБОНЕМЕНТА
        $subscriptions = CustomerSubscription::where('customer_id', $this->customer->id)
                                            ->where('is_active', 1)
                                            ->get();



        if ($subscriptions->count() < 1) {
            $subscriptions = CustomerSubscription::where('user_id', $this->customer->user_id)
                                                ->where('is_multiple', 1)
                                                ->where('is_active', 1)
                                                ->get();
        }
        $subscriptions_arr = array();
                                                    
        $i = 0;
        foreach ($subscriptions as $subscription)
        {
            $flag = false;

            if ($tariffKey == 'SKYPE') {
                if ($subscription->type == 'skype')
                {
                    $flag = true;
                }
            }

            if ($tariffKey == 'STANDARD') {
                if ($subscription->type == 'standart')
                {
                    $flag = true;
                }
                else if ($subscription->type == 'home' && $subscription->number_of_paid_orderers < 16)
                {
                    $flag = true;
                }
            }

            if ($tariffKey == 'HOME') {
                if ($subscription->type == 'standart')
                {
                    $flag = true;
                }
                else if ($subscription->type == 'home')
                {
                    $flag = true;
                }
            }
            if ($flag == true ) {
                if ($i == 0) {
                    $subscription->is_on = 1;
                    $i++;
                }
                else {
                    $subscription->is_on = 0;
                }
                array_push($subscriptions_arr, $subscription);
            }
        }
        $pricingData->subscriptions = $subscriptions_arr;
        // ЦЕНА ЗА 1 ЗАНЯТИЕ 
        $pricingData->price = $tariff->price[$this->directory_person->specialist_level][0]['price'];
        $pricingData->tariff = $tariff;
        foreach (($tariff->payouts ?? []) as $payout) {

            // СУММА ПРЕПОДАВАТЕЛЮ
            if ($payout['to'] == 'directory_person') {

                $orderers_count = Orderer::where('customer_id', $this->customer->id)->where('directory_person_id', $this->directory_person->id)->where('status', 3)->count();
                
                $next_limit_orderers = $payout['next_limit_orderers'];

                if ($next_limit_orderers == null) {
                    $user = User::find($this->directory_person->user_id);
                    $pricingData->{ $payout['to'] } = $payout[$user->pricelist];;
                }

                else {
                    $add_count = DB::table('directory_person_customer_begin_orderers_count')
                                    ->where('directory_person_id', $this->directory_person->id)
                                    ->where('customer_id', $this->customer->id)
                                    ->first();

                    if (!empty($add_count)) {
                        $orderers_count = $orderers_count + $add_count->count;  
                    }

                    $key = 1;
                    if ($orderers_count+1 >= $next_limit_orderers) {
                        $key = $next_limit_orderers;
                    }
                    
                    if ($tariffKey == 'SKYPE') {
                        $pricingData->{ $payout['to'] } = $payout[$user->pricelist][$this->directory_person->specialist_level][$key];
                    }
                    else {
                        $pricingData->{ $payout['to'] } = $payout['price'][$this->directory_person->specialist_level][$key];
                    }
                }
            }
            // СУММА помещению
            else {

                $directory_firm = $this->directory_firm;

                if ($directory_firm['price'] != null) {
                    $pricingData->{ $payout['to'] } = $directory_firm['price'];
                }
                else {
                    $pricingData->{ $payout['to'] } = $payout['price'];
                }

            }
            
        }
        return $pricingData;*/
    }

    /*public function getDirectoryPersonAmountAttribute() {
        return $this->pricing_data->directory_person;
    }

    public function getDirectoryFirmAmountAttribute() {
        return $this->pricing_data->directory_firm;
    }

    public function getPriceAttribute() {
        return $this->pricing_data->price;
    }

    public function getSubscriptionsAttribute() {
        return $this->pricing_data->subscriptions;
    }*/
    

   /* protected $appends = ['directory_person_amount', 'directory_firm_amount', 'price', 'subscriptions'];*/

    public static function getFields() {
        // По умолчанию тип - FIELD_TYPE_STRING
        return [
            ['code' => 'status', 'name' => 'Статус'],
            ['code' => 'date', 'name' => 'Дата'],
            ['code' => 'time', 'name' => 'Время'],
            ['code' => 'date_time', 'name' => 'Дата и время'],
            ['code' => 'comment', 'name' => 'Комментарий'],
            ['code' => 'customer_review', 'name' => 'Отзыв клиента'],
            ['code' => 'customer_review_rate', 'name' => 'Оценка клиента'],
            ['code' => 'customer_id', 'name' => 'Клиент'],
            ['code' => 'directory_firm_id', 'name' => 'Помещение'],
            ['code' => 'directory_person_id', 'name' => 'Преподаватель'],
            ['code' => 'orderer_additional_place_id', 'name' => 'Помещение проведения'],
        ];
    }

    public function jsonSerializes() {
        $today = date('Y-m-d H:i:s');
        $orderer_date = $this->date_time;
        $is_complete = false;
        if ($today >= $orderer_date) {
            $is_complete = true;
        }
        return array_merge($this->only([
            'id',
            'action_comment',
            'action_reason',
            'additional_place',
            'price',
            'group',
            'directory_person_amount',
            'subscription',
            'date',
            'time',
            'status',
            'date_time',
            'customer_review',
            'customer_review_rate',
            'date_time',
            'end_date_time',
            'time_to',
            'is_complete' => $is_complete,
            'customer_subscription_id',
            'discipline',
            'discipline_id',
        ]), [
            'customer' => $this->directory_person,
            'zoom' => $this->conferences,
        ]);
    }
}
