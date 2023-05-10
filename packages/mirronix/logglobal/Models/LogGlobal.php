<?php

    namespace Mirronix\LogGlobal\Models;

    use App\Models\User;
    use Illuminate\Database\Eloquent\Model;

    class LogGlobal extends Model implements \JsonSerializable {
        protected $table = 'log_global';
        public $timestamps = false;
        protected $guarded = ['id'];

        public function user() {
            return $this->belongsTo(User::class);
        }

        public function jsonSerialize() {
            return array_merge($this->only(['created', 'model_id', 'field', 'old_value', 'new_value']),
                ['user' => $this->user->only('id', 'name', 'avatar', 'email')]
            );
        }
    }