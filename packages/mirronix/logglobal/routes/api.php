<?php

    use Illuminate\Support\Facades\Route;

    Route::group(['namespace' => 'Mirronix\LogGlobal\Http\Controllers', 'middleware' => ['api'], 'prefix' => 'api'], function(){
        Route::get('log-global/changes', 'Controller@getChanges');
        Route::get('log-global/{model}/changes', 'Controller@getChanges');
        Route::get('log-global/{model}/{id}/changes', 'Controller@getChanges');
    });
