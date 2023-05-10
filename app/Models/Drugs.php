<?php

namespace App\Models;

class Drugs extends CachedModel {
        protected $table = 'auction_drug_list';
		public $timestamps = false;
        protected $guarded = array('id');



        public function SetDefaultFields($drug) {
            parent::SetDefaultFields($drug);
            $this->sort = time();
        }

}