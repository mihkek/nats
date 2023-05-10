<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdererStatus extends Model implements \JsonSerializable
{
    protected $table = 'orderer_statuses';
    public $timestamps = false;
    protected $guarded = array('id');

    public function jsonSerialize() {
        return $this->only(['id', 'name', 'code', 'color_calendar']);
    }
}
