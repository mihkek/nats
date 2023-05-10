<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/*############### ВНЕШНИЙ САЙТ ##################################################*/
//Route::get('/', 'Controller@getIndexPage')->name('index');


Route::get('/sitemap', 'SitemapController@index');
Route::get('/sitemap/pages', 'SitemapController@pages');
Route::get('/sitemap/tenders', 'SitemapController@tenders');
Route::get('/sitemap/sales', 'SitemapController@sales');
Route::get('/sitemap/news', 'SitemapController@news');


//Route::get('sale_test', 'AuctionController@sale_test');
Route::get('set_analogs', 'IndexController@set_analogs');

Route::get('firebase_test', 'AuctionController@firebase_test');

Route::get('/api_test', 'TestController@api');


/*
Route::get("/", function () {
    return view("index.index");
})->name('index');
*/

Route::get('/', 'IndexController@index');

Route::get("/auctions", function () {
    return view("index.auctions");
})->name('auctions');

Route::get("/tenders", function () {
    return view("index.tenders");
})->name('tenders');

Route::get("/sales", function () {
    return view("index.sales");
})->name('sales');
Route::get("/about_service", function () {
    return view("index.about_service");
})->name('about_service');
Route::get("/services", function () {
    return view("index.services");
})->name('services');



Route::get('tenders/{auction_id}', 'IndexController@getPageTender');
Route::get('auctions/{auction_id}', 'IndexController@getPageAuction');
Route::get('sales/{auction_id}', 'IndexController@getPageSale');





// FED
Route::any('/callme', 'IndexController@callme');

Route::prefix('index')->group(function () {
    Route::post('/get_auctions', 'IndexController@get_auctions');
    Route::post('/get_auction/{auction_id}', 'IndexController@get_auction');

    Route::get('/get_counters', 'IndexController@get_counters');

    Route::post('/get_news', 'IndexController@get_news'); // new
});

Route::get('partners', 'Controller@getIndexPartnersList');
Route::get('partners/{category_id}-{territory_id}', 'Controller@getIndexPartnersList');
Route::get('partners/{category_id}', 'Controller@getIndexPartnersList');
Route::get('partners/card/{id}-{territory_id}', 'Controller@getIndexPartnerCard');
Route::get('partners/card/{id}', 'Controller@getIndexPartnerCard');
Route::get('search', 'Controller@getIndexSearch'); // поиск старт
Route::post('review/getlist', 'Controller@ReviewList');

Route::get('categories', 'Controller@getIndexCategoriesList');

Route::get('about', 'Controller@getIndexAbout');
Route::get('docs', 'Controller@getIndexDocs');
Route::get('saving', 'Controller@getIndexSaving');
Route::get('earning', 'Controller@getIndexeEarning');
Route::get('cooperation', 'Controller@getIndexCooperation');
Route::get('faq', 'Controller@getIndexFaq');
Route::get('job', 'Controller@getIndexJob');
Route::get('contacts', 'Controller@getIndexContacts');
Route::get('oferta', 'Controller@getIndexOferta');
Route::get('usage', 'Controller@getIndexUsage');

//old news
Route::get('news/1', function() { 
    return redirect('news/povyshenie-ehffektivnosti-vedeniya-biznesa-za-schet-vnedreniya-peredovyh-upravlencheskih-reshenij', 301); 
});
Route::get('news/54', function() { 
    return redirect('news/s-tochnostyu-do-millilitra-kak-zashchitit-selhozkultury-bez-poter', 301); 
});
Route::get('news/55', function() { 
    return redirect('news/pravitelstvo-utverdilo-subsidirovaniya-proizvoditelej-selhoztekhniki', 301); 
});
Route::get('news/56', function() { 
    return redirect('news/s-nastupayushchim-novym-godom-i-rozhdestvom', 301); 
});
Route::get('news/59', function() { 
    return redirect('news/s-12-yanvarya-ehksportnaya-poshlina-na-pshenicu-povyshaetsya-do-98-2-za-tonnu', 301); 
});
Route::get('news/60', function() { 
    return redirect('news/minselhoz-rf-otkazalsya-ot-planov-po-izmeneniyu-uslovij-lgotnogo-kreditovaniya-apk', 301); 
});
Route::get('news/61', function() { 
    return redirect('news/budushchee-rossijskih-ferm-prognoz-na-20-let', 301); 
});
Route::get('news/62', function() { 
    return redirect('news/onlajn-torgi-v-selskohozyajstvennoj-sfere', 301); 
});
Route::get('news/63', function() { 
    return redirect('news/gerbicidy-dlya-udaleniya-sornyakov', 301); 
});
Route::get('news/64', function() { 
    return redirect('news/sredstva-zashchity-rastenij', 301); 
});
Route::get('news/65', function() { 
    return redirect('news/insekticidy-i-pesticidy', 301); 
});
Route::get('news/66', function() { 
    return redirect('news/dlya-chego-ispolzuyut-pesticidy', 301); 
});
Route::get('news/67', function() { 
    return redirect('news/kak-rabotaet-torgovaya-ploshchadka', 301); 
});
Route::get('news/68', function() { 
    return redirect('news/osobennosti-i-princip-provedeniya-tendernyh-zakupok', 301); 
});
Route::get('news/69', function() { 
    return redirect('news/dlya-chego-nuzhny-tendery-v-selskohozyajstvennoj-sfere', 301); 
});
Route::get('news/70', function() { 
    return redirect('news/podrobnee-pro-himicheskie-sredstva-zashchity-rastenij', 301); 
});
Route::get('news/71', function() { 
    return redirect('news/vystavka-demonstraciya-dostizhenij-v-apk-den-voronezhskogo-polya-2022', 301); 
});
Route::get('news/72', function() { 
    return redirect('news/chem-udivil-den-voronezhskogo-polya-2022', 301); 
});
Route::get('news/73', function() { 
    return redirect('news/onlajn-torgovye-ploshchadki', 301); 
});
Route::get('news/74', function() { 
    return redirect('news/sajt-ehlektronnoj-torgovoj-ploshchadki', 301); 
});
Route::get('news/75', function() { 
    return redirect('news/tender-ehlektronnaya-torgovaya-ploshchadka', 301); 
});
Route::get('news/76', function() { 
    return redirect('news/princip-raboty-i-preimushchestva-torgovyh-ploshchadok', 301); 
});
Route::get('news/77', function() { 
    return redirect('news/raznovidnosti-funkcii-i-preimushchestva-ehlektronnyh-ploshchadok', 301); 
});
Route::get('news/78', function() { 
    return redirect('news/torgovye-ploshchadki-v-internete', 301); 
});





//news
Route::get('news', 'IndexController@getNewsList')->name('news_list');
Route::get('news/{slug}', 'IndexController@getNews')->name('news_card');


Route::post('/get_cities', 'ConfigerController@get_cities');

/*############### ВНЕШНИЙ САЙТ ОПЛАТА ##################################################*/
Route::any('payment/result', 'BillingController@postRobokassaResult');

/*############### АДМИНКА ##################################################*/
Route::prefix('admin')->middleware(['auth:web', 'org_config', 'lang', 'field_access'])->group(function () {


    


    /*### Прочие сервисы и возможности ###*/
    Route::get('/', 'AdminController@getIndex');
    Route::get('/test', 'AdminController@getTest');
    Route::get('dashboard/1', 'AdminController@getDashboard1');
    Route::get('dashboard/2', 'AdminController@getDashboard2');
    Route::get('dashboard/3', 'AdminController@getDashboard3');

    Route::get('support/service', 'AdminController@getSupportService')->name('support_service');
    Route::get('support/faq', 'AdminController@getSupportFaq')->name('support_faq');
    Route::get('support/news', 'AdminController@getSupportNews')->name('support_news');
    Route::get('support/contacts', 'AdminController@getSupportContacts')->name('support_contacts');
    Route::get('support/learning', 'AdminController@getSupportLearning')->name('support_learning');
    Route::get('support/docs', 'AdminController@getSupportDocs')->name('support_docs');


    /**
     * Клиенты
     */
    Route::get('customer/help', 'CustomerController@getHelp');
    Route::get('customer/firms', 'CustomerController@getgetListFirms');
    Route::get('customer/firms/card/{id}', 'CustomerController@getCardFirm');
    Route::get('customer/peoples', 'CustomerController@getgetListPeoples');
    Route::get('customer/peoples/card/{id}', 'CustomerController@getCardPeople');
    Route::get('customer/list', 'CustomerController@getgetListRepresents')->name('customer_list');
    Route::get('customer/list_new', 'CustomerController@getgetListNewRepresents')->name('customer_list_new');
    Route::get('customer/list/card/{id}', 'CustomerController@getCardRepresents')->name('customer_list_card');
    Route::get('customer/archive/card/{id}', 'CustomerController@getCardRepresents')->name('customer_list_card');
    Route::get('customer/add', 'CustomerController@getAddCardRepresents')->name('customer_add');
    Route::get('customer/archive', 'CustomerController@getArchive')->name('customer_archive');
    Route::get('customer/groups', 'CustomerController@getGroups')->name('customer_groups');
    Route::get('customer/groups/new', 'CustomerController@getNewGroup')->name('customer_groups');
    Route::get('customer/groups/card/{id}', 'CustomerController@getGroupCard')->name('customer_groups');

    /**
     * Справочники
     */
    Route::get('directory/firms', 'DirectoryController@getListFirms')->name('directory_firm_list');
    Route::get('directory/firms/{id}', 'DirectoryController@getCardFirm')->name('directory_firm_card');
    Route::get('directory/add_firm', 'DirectoryController@getAddCardFirm')->name('directory_firm_add');
    Route::get('directory/firms_archive/{id}', 'DirectoryController@getCardFirm')->name('directory_firm_card');
    Route::get('directory/firms_archive', 'DirectoryController@getFirmsArchive')->name('directory_firm_archive');
    Route::get('directory/people', 'DirectoryController@getgetListPeoples')->name('directory_person_list');
    Route::get('directory/people_new', 'DirectoryController@getgetListNewPeoples')->name('directory_person_list_new');
    Route::get('directory/people_archive', 'DirectoryController@getPeopleArchive')->name('directory_person_archive');
    Route::get('directory/people_archive/{id}', 'DirectoryController@getCardPeople')->name('directory_person_card');
    Route::get('directory/people/{id}', 'DirectoryController@getCardPeople')->name('directory_person_card');
    Route::get('directory/add_person', 'DirectoryController@getAddCardPeople')->name('directory_person_add');

    /*### Заявки ###*/
    Route::get('requester/help', 'RequesterController@getHelp')->name('requester_help');
    Route::get('requester/now', 'RequesterController@getListNow')->name('requester_now');
    Route::get('requester/add', 'RequesterController@getAddCard')->name('requester_add');
    Route::get('requester/now/card/{id}', 'RequesterController@getCard')->name('requester_now_card');
    Route::get('requester/list', 'RequesterController@getList')->name('requester_list');
    Route::get('requester/report', 'RequesterController@getReport')->name('requester_report');
    Route::get('requester/list/card/{id}', 'RequesterController@getCard')->name('requester_list_card');


    /*### Новости ###*/
    Route::post('/block-user/', 'AdminController@blockUser');


    /*### Новости ###*/
    Route::get('new-news', 'AdminController@getNews')->name('new-news');
    Route::get('new-news/{id}', 'AdminController@getNewsById')->name('new-news');
    Route::post('new-news/{id}', 'AdminController@postNewsById')->name('new-news');
    Route::get('new-news/delete/{id}', 'AdminController@deleteNewsById')->name('new-news');

    /*### Аукционы ###*/
    Route::get('auction/now', 'AuctionController@getListNow')->name('auction_now');
    Route::get('auction/blocked', 'AuctionController@getBlocked')->name('auction_now_blocked');
    Route::get('auction/add', 'AuctionController@getAddCard')->name('auction_add');
    Route::get('auction/now/card/{id}', 'AuctionController@getCard')->name('auction_now_card');
    Route::get('auction/list', 'AuctionController@getList')->name('auction_list');
    Route::get('auction/list/card/{id}', 'AuctionController@getCard')->name('auction_list_card');
    Route::get('auction/mylist', 'AuctionController@getMyList')->name('auction_mylist');





    /*### Тендеры ###*/
    Route::get('tender/now', 'AuctionController@getTenderListNow')->name('tender_now');
    Route::get('tender/add', 'AuctionController@getTenderAddCard')->name('tender_add');
    Route::get('tender/now/card/{id}', 'AuctionController@getTenderCard')->name('tender_now_card');
    Route::get('tender/list', 'AuctionController@getTenderList')->name('tender_list');
    Route::get('tender/list/card/{id}', 'AuctionController@getTenderCard')->name('tender_list_card');
    Route::get('tender/mylist', 'AuctionController@getTenderMyList')->name('tender_mylist');
    Route::get('tender/deleted-action-list', 'AuctionController@getDeletedTenderMyList')->name('tender_deleted_mylist');
    Route::get('tender/history', 'AuctionController@getTenderHistory')->name('tender_history'); //071222
    Route::get('tender/userlist/{id}', 'AuctionController@getTenderUserList')->name('tender_user_list'); //201222



    /*### Тендеры ДВ 040423 ###*/ 

    Route::get('tenderdv/now', 'AuctionController@getTenderDvListNow')->name('tender_dv_now');
    Route::get('tenderdv/add', 'AuctionController@getTenderDvAddCard')->name('tender_dv_add');
    Route::get('tenderdv/now/card/{id}', 'AuctionController@getTenderDvCard')->name('tender_dv_now_card');
    Route::get('tenderdv/mylist', 'AuctionController@getTenderDvMyList')->name('tender_dv_mylist');
    Route::get('tenderdv/list', 'AuctionController@getTenderDvList')->name('tender_dv_list');


    /*### Распродажи ###*/
    Route::get('sale/now', 'AuctionController@getSaleListNow')->name('sale_now');
    Route::get('sale/add', 'AuctionController@getSaleAddCard')->name('sale_add');
    Route::get('sale/now/card/{id}', 'AuctionController@getSaleCard')->name('sale_now_card');
    Route::get('sale/list', 'AuctionController@getSaleList')->name('sale_list');
    Route::get('sale/list/card/{id}', 'AuctionController@getSaleCard')->name('sale_list_card');
    Route::get('sale/mylist', 'AuctionController@getSaleMyList')->name('sale_mylist');


    Route::get('block-subliers', 'AdminController@indexSubliers')->name('sublier_list');
    Route::get('block-subliers-list', 'AdminController@indexJSONSubliers')->name('sublier_list_json');
    Route::get('block-subliers/{id}', 'AdminController@detailSubliers')->name('sublier_detail');
    Route::get('block-subliers/delete/{id}', 'AdminController@deleteBlockUser')->name('sublier_delete');


    /**
     * Заказы и занятия
     */
    Route::get('orderer/help', 'OrdererController@getHelp');
    Route::get('orderer/now', 'OrdererController@getListNow')->name('orderer_list_now');
    Route::get('orderer/now/card/{id}', 'OrdererController@getCard')->name('orderer_card');
    Route::get('orderer/list', 'OrdererController@getList')->name('orderer_list');
    Route::get('orderer/list/card/{id}', 'OrdererController@getCard')->name('orderer_card');
    Route::get('orderer/calendar', 'OrdererController@getСalendar')->name('orderer_calendar');
    Route::get('orderer/add', 'OrdererController@getAdd')->name('orderer_add');

    /*### Модуль афиллатов и партнёров ###*/
    Route::get('afillater', 'AdminController@getAfillaterIndex')->name('afillater');
    Route::get('afillater/invite', 'AdminController@getInvite');
    Route::get('afillater/partnership/{level}/{tariff?}', 'AfillateController@getUsers')->name('afillate_users');
    Route::get('afillater/partnership', 'AdminController@getPartnership');

    /*### Личные данные ###*/
    Route::get('settings/help', 'AdminController@getHelp');
    Route::get('settings/personal', 'AdminController@getSettings')->name('settings_personal');
    Route::get('settings/personal/{new?}', 'AdminController@getSettings');
    Route::post('settings/personal', 'AdminController@postSettings');
    Route::get('settings/tsp', 'AdminController@getTsp');
    Route::post('settings/tsp', 'AdminController@postTsp');
    Route::get('settings/tsp/download/{file}', 'AdminController@getTspFile');
    Route::post('settings/post-password', 'AdminController@postChangePassword');
    Route::post('settings/post-address', 'AdminController@postChangeAddress');
    Route::post('settings/post-avatar', 'AdminController@postChangeAvatar');
    Route::post('settings/post-afillate', 'AdminController@postChangeAfillate');

    /*### Отзывы ###*/
    Route::any('personal/review', 'AdminController@Review');
    Route::post('personal/review/getlist', 'AdminController@ReviewList');
    Route::post('personal/review/update', 'AdminController@updateReview');
    Route::post('personal/review/delete', 'AdminController@deleteReview');

    /*### Шаблоны (сервис формирования шаблонов-документов) ###*/
    Route::get('templater/help', 'TemplaterController@getHelp');
    Route::get('templater/settings', 'TemplaterController@getSettings');
    Route::get('templater/add', 'TemplaterController@getAdd'); // показ всех шаблонов
    Route::get('templater/add/{category_id?}', 'TemplaterController@getAdd'); // переключение категорий
    Route::get('templater/add/{id}/start', 'TemplaterController@getAddStart'); // старт выбора шаблона
    Route::get('templater/add/{id}/example', 'TemplaterController@getAddExample'); // другой документ
    Route::get('templater/add/{id}/example/{category_id?}', 'TemplaterController@getAddExample'); // категории
    Route::post('templater/add/{id}/generate', 'TemplaterController@postAddGenerate'); // финальная генерация
    Route::get('templater/list', 'TemplaterController@getList'); // показ всех документов из архива
    Route::get('templater/list/{category_id?}', 'TemplaterController@getList'); // переключение категорий
    Route::get('templater/list/card/{id}', 'TemplaterController@getCard');

    /*### Документы (сервис документооборота) ###*/
    Route::get('documenter/help', 'DocumenterController@getHelp');
    Route::get('documenter/settings', 'DocumenterController@getSettings');
    Route::get('documenter/list', 'DocumenterController@getList'); // показ всех документов из архива
    Route::get('documenter/list/{category_id?}', 'DocumenterController@getList'); // переключение категорий
    Route::get('documenter/list/card/{id}', 'DocumenterController@getCard');
    Route::get('documenter/download/{id}/{action}', 'DocumenterController@getDownload');

    /*### Администрирование ###*/
    Route::get('configer/help', 'ConfigerController@getHelp');

    Route::get('configer/users', 'ConfigerController@getUsers')->name('configer_users_list');
    Route::get('configer/users_archive', 'ConfigerController@getUsersArchive')->name('configer_users_archive');
    Route::get('configer/users/new', 'ConfigerController@getNewUser')->name('configer_users_new');
    Route::get('configer/users/card/{id}', 'ConfigerController@getUserCard')->name('configer_users_card');

    Route::get('configer/subdivisions', 'ConfigerController@getSubdivisions')->name('configer_subdivisions_list');
    Route::get('configer/subdivisions/new', 'ConfigerController@getNewSubdivision')->name('configer_subdivisions_new');
    Route::get('configer/subdivisions/card/{id}', 'ConfigerController@getSubdivisionCard')->name('configer_subdivisions_card');

    Route::get('configer/roles', 'ConfigerController@getRoles')->name('configer_roles_list');
    Route::get('configer/roles/new', 'ConfigerController@getNewRole')->name('configer_roles_new');
    Route::get('configer/roles/card/{id}', 'ConfigerController@getRoleCard')->name('configer_roles_card');

    Route::get('configer/drugs', 'ConfigerController@getDrugs')->name('configer_drugs_list');
    Route::post('configer/analog_drugs', 'ConfigerController@getAnalogsDrugs')->name('configer_analog_drugs_list');
    
    //060423
    Route::post('configer/dv_drugs', 'ConfigerController@getDvDrugs')->name('configer_dv_drugs_list');


    Route::get('configer/token', 'ConfigerController@getToken');
    Route::post('configer/token', 'ConfigerController@postToken');
    Route::get('configer/convertapi', 'ConfigerController@getConvertapi');

    /*### СМС ###*/
    Route::get('configer/sms_api', 'SmserController@getSms')->name('configer_sms');

    /*### Биллинг и оплата ###*/
    Route::get('billing/pay', 'BillingController@getPayment')->name('billing_pay');
    Route::post('billing/pay/robokassa', 'BillingController@postPaymentRobokassa');
    Route::get('billing/create', 'BillingController@createPay')->name('billing_create');
    Route::get('billing/create_payout', 'BillingController@createPayOut')->name('billing_create_payout');
    Route::get('billing/order', 'BillingController@getOrder');
    Route::post('billing/order', 'BillingController@postOrder');
    Route::get('billing/history', 'BillingController@getFinancial')->name('billing_history');
    Route::get('billing/subscriptions_history', 'BillingController@getSubscriptions')->name('billing_subscriptions');

    Route::get('billing/history/{pay_result}', 'BillingController@getFinancial');
    Route::get('billing/saving', 'BillingController@getSaving');
    Route::get('billing/earning', 'BillingController@getEarning');
    Route::get('billing/cards', 'BillingController@getCards');
    Route::post('billing/post-giftcard', 'BillingController@postGiftcards');

    /*### Приобретение услуг ###*/
    Route::get('services/list', 'ServicesController@getList');
    Route::get('services/{service_id}', 'ServicesController@getService');
    Route::post('services/order', 'ServicesController@postOrder');

    /*### Рейтинг и начисления ###*/
    Route::get('rating/history', 'RatingController@getHistory');

    Route::get('reports', 'AdminController@getReports');

    /**
     * ############### Партнеры (сервис партнеров) ###############
     */
    Route::get('partnerer/help', 'PartnererController@getHelp')->name('website');
    Route::get('partnerer/list', 'PartnererController@getList')->name('website'); // показ всех партнеров
    Route::get('partnerer/list/{category_id}-{territory_id}', 'PartnererController@getList')->name('website'); // переключение категорий
    Route::get('partnerer/list/{category_id}', 'PartnererController@getList')->name('website'); // переключение категорий
    Route::get('partnerer/list/card/{id}-{territory_id}', 'PartnererController@getCard')->name('website');
    Route::get('partnerer/list/card/{id}', 'PartnererController@getCard')->name('website');
    Route::get('partnerer/search', 'PartnererController@getSearch')->name('website'); // поиск старт

    /**
     * ############### purchaser - сервис загруженных вручную документов, чеков или квитанций ###############
     */
    Route::get('purchaser/help', 'PurchaserController@getHelp')->name('website');
    Route::get('purchaser/list', 'PurchaserController@getList')->name('website'); // показ всех загруженных документов
    Route::get('purchaser/list/{category_id?}', 'PurchaserController@getList')->name('website'); // переключение категорий
    Route::post('purchaser/list', 'PurchaserController@postSearch')->name('website'); // поиск результаты
    Route::get('purchaser/list/card/{id}', 'PurchaserController@getCard')->name('website');
    Route::get('purchaser/download/{id}/{action}', 'PurchaserController@getDownload')->name('website');
    Route::get('purchaser/search', 'PurchaserController@getSearch')->name('website'); // поиск старт
    Route::get('purchaser/add', 'PurchaserController@getAdd')->name('website'); // добавление и загрузка нового документа
    Route::post('purchaser/add', 'PurchaserController@getAdd')->name('website'); // TODO: ДОДЕЛАТЬ


    /**
     * ############### КЛИЕНТЫ ###############
     */
    Route::prefix('customers')->group(function () {
        Route::post('get', 'CustomerController@get');
        Route::post('edit', 'CustomerController@edit');
        Route::post('delete', 'CustomerController@delete');
        Route::post('restore', 'CustomerController@restore');
        Route::post('edit_img', 'CustomerController@edit_img');
        Route::post('edit_check_file', 'CustomerController@edit_check_file');
        Route::post('get_types', 'CustomerController@get_types');
        Route::post('edit_customer_person', 'CustomerController@edit_customer_person');
        Route::post('delete_customer_person', 'CustomerController@delete_customer_person');
        Route::post('get_customer_subscriptios', 'CustomerController@get_customer_subscriptios');
        Route::post('get_subscription_price', 'CustomerController@get_subscription_price');
        Route::post('add_subscription', 'CustomerController@add_subscription');
        Route::post('del_subscription', 'CustomerController@del_subscription');
        Route::post('pay_subscription', 'CustomerController@pay_subscription');
        Route::post('edit_subscription', 'CustomerController@edit_customer_subscription');
        Route::post('get_groups', 'CustomerGroupController@get');
        Route::post('edit_group', 'CustomerGroupController@edit');
        Route::post('delete_group', 'CustomerGroupController@delete');
        Route::post('sign_group', 'CustomerGroupController@sign');
        Route::post('add_group_orders', 'CustomerGroupController@add_orders');
        Route::post('add_customer_paytable', 'CustomerController@add_customer_paytable');
        Route::post('edit_customer_paytable', 'CustomerController@edit_customer_paytable');
        Route::post('clear_customer_paytable', 'CustomerController@clear_customer_paytable');
        Route::post('add_pay', 'CustomerController@add_pay');
        Route::post('get_notifications', 'CustomerController@get_notifications');
        Route::post('get_contract_pdf', 'CustomerController@get_contract_pdf');
    });

    /**
     * ############### АУКЦИОНЫ ###############
     */
    Route::prefix('auction')->group(function () {
        Route::post('get', 'AuctionController@get');
        Route::post('edit', 'AuctionController@edit');
        Route::post('cancel', 'AuctionController@cancel');
        Route::post('close', 'AuctionController@close'); //140722
        Route::post('restore', 'AuctionController@restore'); //281222     
        Route::post('complete', 'AuctionController@complete'); //160223 
        Route::post('add_photo', 'AuctionController@add_photo');
        Route::post('edit_photo', 'AuctionController@edit_photo');
        Route::post('get_rates', 'AuctionController@get_rates');
        Route::post('add_rate', 'AuctionController@add_rate');
        Route::post('add_rate_analog', 'AuctionController@add_rate_analog');
        Route::post('cancel_rate', 'AuctionController@cancel_rate');
        Route::post('confirm_rate', 'AuctionController@confirm_rate');
        Route::post('confirm_sale_rate', 'AuctionController@confirm_sale_rate');
        Route::post('delete_rate', 'AuctionController@delete_rate');
        Route::post('get_pdf', 'AuctionController@get_pdf');
        Route::post('confirm_contract', 'AuctionController@confirm_contract');
        Route::get('get_title_options', 'AuctionController@get_title_options');
        Route::get('get_title_options2/{id}', 'AuctionController@get_title_options2');
        Route::post('add_contract_file', 'AuctionController@add_contract_file');
        Route::post('delete_contract_file', 'AuctionController@delete_contract_file');
        Route::post('add_doc_file', 'AuctionController@add_doc_file'); //130223
        Route::post('get_doc_file', 'AuctionController@get_doc_file'); //140223


        Route::get('get_dv_options', 'AuctionController@get_dv_options'); //050423
    });



    /**
     * ############### ЦЕНТРЫ ###############
     */
    Route::prefix('directory/firms')->group(function () {
        Route::post('get', 'DirectoryFirmController@get');
        Route::post('edit', 'DirectoryFirmController@edit');
        Route::post('delete', 'DirectoryFirmController@delete');
        Route::post('restore', 'DirectoryFirmController@restore');
        Route::post('edit_img', 'DirectoryFirmController@edit_img');
        Route::post('edit_firm_person', 'DirectoryFirmController@edit_firm_person');
        Route::post('delete_firm_person', 'DirectoryFirmController@delete_firm_person');
        Route::post('get_busy_times', 'DirectoryFirmController@get_busy_times');
        Route::post('get_busy_calendar_times', 'DirectoryFirmController@get_busy_calendar_times');
        Route::post('edit_busy_time', 'DirectoryFirmController@edit_busy_time');
        Route::post('delete_busy_time', 'DirectoryFirmController@delete_busy_time');
    });

    /**
     * ############### ЛОГОПЕДЫ ###############
     */
    Route::prefix('directory/people')->group(function () {
        Route::post('get', 'DirectoryPersonController@get');
        Route::post('edit', 'DirectoryPersonController@edit');
        Route::post('delete', 'DirectoryPersonController@delete');
        Route::post('restore', 'DirectoryPersonController@restore');
        Route::post('confirm', 'DirectoryPersonController@confirm');
        Route::post('reject', 'DirectoryPersonController@reject');
        Route::post('edit_img', 'DirectoryPersonController@edit_img');
        Route::post('edit_check_file', 'DirectoryPersonController@edit_check_file');
        Route::post('get_busy_times', 'DirectoryPersonController@get_busy_times');
        Route::post('get_busy_calendar_times', 'DirectoryPersonController@get_busy_calendar_times');
        Route::post('edit_busy_time', 'DirectoryPersonController@edit_busy_time');
        Route::post('delete_busy_time', 'DirectoryPersonController@delete_busy_time');
    });

    /**
     * ############### ЗАНЯТИЯ ###############
     */
    Route::prefix('orderers')->group(function () {
        Route::post('get', 'OrdererController@get');
        Route::post('edit', 'OrdererController@edit');
        Route::post('confirm', 'OrdererController@confirm');
        Route::post('transfer', 'OrdererController@transfer');
        Route::post('cancel', 'OrdererController@cancel');
        Route::post('get_additional_places', 'OrdererController@get_additional_places');
        Route::post('get_statuses', 'OrdererController@get_statuses');
        Route::post('mark_customer', 'OrdererController@mark_customer');
    });


    /**
     * ############### Настройки профиля ###############
     */
    Route::prefix('settings')->group(function () {
        Route::post('get_langs', 'PersonalSettingController@get_langs');
        Route::post('change_lang', 'PersonalSettingController@change_lang');
        Route::prefix('personal')->group(function () {
            Route::post('get', 'PersonalSettingController@get');
            Route::post('edit', 'PersonalSettingController@edit');
            Route::post('edit_img', 'PersonalSettingController@edit_img');
            Route::post('change_pass', 'PersonalSettingController@change_pass');
            Route::post('delete_account', 'PersonalSettingController@delete_account');
        });
    });

    /**
     * ############### Настройки профиля ###############
     */


    /**
     * ############### ПОЛЬЗОВАТЕЛИ ###############
     */
    Route::prefix('users')->group(function () {
        Route::post('get', 'UserController@get');
        Route::post('get_info', 'UserController@get_info'); // 170522
        Route::post('get_current', 'UserController@get_current'); // 261022
        Route::post('check_complete', 'UserController@check_complete');
        Route::post('get_account_statement', 'UserController@get_account_statement');
        Route::prefix('orderers')->group(function () {
            Route::post('get_next_orderer', 'UserOrdererController@get_next_orderer');
            Route::post('get_today_orderers', 'UserOrdererController@get_today_orderers');
        });
    });

    /**
     * ############### БИЛЛИНГ ###############
     */
    Route::prefix('billing')->group(function () {
        Route::post('get_subscriptions_history', 'BillingController@get_subscriptions_history');
        Route::post('get_history', 'BillingController@get_history');
        Route::post('create_pay', 'BillingController@create_pay');
        Route::post('create_payout', 'BillingController@create_payout');
    });

    /**
     * ############### ЗАЯВКИ ###############
     */
    Route::prefix('requester')->group(function () {
        Route::post('get', 'RequesterController@get');
        Route::post('edit', 'RequesterController@edit');
        Route::post('edit_items', 'RequesterController@edit_items');
        Route::post('delete_items', 'RequesterController@delete_items');
        Route::post('add_customer', 'RequesterController@add_customer');
        Route::post('add_photo', 'RequesterController@add_photo');
        Route::post('del_photo', 'RequesterController@del_photo');
        Route::post('is_false', 'RequesterController@is_false');
        Route::post('is_claim', 'RequesterController@is_claim');
        Route::post('get_report', 'RequesterController@get_report');
        Route::post('get_notifications', 'RequesterController@get_notifications');
        Route::post('confirm_record', 'RequesterController@confirm_record');
    });

    Route::prefix('my-auction')->group(function () {
        Route::get('add/{id}', 'AuctionController@addMyAuction');
        Route::get('delete/{id}', 'AuctionController@deleteMyAuction');
        Route::get('list', 'AuctionController@MyAuctionHistoryList');
        Route::post('edit_items', 'RequesterController@edit_items');
        Route::post('delete_items', 'RequesterController@delete_items');

    });

    /**
     * ############### КОНФИГЕР ###############
     */
    Route::prefix('sms')->group(function () {
        Route::post('get', 'SmserController@get');
        Route::post('new', 'SmserController@new');
        Route::post('get_balance', 'SmserController@get_balance');
        Route::post('send_customer_sms', 'SmserController@send_customer_sms');
    });

    Route::prefix('configer')->group(function () {
        Route::prefix('roles')->group(function () {
            Route::post('get', 'ConfigerController@get_roles');
            Route::post('edit', 'ConfigerController@edit_role');
        });

        Route::prefix('drugs')->group(function () {
            Route::post('get', 'ConfigerController@get_drugs');
            Route::post('edit', 'ConfigerController@edit_drug');
            Route::post('delete', 'ConfigerController@delete_drug');
        });

        Route::prefix('users')->group(function () {
            Route::post('get', 'ConfigerController@get_users');
            Route::post('edit', 'ConfigerController@edit_user');
            Route::post('delete', 'ConfigerController@delete_user');
            Route::post('restore', 'ConfigerController@restore_user');
            Route::post('edit_img', 'ConfigerController@edit_user_img');
            Route::post('edit_pass', 'ConfigerController@edit_user_pass');
            Route::post('get_directory_person_users', 'ConfigerController@get_directory_person_users');
            Route::post('get_directory_firm_users', 'ConfigerController@get_directory_firm_users');
            Route::post('get_customer_users', 'ConfigerController@get_customer_users');
            Route::post('get_company_users', 'ConfigerController@get_company_users');
            Route::post('get_managers_users', 'ConfigerController@get_managers_users');
            Route::post('get_directory_users', 'ConfigerController@get_directory_users');
        });

        Route::prefix('subdivisions')->group(function () {
            Route::post('get', 'ConfigerController@get_subdivisions');
            Route::post('edit', 'ConfigerController@edit_subdivision');
            Route::post('delete', 'ConfigerController@delete_subdivision');
        });

    });

    Route::get('change-logger/{model}/{id}', 'ChangeLoggerController@getChanges');

    /**
     * ############### Промоутеры ###############
     */
    Route::prefix('promoters')->group(function () {
        Route::get('list', 'PromoterController@getList')->name('promoters_list');
        Route::get('archive', 'PromoterController@getArchive')->name('promoters_archive');
        Route::get('new', 'PromoterController@getNew')->name('promoters_new');
        Route::get('list/{id}', 'PromoterController@getCard')->name('promoters_card');
        Route::get('archive/{id}', 'PromoterController@getCard')->name('promoters_card');
        Route::post('get', 'PromoterController@get');
        Route::post('get_users', 'PromoterController@get_users');
        Route::post('edit', 'PromoterController@edit');
        Route::post('delete', 'PromoterController@delete');
        Route::post('restore', 'PromoterController@restore');
        Route::post('edit_img', 'PromoterController@edit_img');
    });

    /**
     * ############### Промоутеры ###############
     */
    Route::prefix('reports')->group(function () {
        Route::get('promoters', 'ReportController@getPromoters')->name('promoters_report');
        Route::get('operators', 'ReportController@getOperators')->name('operators_report');
        Route::get('managers', 'ReportController@getManagers')->name('managers_report');
        Route::get('lids', 'ReportController@getLids')->name('lids_report');
        Route::get('global', 'ReportController@getGlobal')->name('global_report');
        Route::post('get_promoters', 'ReportController@get_promoters');
        Route::post('get_operators', 'ReportController@get_operators');
        Route::post('get_managers', 'ReportController@get_managers');
        Route::post('get_lids', 'ReportController@get_lids');
        Route::post('get_global', 'ReportController@get_global');
    });

    Route::post('/preload_img', 'AdminController@preload_img');

    /**
     * ############### Сообщения ###############
     */
    Route::prefix('messages')->group(function () {        
        Route::get('list', 'MessageController@list')->name('messages_list');
        Route::get('list_new', 'MessageController@list_new')->name('messages_list_new');
        Route::get('counter', 'MessageController@counter')->name('messages_counter');
    });

});

Route::middleware(['auth:web', 'org_config', 'lang', 'field_access'])->group(function () {
    Route::get('promoter', 'PromoterController@getIndex');
});


/**
 * ############### АВТОРИЗАЦИЯ-РЕГИСТРАЦИЯ ###############
 */
Route::redirect('admin/login', '/login');
Route::get('login', 'Auth\LoginController@getLogin');
Route::get('go', 'Auth\LoginController@getGo');
Route::post('/auth/go', 'Auth\LoginController@go')->name('go');
Route::post('auth/login', 'Auth\LoginController@login')->name('website');

Route::redirect('admin/logout', '/logout');
Route::redirect('auth/logout', '/logout');
Route::get('logout', 'Auth\LoginController@logout')->name('website');
Route::post('logout', 'Auth\LoginController@logout')->name('website');
Route::get('auth/relogin', 'Auth\LoginController@getRelogin')->name('relogin_back');
Route::post('relogin', 'Auth\LoginController@postRelogin')->name('relogin');

Route::redirect('admin/reg', '/registration');
Route::get('registration', 'Auth\RegisterController@getRegistration');
Route::get('thanksforregistration', 'Auth\RegisterController@getThanksForRegistration');
Route::get('thanksforsupplier', 'Auth\RegisterController@getThanksForSupplier');
Route::post('auth/register', 'Auth\RegisterController@register')->name('website');
// Chernyshkov 20210805 for phone check in reg form (not used until SMS to MTS works)
Route::post('auth/get_smscode', 'Auth\RegisterController@getsmscode')->name('website');
Route::post('auth/get_smsstatus', 'Auth\RegisterController@getsmsstatus')->name('website');

Route::redirect('admin/reminder', '/reminder');
Route::get('reminder', 'Auth\ReminderController@getReminder');
Route::post('auth/reminder', 'Auth\ReminderController@register')->name('website');

Route::get('confirm/{confirmToken}', 'Auth\RegisterController@verification');
Route::get('confirm', 'Auth\RegisterController@verification');

Route::post('ulogin', 'Auth\UloginController@login')->name('website');


/**
 * ############### подключение композеров ###############
 */
view()->composer([
    'admin.menu',
    'admin.template',
], '\App\Http\Composers\CommonComposer');

view()->composer([
    'admin.afillater.afilliate_matrix',
], \App\Http\Composers\AfillaterComposer::class);


/**
 * ############### добавление важны постоянных переменных во все шаблоны ###############
 */
view()->composer('admin.*', function ($view) {
    $view->with('user', Auth::user());
    $view->with('request', Request());
    $view->with('currency', config('currency'));
});

Route::get('storage/excel/{filename}', function ($filename)
{

    $path = storage_path('app/public/excel/' . $filename);

    

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('storage/proofs/{filename}', function ($filename)
{

    $path = storage_path('app/public/proofs/' . $filename);

    

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
Route::get('storage/uploads/{filename}', function ($filename)
{

    $path = storage_path('app/public/uploads/' . $filename);

    

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});







