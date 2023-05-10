<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class PromoterTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'promoters_translation';
    }