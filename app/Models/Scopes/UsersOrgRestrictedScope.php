<?php

    namespace App\Models\Scopes;

    use App\Models\OrgToUser;
    use Illuminate\Database\Eloquent\{Scope, Model, Builder};
    use Illuminate\Support\Facades\Auth;

    class UsersOrgRestrictedScope implements Scope
    {
        protected static $userOrgs = null;

        public function apply(Builder $builder, Model $model)
        {
            if (static::$userOrgs === null) {
                static::$userOrgs = [-1];
                foreach (OrgToUser::where('user_id', Auth::id())->get() as $q) {
                    static::$userOrgs[] = $q->org_id;
                }
            }

            $builder->whereIn('org_id', static::$userOrgs);
        }
    }