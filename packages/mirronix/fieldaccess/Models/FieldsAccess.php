<?php

    namespace Mirronix\FieldAccess\Models;

    use Illuminate\Database\Eloquent\Model;

    class FieldsAccess extends Model {
        protected $table = 'field_access_fields_access';
        public $timestamps = false;
        protected $guarded = [];
    }