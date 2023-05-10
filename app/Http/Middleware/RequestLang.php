<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class RequestLang
{
    public function handle($request, \Closure $next)
    {
        if ($request->has('_lang')) {
            App::setLocale($request->_lang);
        } else if (Auth::id()) {
            App::setLocale(Auth::user()->lang ?? 'ru');
        }

        return $next($request);
    }

}
