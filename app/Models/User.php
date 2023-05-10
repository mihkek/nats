<?php

namespace App\Models;

use App\Models\CachedModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use App\Models\Traits\Retranslatable;

use App\Orderer;
use App\Customer;
use App\Promoter;
use App\UserCustomer;
use App\DirectoryPerson;
use App\UserDirectoryPerson;
use App\DirectoryFirm;
use App\UserDirectoryFirm;


class User extends CachedModel  implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    \JsonSerializable
{

    use Authenticatable, Authorizable, CanResetPassword, HasApiTokens, Notifiable, LogGlobalTrait, Retranslatable;

    protected $guarded = array('id');
    public $timestamps = true;
    // protected $fillable = ['name', 'email', 'password',];
    protected $hidden = ['password', 'remember_token'];
    public $translatedAttributes = ['name', 'name_patronymic', 'name_family', 'address'];




	public function getReferalCode() {
		if ($this->referal_code == '') {
            $this->referal_code = substr(md5(uniqid('code' . time())), 4, 8);
            $this->save();
		}
	    return $this->referal_code;
	}




	// получение ID  рефералаа по его номеру телефона (например введенного при регистрации)
	public static function getReferalByPhone($phone) {
		if ($phone != '') {
			$phone = preg_replace("/\+8/", "+7", $phone); // мерзкий хак - замена для дебилов которые вводят +8
			$user_ref = static::where('phone', $phone)->orderBy('created', 'desc')->first();
			if ($user_ref) {
				return $user_ref->id;
			}
		}
	return 0;  // нулевой реферрал используется по умолчанию
	}






	protected function getSubUsersLevel($ids) {
	    $query = static::whereIn('ref_id', $ids)
            ->groupBy('tariff')
            ->select('tariff', DB::raw('count(*) as total'), DB::raw('group_concat(`id`) as `ids`'));

	    $result = ['ids' => [], 'stats' => []];

	    foreach ($query->get() as $q) {
	        $result['stats'][$q->tariff] = (object) [
	            'count' => $q->total,
                'ids' => explode(',', $q->ids)
            ];
	        $ids = explode(',', $q->ids);
	        if (!empty($ids)) {
                $result['ids'] = array_merge($result['ids'], $ids);
            }
        }

	    return $result;
    }

	public function getSubUsers($maxLevels = 8) {
        $ids = [$this->id];
	    $stats = [];

	    for ($i = 0; $i < $maxLevels; ++$i) {
	        $subUsers = $this->getSubUsersLevel($ids);
            $ids = $subUsers['ids'];
            if (empty($ids)) break;
	        $stats[] = $subUsers['stats'];
        }

	    return $stats;
    }


    public function getSubUsersTarifLevel($level, $tarif) {
        $subUsers = $this->getSubUsers();
        $userIds = $subUsers[$level - 1][$tarif]->ids ?? [];

        $users = [];

        if (count($userIds)) {
            $query = static::whereIn('id', $userIds);
            foreach ($query->get() as $q) {
                $users[] = $q;
            }
        }

        return $users;
    }


    public function type()
    {
    	return $this->belongsTo('App\CustomerType', 'client_type');
    }

    public function subdivision()
    {
    	return $this->belongsTo('App\Subdivision', 'subdivision_id');
    }







/*########## получение массива родителей-реферралов "вниз" от текущего юзера ################*/
	public static function getReferalArrayLevels($userId, $toarray = false) {
		global $refAll;

		$allUsers = static::select('ref_id', 'id', 'name')->where('ref_id', '!=', '')->get()->toArray();
		if (count($allUsers) == 0) {return false;}

		$refAll = Array();
		static::getReferalCountRecurciveCheck(0, $allUsers, $userId, $toarray);

		return $refAll;
	}
/*########## получение массива родителей-реферралов "вверх" от текущего юзера ################*/
	public static function getReferalArrayLevelsUp($userId, $toarray = false) {
		global $refAll;

		$allUsers = static::select('ref_id', 'id', 'name')->where('ref_id', '!=', '')->get()->toArray();
		if (count($allUsers) == 0) {return false;}

		$refAll = Array();
		static::getReferalCountRecurciveCheckUp(7, $allUsers, $userId, $toarray);

		return $refAll;
	}
/*######## служебная реккурентная: getReferalCountRecurciveCheck ################*/
	protected static function getReferalCountRecurciveCheck($level, $allUsers, $userId, $toarray = false) {
		global $refAll;
		foreach ($allUsers as $usr) {
			if ($usr['ref_id'] == $userId) {
			    if ($toarray) {
                    $refAll[] = $usr['id'];
                } else {
                    $refAll[ $level ][ $usr['id'] ] = $usr['name'];
                }
				static::getReferalCountRecurciveCheck($level+1, $allUsers, $usr['id'], $toarray);
			}
		}
	}
/*######## служебная реккурентная: getReferalCountRecurciveCheckUp ################*/
	protected static function getReferalCountRecurciveCheckUp($level, $allUsers, $userId, $toarray = false) {
		global $refAll;
		foreach ($allUsers as $usr) {
			if ($usr['id'] == $userId) {
                if ($toarray) {
                    $refAll[] = $usr['id'];
                } else {
                    $refAll[ $level ][ $usr['ref_id'] ] = $usr['name'];
                }
				static::getReferalCountRecurciveCheckUp($level-1, $allUsers, $usr['ref_id'], $toarray);
			}
		}
	}
/*############################################################################*/





/*############## получение всех параметров заданного юзера #######################################*/
	public static function getUser($userId) {
		$user = static::where('id', $userId)->first();
		$count = 1;
		$user->count = $count;
		return $user;
	}

/*############## получение аватара заданного юзера #######################################*/
	public static function getAvatar($userId, $size='small') {
		if ($size == 'small') {		$prefix = "48x48.";}
		elseif ($size == 'medium') {	$prefix = "150x150.";}
		elseif ($size == 'large') {		$prefix = "500x500.";}
		else {						$prefix = "";}

		$myUser = static::where('id', $userId)->first();
		if ($myUser->avatar) {
			return "/storage/avatars/" . $prefix . $myUser->avatar;
		} else {
			return "/img/signs/" . $prefix . "nophoto.png";
		}

	}



	public function jsonSerialize() {

		$res = array(
			'id' => $this->id,
			'confirm' => $this->confirm,
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'middle_name' => $this->middle_name,
			'position' => $this->position,
			'phone' => $this->phone,
			'email' => $this->email,
			'company_name' => $this->company_name,
			'company_place' => $this->company_place,
			'company_inn' => $this->company_inn,
			'company_ogrn' => $this->company_ogrn,
			'company_bank_account' => $this->company_bank_account,
			'company_correspondent_account' => $this->company_correspondent_account,
			'company_bank_bik' => $this->company_bank_bik,
			'company_warehouse_address' => $this->company_warehouse_address,
			'company_web_site' => $this->company_web_site,
			'company_description' => $this->company_description,
			'company_check_file' => $this->company_check_file,
            'avatar' => $this->avatar,
            'role_id' => $this->role_id,
            'role' => $this->role,
            'city_id' => $this->city_id,
            'city' => $this->city,
            'customer' => $this->customer,
            'directory_person' => $this->directory_person,
            'directory_firm' => $this->directory_firm,
            'name_family' => $this->name_family,
            'name' => $this->name,
            'name_patronymic' => $this->name_patronymic,
            'full_name' => $this->last_name.' '.$this->first_name.' '.$this->middle_name,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'hired_date' => $this->hired_date,
            'fired_date' => $this->fired_date,
            'pricelist' => $this->pricelist,
            'created' => date('d.m.Y H:i:s', strtotime($this->created)),
            'created_at' => date('d.m.Y H:i:s', strtotime($this->created)),
            'updated_at' => date('d.m.Y H:i:s', strtotime($this->updated_at)),
            'lang' => $this->lang,
            'deleted' => $this->deleted,
            'subdivision_id' => $this->subdivision_id,
            'subdivision' => $this->subdivision,
            'notification_off' => $this->notification_off,
            'ga' => $this->ga,
		);

		if ($this->role_id == 101) {
			$customers = Customer::where('user_id', $this->id)->select('id')->get();
			$orderers_count = Orderer::get()->count();
			$res['orderers_count'] = $orderers_count;
		}

		if ($this->role_id == 1002 || $this->role_id == 1000) {
			$promoter = Promoter::where('user_id', $this->id)->first();
			if (!empty($promoter)) {
				$res['promoter_id'] = $promoter->id;
				$res['code_opc'] = $promoter->code_opc;
			}
		}

		return $res;
    }



    /*
        // вроде бы не используется
        public function hasVerifiedEmail() {
            return $this->confirm == 'on';
        }

        // вроде бы не используется
        public function markEmailAsVerified() {
            $this->confirm = 'on';
            $this->save();
            return true;
        }

        // вроде бы не используется
        public function sendEmailVerificationNotification() {
        }
    */

/*
	public static function getReferalArray($userId) {
		$query = static::where('ref_id', $userId);

                $myIncome = static::where('ref_id', $userId);


	$this->referal_code = substr(md5(uniqid('code' . time())), 4, 8);

	return $this->referal_code;
	}
*/


    public function role()
    {
        return $this->belongsTo('App\Models\ConfigerUsersRoles', 'role_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }


	/* БЛИЖАЙШЕЕ ЗАНЯТИЕ */
	public function next_orderer()
	{
		$today = date('Y-m-d H:i:s');
		$order = array ();
		if ($this->role_id == 101) {
			$customers = Customer::where('user_id', $this->id)->get();
			$array_id = array();
			if (!empty($customers)) {
				foreach ($customers as $customer) {
					array_push($array_id, $customer->id);
				}
				$orderer = Orderer::with('customer', 'directory_firm', 'directory_person')
								->where('date_time', '>', $today)
								->where('status', '!=', 4)
								->orderBy('date_time', 'asc')
								->first();
			}
		}
		else if ($this->role_id == 102) {
			$directory_people = DirectoryPerson::where('user_id', $this->id)->get();
			$array_id = array();

			if (!empty($directory_people)) {
				foreach ($directory_people as $directory_person) {
					array_push($array_id, $directory_person->id);
				}
				$orderer = Orderer::with('customer', 'directory_firm', 'directory_person')
								->where('date_time', '>', $today)
								->where('status', '!=', 4)
								->whereIn('directory_person_id', $array_id)
								->orderBy('date_time', 'asc')
								->first();
			}
		}
		else if ($this->role_id == 103) {
			$directory_firms = DirectoryFirm::where('user_id', $this->id)->get();
			$array_id = array();

			if (!empty($directory_firms)) {
				foreach ($directory_firms as $directory_firm) {
					array_push($array_id, $directory_firm->id);
				}
				$orderer = Orderer::with('customer', 'directory_firm', 'directory_person')
								->where('date_time', '>', $today)
								->where('status', '!=', 4)
								->whereIn('directory_firm_id', $array_id)
								->orderBy('date_time', 'asc')
								->first();
			}
		}

		return $orderer;
	}

	/* СЕГОДНЯШНИЕ ЗАНЯТИЯ */
	public function today_orderers()
	{
		$today = date('Y-m-d');
		$user_id = $this->id;
		$orderers = array();
		if ($this->role_id == 1000)
		{
			$orderers = Orderer::with('customer', 'directory_firm', 'directory_person', 'additional_place')
								->where('date', $today)
								->where('status', '!=', 4)
								->orderBy('date_time', 'asc')
								->get();
		}
		else if ($this->role_id == 101) {
			$customers = Customer::where('user_id', $this->id)->get();
			$array_id = array();
			if (!empty($customers)) {
				foreach ($customers as $customer) {
					array_push($array_id, $customer->id);
				}
				$orderers = Orderer::with('customer', 'directory_firm', 'directory_person', 'additional_place')
								->where('date', $today)
								->where('status', '!=', 4)
								->orderBy('date_time', 'asc')
								->get();
			}
		}
		else if ($this->role_id == 102) {
			$directory_people = DirectoryPerson::where('user_id', $this->id)->get();
			$array_id = array();
			if (!empty($directory_people)) {
				foreach ($directory_people as $directory_person) {
					array_push($array_id, $directory_person->id);
				}
				$orderers = Orderer::with('customer', 'directory_firm', 'directory_person', 'additional_place')
						 		->where('date', $today)
            					->where('status', '!=', 4)
								->whereIn('directory_person_id', $array_id)
								->orderBy('date_time', 'asc')
								->get();
			}
		}
		else if ($this->role_id == 103) {
			$directory_firms = DirectoryFirm::where('user_id', $this->id)->get();
			$array_id = array();
			if (!empty($directory_firms)) {
				foreach ($directory_firms as $directory_firm) {
					array_push($array_id, $directory_firm->id);
				}
				$orderers = Orderer::with('customer', 'directory_firm', 'directory_person', 'additional_place')
						 		->where('date', $today)
            					->where('status', '!=', 4)
								->whereIn('directory_firm_id', $array_id)
								->orderBy('date_time', 'asc')
								->get();
			}
		}

		return $orderers;
	}

	public function getOrgIdAttribute() {
        foreach (OrgToUser::where('user_id', $this->id)->get() as $q) {
            return $q->org_id;
        }
    }

    public static function isSuperUser() {
	    return Cookie::get('superuser_id') ?? null;
    }



    public static function ApigetAvatar($userId, $size='small') {
        if ($size == 'small') {		$prefix = "48x48.";}
        elseif ($size == 'medium') {	$prefix = "150x150.";}
        elseif ($size == 'large') {		$prefix = "500x500.";}
        else {	$prefix = "";}
        $myUser = static::where('id', $userId)->first();
        if ($myUser->avatar) {
            return  $prefix . $myUser->avatar;
        } else {
            return null;
        }
    }
}
