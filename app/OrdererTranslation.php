<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class OrdererTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'orderers_translation';
    }