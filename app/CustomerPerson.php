<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use Mirronix\FieldAccess\Models\AccessManager;
use App\Models\Traits\Retranslatable;

class CustomerPerson extends Model implements \JsonSerializable
{
    use LogGlobalTrait, Retranslatable;
    public $translatedAttributes = ['full_name', 'position'];
}
