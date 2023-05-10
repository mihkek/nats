<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class RequesterCustomerTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'requester_customers_translation';
    }