<?php

namespace App;

use App\Models\Traits\Retranslatable;
use App\Models\Traits\UsersOrgRestrictedTrait;
use Illuminate\Database\Eloquent\Model;
use Mirronix\FieldAccess\Models\AccessManager;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;

use App\DirectoryPersonBusy;

class DirectoryPerson extends Model implements \JsonSerializable
{
    use LogGlobalTrait, UsersOrgRestrictedTrait, Retranslatable;
    public $translatedAttributes = ['full_name', 'main_city', 'main_address', 'main_metro', 'work_location'];

	public function orderers()
    {
    	return $this->hasMany('App\Orderer', 'directory_person_id')->with('group', 'additional_place', 'directory_firm', 'directory_person', 'order_status');
    }

    public function busy()
    {
        return $this->hasMany('App\DirectoryPersonBusy', 'directory_person_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function subdivision()
    {
        return $this->belongsTo('App\Subdivision', 'subdivision_id');
    }

    public function getSpecialistLevelNameAttribute() {
	    return config('directory_person.specialist_level')[$this->specialist_level] ?? '';
    }

    public function is_busy($datetime_from, $datetime_to)
    {
        $is_busy = false;

        // Смотрим по датам в таблице занятости
        $busies = DirectoryPersonBusy::where('directory_person_id', $this->id)
        							->whereBetween('start_datetime', [$datetime_from, $datetime_to])
        							->get();

  		if ($busies->count() > 0) { $is_busy = true; }
  		else {
  			$busies = DirectoryPersonBusy::where('directory_person_id', $this->id)
  										->whereBetween('end_datetime', [$datetime_from, $datetime_to])
        								->get();
        								
        	if ($busies->count() > 0) { $is_busy = true; }
          else {
            $busies = DirectoryPersonBusy::where('directory_person_id', $this->id)
                                            ->where('start_datetime', '<=', $datetime_from)
                                            ->where('end_datetime', '>=', $datetime_to)
                                            ->get();

            if ($busies->count() > 0) { $is_busy = true; }
          }
  		}

        // Смотрим по дням недели в таблице занятости
  		$week = date('N', strtotime($datetime_from));
  		$date = date('Y-m-d', strtotime($datetime_from));
  		$busies_days = DirectoryPersonBusy::where('directory_person_id', $this->id)->where('type', 'once_week')->where('week_day', $week)->get();
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
  		$orderers = Orderer::where('directory_person_id', $this->id)
  							->whereBetween('date_time', [$datetime_from, $datetime_to])
  							->where('status', '!=', 4)
                			->get();
                			

  		if ($orderers->count() > 0) { $is_busy = true; }
  		else {
  			$orderers = Orderer::where('directory_person_id', $this->id)
  							->whereBetween('end_date_time', [$datetime_from, $datetime_to])
                            ->where('status', '!=', 4)
                			->get();

  			if ($orderers->count() > 0) { $is_busy = true; }
        else {
          $orderers = Orderer::where('directory_person_id', $this->id)
                              ->where('date_time', '<=', $datetime_from)
                              ->where('end_date_time', '>=', $datetime_to)
  							  ->where('status', '!=', 4)
                              ->get();
                              
              if ($orderers->count() > 0) { $is_busy = true; }
          }  
  		}							

  		return $is_busy;
    }

    public function jsonSerialize() {

        $last_orderer = Orderer::where('directory_person_id', $this->id)->orderBy('date_time', 'DESC')->first();
        if (!empty($last_orderer)) { $last_orderer->format_date_time = date('d.m.Y H:i', strtotime($last_orderer->date_time)); }

        return [
            'id' => $this->id,
            'subdivision_id' => $this->subdivision_id,
            'subdivision' => $this->subdivision,
            'full_name' => $this->full_name,
            'avatar' => $this->avatar,
            'profile_photo' => $this->avatar,
            'main_city' => $this->main_city,
            'main_metro' => $this->main_metro,
            'main_address' => $this->main_address,
            'work_location' => $this->work_location,
            'main_phone' => $this->main_phone,
            'main_email' => $this->main_email,
            'zoom_email' => $this->zoom_email,
            'specialist_level' => $this->specialist_level,
            'specialist_level_name' => $this->specialist_level_name,
            'user' => $this->user,
            'busy' => $this->busy,
            'user_id' => $this->user_id,
            'last_orderer' => $last_orderer,
            'created_at' => $this->created_at->format('H:i:s / d.m.Y'),
            'updated_at' => $this->updated_at->format('H:i:s / d.m.Y'),
            'deleted' => $this->deleted,
        ];
    }
}
