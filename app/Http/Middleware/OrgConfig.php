<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class OrgConfig
{
    public function handle($request, \Closure $next)
    {
        if (Auth::id()) {
            $orgId = Auth::user()->org_id;
            if ($orgId) {
                foreach (['tariffs'] as $configKey) {
                    $possibleKey = "org.$orgId.$configKey";
                    if (config()->has($possibleKey)) {
                        config([$configKey => config($possibleKey)]);
                    }
                }
            }
        }

        return $next($request);
    }
}
