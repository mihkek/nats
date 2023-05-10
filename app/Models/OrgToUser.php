<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class OrgToUser extends Model {
        protected $table = 'users_org_to_user';
        public $timestamps = false;
        protected $guarded = [];
    }