<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class RequesterTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'requesters_translation';
    }