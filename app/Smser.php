<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smser extends Model
{
    // Отправитель
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }
}
