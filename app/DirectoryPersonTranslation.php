<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class DirectoryPersonTranslation extends Model {
        public $timestamps = false;
        protected $guarded = ['id'];
        protected $table = 'directory_people_translation';
    }