<?php

namespace App;

use App\Models\Traits\Retranslatable;
use App\Models\Traits\UsersOrgRestrictedTrait;
use Illuminate\Database\Eloquent\Model;
use Mirronix\FieldAccess\Models\AccessManager;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use Illuminate\Support\Str;

use App\Models\User;
use DB;

class Promoter extends Model implements \JsonSerializable
{
    use LogGlobalTrait, UsersOrgRestrictedTrait, Retranslatable;
    public $translatedAttributes = ['full_name'];

    public function requests()
    {
    	return $this->hasMany('App\Requester', 'promoter_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function subdivision()
    {
        return $this->belongsTo('App\Subdivision', 'subdivision_id');
    }

    public function create_user()
    {
        $user = new User;
        $password = Str::random(6);
        $user->password = bcrypt($password);
        $user->role_id = 1002;
        $user->subdivision_id = $this->subdivision_id;

        $names = explode(" ", $this->full_name);
        if (count($names) > 0) {
            $user->name_family = $names[0];
        }
        if (count($names) > 1) {
            $user->name = $names[1];
        }
        if (count($names) > 2) {
            $user->name_patronymic = $names[2];
        }
        $user->email = '';
        $user->phone = $this->main_phone;
        $user->confirm = 'on';
        $user->api_token = Str::random(60);
        $user->save();

        $this->user_id = $user->id;
        $this->save();

        // ЗАГЛУШКА НА ПРИВЯЗКУ ЮЗЕРА К ОРГАНИЗАЦИИ
        DB::table('users_org_to_user')->insert([
            'org_id' => 2,
            'user_id' => $user->id
        ]);
    }

    public function jsonSerialize() {	 
        return [
    		'id' => $this->id,
            'code_opc' => $this->code_opc,
            'subdivision_id' => $this->subdivision_id,
            'subdivision' => $this->subdivision,
    		'scripts_rate' => $this->scripts_rate,
    		'full_name' => $this->full_name,
    		'avatar' => $this->avatar,
    		'user_id' => $this->user_id,
    		'user' => $this->user,
    		'main_phone' => $this->main_phone,
            'vk_link' => $this->vk_link,
    		'comment' => $this->comment,
            'birthday' => $this->birthday,
            'hired_date' => $this->hired_date,
    		'fired_date' => $this->fired_date,
    		'created_at' => $this->created_at->format('H:i:s / d.m.Y'),
    		'updated_at' => $this->updated_at->format('H:i:s / d.m.Y'),
    		'deleted' => $this->deleted,
    	];
    }
}
