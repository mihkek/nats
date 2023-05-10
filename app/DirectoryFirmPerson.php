<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Retranslatable;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use Mirronix\FieldAccess\Models\AccessManager;

class DirectoryFirmPerson extends Model
{
    use LogGlobalTrait, Retranslatable;
    public $translatedAttributes = ['full_name', 'position'];

    
}
