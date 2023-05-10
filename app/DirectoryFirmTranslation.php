<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class DirectoryFirmTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'directory_firms_translation';
    }