<?php

	namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class UserTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'users_translation';
    }