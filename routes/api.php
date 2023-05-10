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
Route::post('get_auctions', 'Mobile\AuctionController@get_auctions');

//Страница тендера (для неавторизованных)
Route::post('get_auction_page', 'Mobile\AuctionController@get_auction_page');

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
Route::get('get_contract_file_download_file/{god}/{naz}', 'Mobile\AuctionController@apiMobile_get_contract_file_download_file');
Route::get('get_auction_contract_pdf/{auctionId}', 'Mobile\AuctionController@apiMobile_get_auction_contract_pdf');

Route::any('auction/get_contract_file', 'AuctionController@get_contract_file'); // new api

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

        //удалить аккаунт 181122
        Route::post('delete_account', 'PersonalSettingController@apiMobileDeleteAccount');
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

        Route::post('get', 'Mobile\AuctionController@get_auction'); // new api

        Route::post('edit', 'AuctionController@edit');
        Route::post('cancel', 'AuctionController@cancel');
        Route::post('close', 'AuctionController@close');
        Route::post('add_photo', 'AuctionController@add_photo');
        Route::post('edit_photo', 'AuctionController@edit_photo');
        Route::post('get_rates', 'AuctionController@get_rates');

        Route::post('add_rate', 'Mobile\AuctionController@add_rate'); // new api
        Route::post('add_rate_analog', 'Mobile\AuctionController@add_rate_analog'); // new api

        Route::post('cancel_rate', 'AuctionController@cancel_rate');
        Route::post('confirm_rate', 'AuctionController@confirm_rate');
        Route::post('confirm_sale_rate', 'AuctionController@confirm_sale_rate');
        Route::post('delete_rate', 'AuctionController@delete_rate');
        Route::post('get_pdf', 'AuctionController@get_pdf');
        Route::post('confirm_contract', 'AuctionController@confirm_contract');
        Route::get('get_title_options', 'AuctionController@get_title_options');
        Route::get('get_title_options2/{id}', 'AuctionController@get_title_options2');
        Route::post('get_analog_title_options', 'AuctionController@get_analog_title_options');  //new api 281122

        Route::post('add_contract_file', 'AuctionController@add_contract_file');
        Route::post('delete_contract_file', 'AuctionController@delete_contract_file');

        Route::post('get_contract_fileApi', 'Mobile\AuctionController@apiMobile_get_contract_file'); // new api    

        Route::post('add_my_tender', 'AuctionController@add_my_tender'); //191222

        Route::post('get_history', 'AuctionController@get_history'); //081222

        Route::post('get_user_list', 'AuctionController@get_user_list'); //201222

        Route::post('add_doc_file', 'AuctionController@add_doc_file'); //130223

    });

    //Уведомления
    Route::get('get_tender_selection_notice', 'Mobile\AuctionController@get_tender_selection_notice');
    Route::get('get_notif_submitted_offer_tender', 'Mobile\AuctionController@get_notif_submitted_offer_tender');
    Route::get('get_notif_customer_about_conclusion', 'Mobile\AuctionController@get_notif_customer_about_conclusion');
    Route::get('get_notif_supplier_about_conclusion', 'Mobile\AuctionController@get_notif_supplier_about_conclusion');

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


    /**
     * ############### Сообщения ###############
     */
    Route::prefix('messages')->group(function () {
        Route::get('index', 'MessageController@index')->name('messages_index');
        Route::get('index_new', 'MessageController@index_new')->name('messages_index_new');      
        Route::post('get_messages', 'MessageController@get_messages')->name('messages_get');
        Route::post('get_admin_messages', 'MessageController@get_admin_messages')->name('messages_get_admin');
        Route::post('send', 'MessageController@send')->name('messages_send');
        Route::post('publish', 'MessageController@publish')->name('messages_publish');
        Route::post('update', 'MessageController@update')->name('messages_update');
        Route::get('destroy/{id}', 'MessageController@destroy')->name('messages_destroy');
        Route::post('get_xls', 'MessageController@get_xls')->name('messages_get_xls');
    });

});
































