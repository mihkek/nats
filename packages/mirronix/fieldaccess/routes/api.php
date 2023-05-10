<?php

    use Illuminate\Support\Facades\Route;

    Route::group(['namespace' => 'Mirronix\FieldAccess\Http\Controllers', 'middleware' => ['api'], 'prefix' => 'api/field-access'], function(){
        Route::get('roles', 'Controller@getRoles');
        Route::get('{model}/fields', 'Controller@getModelFields');
        Route::get('access-data', 'Controller@getAccessData');
        Route::get('test', 'Controller@getTest');
        Route::post('{model}/fields', 'Controller@postModelFields');
    });
