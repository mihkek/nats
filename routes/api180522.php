<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use \Kordy\Ticketit\Helpers\LaravelVersion;

/*
|--------------------------------------------------------------------------
| Api Mobile Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Список тендеров (для неавторизованных)
Route::post('get_auctions', 'IndexController@apiMobileGetAuctions');

//Список регионов
Route::post('get_regions', 'AuctionController@getRegions');

//Получение цифр
Route::post('get_counters', 'IndexController@get_counters');

//Список ролей
Route::post('get/role', 'ConfigerController@apiMobileGetRoles');

//Регистрация Пароль приходить на номер или на почту
Route::post('register', 'Auth\RegisterController@register');

//Авторизация
Route::post('login', 'Auth\LoginController@apiMobileLogin');

//Сброс пароля Новый пароль приходить на почту
Route::post('reminder', 'Auth\ReminderController@apiMobileRegister')->name('website');

//Отзывы покупателей
Route::post('review/getlist', 'Controller@ReviewList');

//Подтверждение токенов
Route::get('confirm/{confirmToken}', 'Auth\RegisterController@apiMobileVerification');
Route::get('confirm', 'Auth\RegisterController@verification');

// скачивание файлов
Route::get('get_contract_file_download_file/{god}/{naz}', 'AuctionController@apiMobile_get_contract_file_download_file');
Route::get('get_auction_contract_pdf/{auctionId}', 'AuctionController@apiMobile_get_auction_contract_pdf');



Route::middleware('auth:api')->group(function () {

	/*### сервис формирования шаблонов-документов ###*/
	Route::post('templater/add', 'TemplaterController@getAdd'); // показ всех шаблонов
	Route::post('templater/add/{id}/start', 'TemplaterController@getAddStart'); // старт выбора шаблона
	Route::post('templater/add/{id}/generate', 'TemplaterController@postAddGenerate'); // финальная генерация

    Route::get('test', 'ChangeLoggerController@getTest');
    Route::get('calendar/events', 'CalendarController@getEvents');

	/*
	|--------------------------------------------------------------------------
	| Mobile Routes
	|--------------------------------------------------------------------------
	*/

	// список городов
	Route::post('get_cities', 'ConfigerController@get_cities');

	// Изменить пароль
	Route::post('edit_pass','ConfigerController@apiMobileEditUserPass');

	// Получение пользователя
	Route::post('user/get', 'UserController@apiMobileGet');

	Route::post('/block-user/', 'AdminController@blockUser');

	//Язык/Страна
	Route::post('get_lang', 'PersonalSettingController@get_langs');
	Route::post('change_lang', 'PersonalSettingController@change_lang');


    Route::prefix('personal')->group(function () {
    	//Данные пользователя (Поставщик/Покупатель)
        Route::post('get', 'PersonalSettingController@apiMobileGet');
        //Изменение данных пользователей(Поставщик/Покупатель)
        Route::post('edit', 'PersonalSettingController@apiMobileEdit');
        //Изменение аватар пользователя(Поставщик/Покупатель)	
        Route::post('edit_img', 'PersonalSettingController@apiMobileEditImg');
        //Оставить отзыв (для авторизованных
        Route::any('review', 'AdminController@Review');
    });



    // Персональная партнерская ссылка
    Route::get('afillater/invite/qr', 'AdminController@apiMobileGetInvite');
    Route::get('afillater/invite/link', 'AdminController@apiMobileGetInviteLink');

    Route::get('afillater', 'AdminController@getAfillaterIndex')->name('afillater');
    Route::get('afillater/partnership/{level}/{tariff?}', 'AfillateController@getUsers')->name('afillate_users');
    Route::get('afillater/partnership', 'AdminController@getPartnership');


 	/**
     * ############### АУКЦИОНЫ ###############
     */	
    Route::prefix('auction')->group(function () {

        Route::post('get', 'AuctionController@apiMobileGetAuction'); // new api

        Route::post('edit', 'AuctionController@edit');
        Route::post('cancel', 'AuctionController@cancel');
        Route::post('close', 'AuctionController@close');
        Route::post('add_photo', 'AuctionController@add_photo');
        Route::post('edit_photo', 'AuctionController@edit_photo');
        Route::post('get_rates', 'AuctionController@get_rates');

        Route::post('add_rate', 'AuctionController@apiMobile_add_rate'); // new api
        Route::post('add_rate_analog', 'AuctionController@apiMobile_add_rate_analog'); // new api

        Route::post('cancel_rate', 'AuctionController@cancel_rate');
        Route::post('confirm_rate', 'AuctionController@confirm_rate');
        Route::post('delete_rate', 'AuctionController@delete_rate');
        Route::post('get_pdf', 'AuctionController@get_pdf');
        Route::post('confirm_contract', 'AuctionController@confirm_contract');
        Route::get('get_title_options', 'AuctionController@get_title_options');
        Route::get('get_title_options2/{id}', 'AuctionController@get_title_options2');
        Route::post('add_contract_file', 'AuctionController@add_contract_file');
        Route::post('delete_contract_file', 'AuctionController@delete_contract_file');

        Route::any('get_contract_file', 'AuctionController@get_contract_file'); // new api
        Route::post('get_contract_fileApi', 'AuctionController@apiMobile_get_contract_file'); // new api
    });


    Route::get('get_tender_selection_notice', 'AuctionController@get_tender_selection_notice');
    Route::get('get_notif_submitted_offer_tender', 'AuctionController@get_notif_submitted_offer_tender');
    Route::get('get_notif_customer_about_conclusion', 'AuctionController@get_notif_customer_about_conclusion');
    Route::get('get_notif_supplier_about_conclusion', 'AuctionController@get_notif_supplier_about_conclusion');

    //Создание заявки в помощь и поддержку
    Route::post('helpdesk/create', 'TicketController@store');

    //Показать заявку
    Route::post('helpdesk/show', 'TicketController@showApi');

    //Пометить выполненным заявку
    Route::post('helpdesk/complete', 'TicketController@complete');

    Route::post('helpdesk/comment', 'TicketCommentsController@store');

    //Помощь и поддержка
    Route::post('helpdesk/get/data', 'TicketController@data');

    Route::post('helpdesk/get/myData', 'TicketController@dataMyHelpdest'); 

});
































