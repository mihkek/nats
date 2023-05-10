<?php

    namespace App\Models\Traits;

    use App\Models\OrgToUser;
    use App\Models\Scopes\UsersOrgRestrictedScope;
    use Illuminate\Support\Facades\Auth;

    trait UsersOrgRestrictedTrait {
        public static $withScopeRestrictions = true;
        public static function boot()
        {
            parent::boot();
            if (self::$withScopeRestrictions) {
                static::addGlobalScope(new UsersOrgRestrictedScope());
            }
            self::creating(function($model) {
                foreach (OrgToUser::where('user_id', Auth::id())->get() as $q) {
                    $model->org_id = $q->org_id;
                    break;
                }
            });
        }
    }
