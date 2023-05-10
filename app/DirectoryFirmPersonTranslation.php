<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class DirectoryFirmPersonTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'directory_firm_people_translation';
    }