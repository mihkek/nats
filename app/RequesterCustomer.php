<?php

namespace App;

use App\Models\Traits\UsersOrgRestrictedTrait;
use App\Models\Scopes\UsersOrgRestrictedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Mirronix\LogGlobal\Traits\LogGlobalTrait;
use App\Models\Traits\Retranslatable;

class RequesterCustomer extends Model
{
    use LogGlobalTrait, Retranslatable;
    public $translatedAttributes = ['first_name', 'last_name', 'middle_name', 'child_first_name', 'child_last_name', 'child_hobbies', 'main_city', 'main_address', 'main_metro'];

}
