<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class CustomerPersonTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'customer_people_translation';
    }