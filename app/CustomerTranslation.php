<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class CustomerTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'customer_translation';
    }