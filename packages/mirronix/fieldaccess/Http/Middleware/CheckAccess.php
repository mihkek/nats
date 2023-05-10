<?php

namespace Mirronix\FieldAccess\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mirronix\FieldAccess\Models\AccessManager;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = Auth::guard($guard)->user();
        if ($user) {
            $route = Route::currentRouteName();
            if ($route) {
                $fieldAccessManager = new AccessManager($user);
                if ($fieldAccessManager->canAccess('access', $route) == 'disabled') {
                    return response(view('admin.no_access'));
                    // return redirect('/admin');
                }
            }
        }

        return $next($request);
    }
}
