<?php

    use Illuminate\Support\Facades\Route;

    Route::group(['namespace' => 'Mirronix\TranslationManager\Http\Controllers', 'middleware' => ['api'], 'prefix' => 'api/translation-manager'], function(){
        Route::get('translation', 'Controller@getTranslation');
        Route::post('translation', 'Controller@postTranslation');
    });
