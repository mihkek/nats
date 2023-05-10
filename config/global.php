<?php return [

	'project' => [
		'url' => 'https://agtender.com',
		'webname' => 'agtender.com',
//		'email' => 'info@agtender.com',
		'email' => 'ag@agtender.com',

        'sitename' => 'НАЦИОНАЛЬНАЯ АГРАРНАЯ ТЕНДЕРНАЯ СИСТЕМА',
        'sitedescription' => 'НАЦИОНАЛЬНАЯ АГРАРНАЯ ТЕНДЕРНАЯ СИСТЕМА',

        'title' => 'ЛИЧНЫЙ КАБИНЕТ', // именительный падеж
		'title2' => 'Личного кабинета', // родительный падеж
		'title0' => 'НАЦИОНАЛЬНАЯ АГРАРНАЯ ТЕНДЕРНАЯ СИСТЕМА', // краткий заголовок в виде названия системы в одно слово

        'title_role_1000' => 'Кабинет Администратора', // именительный падеж
        'title_role_103' => 'Кабинет Помещения', // именительный падеж
        'title_role_102' => 'Кабинет Поставщика', // именительный падеж
        'title_role_101' => 'Кабинет Покупателя', // именительный падеж
    ],



	'logo_title' => [ // лого в админке вверху слева от надпис
		'img' => '/img/logo/on-white-middle1.png',
		'width' => '',
		'height' => '35px',
	],

	'logo_sidebar' => [ // лого в админке слева в сайдбаре под всеми пунктами меню (большое)
		'width' => '0px',
		'height' => '',
	],

	'logo_login' => [ // лого на странице авторизации-регистрации
		'img' => '/img/logo/on-white-middle1.png',
		'width' => '333px',
		'height' => '',
		'img_bg' => '',
		'color_bg' => '#f1f1f1',
	],

    'email_provider' => 'smtp',

    'site_menu' => [

/*
        ####################################
        (object) [
            'name' => 'menu.on_site',
            'code' => 'index',
            'url' => '/',
            'icon' => 'icon-list',
        ],
*/

        ####################################
        (object) [
            'name' => 'menu.dashboard',
            'code' => 'dashboard',
            'url' => '/admin',
            'icon' => 'icon-plane',
        ],

        ####################################
        (object) [
            'name' => 'menu.tender',
            'code' => 'tender',
            'url' => '#',
            'icon' => 'icon-trophy',
            'items' => Array(
                (object) [
                    'code' => 'get',
                    'name' => 'menu.tender_now',
                    'url' => '/admin/tender/now',
                    'icon' => 'icon-bell',
                ],
                (object) [
                    'code' => 'mylist',
                    'name' => 'menu.tender_mylist',
                    'url' => '/admin/tender/mylist',
                    'icon' => 'icon-list',
                ],
                (object) [
                    'code' => 'archive',
                    'name' => 'menu.tender_list',
                    'url' => '/admin/tender/list',
                    'icon' => 'icon-bubbles',
                ],
                (object) [
                    'code' => 'add',
                    'name' => 'menu.tender_add',
                    'url' => '/admin/tender/add',
                    'icon' => 'fa fa-plus',
                ],
                (object) [
                    'code' => 'my-auction-list',
                    'name' => 'menu.my_delete_auction',
                    'url' => '/admin/tender/deleted-action-list',
                    'icon' => 'icon-list',
                ],
                (object) [
                    'code' => 'tender-history',
                    'name' => 'menu.tender_history',
                    'url' => '/admin/tender/history',
                    'icon' => 'icon-bubbles',
                ],


                (object) [
                    'code' => 'add-dv',
                    'name' => 'menu.tender_dv_add',
                    'url' => '/admin/tenderdv/add',
                    'icon' => 'fa fa-plus',
                ],
                (object) [
                    'code' => 'get-dv',
                    'name' => 'menu.tender_dv_now',
                    'url' => '/admin/tenderdv/now',
                    'icon' => 'icon-bell',
                ],
                (object) [
                    'code' => 'mylist-dv',
                    'name' => 'menu.tender_dv_mylist',
                    'url' => '/admin/tenderdv/mylist',
                    'icon' => 'icon-list',
                ],                
                (object) [
                    'code' => 'archive-dv',
                    'name' => 'menu.tender_dv_list',
                    'url' => '/admin/tenderdv/list',
                    'icon' => 'icon-bubbles',
                ],

            )
        ],


        ####################################
        (object) [
            'name' => 'menu.auction',
            'code' => 'auction',
            'url' => '#',
            'icon' => 'icon-call-in',
            'items' => Array(
                (object) [
                    'code' => 'get',
                    'name' => 'menu.auction_now',
                    'url' => '/admin/auction/now',
                    'icon' => 'icon-bell',
                ],
                (object) [
                    'code' => 'mylist',
                    'name' => 'menu.auction_mylist',
                    'url' => '/admin/auction/mylist',
                    'icon' => 'icon-list',
                ],
                (object) [
                    'code' => 'archive',
                    'name' => 'menu.auction_list',
                    'url' => '/admin/auction/list',
                    'icon' => 'icon-bubbles',
                ],
                (object) [
                    'code' => 'add',
                    'name' => 'menu.auction_add',
                    'url' => '/admin/auction/add',
                    'icon' => 'fa fa-plus',
                ],
            )
        ],


        ####################################
        (object) [
            'name' => 'menu.sale',
            'code' => 'sale',
            'url' => '#',
            'icon' => 'icon-bell',
            'items' => Array(
                (object) [
                    'code' => 'get',
                    'name' => 'menu.sale_now',
                    'url' => '/admin/sale/now',
                    'icon' => 'icon-bell',
                ],
                (object) [
                    'code' => 'mylist',
                    'name' => 'menu.sale_mylist',
                    'url' => '/admin/sale/mylist',
                    'icon' => 'icon-list',
                ],
                (object) [
                    'code' => 'archive',
                    'name' => 'menu.sale_list',
                    'url' => '/admin/sale/list',
                    'icon' => 'icon-bubbles',
                ],
                (object) [
                    'code' => 'add',
                    'name' => 'menu.sale_add',
                    'url' => '/admin/sale/add',
                    'icon' => 'fa fa-plus',
                ],
            )
        ],



        /*
                (object) [
                    'name' => 'menu.requester',
                    'code' => 'requester',
                    'url' => '#',
                    'icon' => 'icon-call-in',
                    'items' => Array(
                        (object) [
                            'code' => 'get',
                            'name' => 'menu.requester_now',
                            'url' => '/admin/requester/now',
                            'icon' => 'icon-bell',
                        ],
                        (object) [
                            'code' => 'archive',
                            'name' => 'menu.requester_list',
                            'url' => '/admin/requester/list',
                            'icon' => 'icon-bubbles',
                        ],
                        (object) [
                            'code' => 'add',
                            'name' => 'menu.requester_add',
                            'url' => '/admin/requester/add',
                            'icon' => 'fa fa-plus',
                        ],
                    )
                ],


                ####################################
                (object) [
                    'name' => 'menu.orderers',
                    'code' => 'orderer',
                    'url' => '#',
                    'icon' => 'icon-pin',
                    'items' => Array(
                        (object) [
                            'name' => 'menu.orderers_now',
                            'url' => '/admin/orderer/now',
                            'icon' => 'icon-list',
                        ],
                        (object) [
                            'name' => 'menu.orderers_calendar',
                            'url' => '/admin/orderer/calendar',
                            'icon' => 'icon-calendar',
                        ],
                        (object) [
                            'name' => 'menu.orderers_list',
                            'url' => '/admin/orderer/list',
                            'icon' => 'icon-lock',
                        ],
                        (object) [
                            'name' => 'menu.orderers_add',
                            'url' => '/admin/orderer/add',
                            'icon' => 'fa fa-plus',
                        ],
                    )
                ],
        */
        ####################################
        (object) [
            'name' => 'menu.customers',
            'code' => 'customer',
            'url' => '#',
            'icon' => 'icon-users',
            'items' => Array(
/*
                (object) [
                    'name' => 'menu.customers_groups',
                    'url' => '/admin/customer/groups',
                    'icon' => 'icon-tag',
                ],
*/
                (object) [
                    'name' => 'menu.customers_list_new',
                    'url' => '/admin/customer/list_new',
                    'icon' => 'icon-bell',
                ],

                (object) [
                    'name' => 'menu.customers_list',
                    'url' => '/admin/customer/list',
                    'icon' => 'icon-list',
                ],
                (object) [
                    'name' => 'menu.customers_archive',
                    'url' => '/admin/customer/archive',
                    'icon' => 'icon-lock',
                ],
/*                (object) [
                    'name' => 'menu.customers_add',
                    'url' => '/admin/customer/add',
                    'icon' => 'fa fa-plus',
                ],*/
            )
        ],

        ####################################
        (object) [
            'name' => 'menu.directory_people',
            'code' => 'people',
            'url' => '#',
            'icon' => 'icon-book-open',
            'items' => Array(
                (object) [
                    'name' => 'menu.directory_people_list_new',
                    'url' => '/admin/directory/people_new',
                    'icon' => 'icon-bell',
                ],
                (object) [
                    'name' => 'menu.directory_people_list',
                    'url' => '/admin/directory/people',
                    'icon' => 'icon-list',
                ],
                (object) [
                    'name' => 'menu.directory_people_archive',
                    'url' => '/admin/directory/people_archive',
                    'icon' => 'icon-lock',
                ],
/*                (object) [
                    'name' => 'menu.directory_people_add',
                    'url' => '/admin/directory/add_person',
                    'icon' => 'fa fa-plus',
                ],*/
            )
        ],
/*
        ####################################
        (object) [
            'name' => 'menu.directory_firms',
            'code' => 'firms',
            'url' => '#',
            'icon' => 'icon-key',
            'items' => Array(
                (object) [
                    'name' => 'menu.directory_firms_list',
                    'url' => '/admin/directory/firms',
                    'icon' => 'icon-list',
                ],
                (object) [
                    'name' => 'menu.directory_firms_archive',
                    'url' => '/admin/directory/firms_archive',
                    'icon' => 'icon-lock',
                ],
                (object) [
                    'name' => 'menu.directory_firms_add',
                    'url' => '/admin/directory/add_firm',
                    'icon' => 'fa fa-plus',
                ],
            )
        ],



        ####################################
        (object) [
            'name' => 'menu.promoters',
            'code' => 'promoters',
            'url' => '#',
            'icon' => 'icon-book-open',
            'items' => Array(
                (object) [
                    'name' => 'menu.promoters_list',
                    'url' => '/admin/promoters/list',
                    'icon' => 'icon-list',
                ],
                (object) [
                    'name' => 'menu.promoters_archive',
                    'url' => '/admin/promoters/archive',
                    'icon' => 'icon-lock',
                ],
                (object) [
                    'name' => 'menu.promoters_new',
                    'url' => '/admin/promoters/new',
                    'icon' => 'fa fa-plus',
                ],
            )
        ],

        ####################################
        (object) [
            'name' => 'menu.billing',
            'code' => 'finances',
            'url' => '#',
            'icon' => 'icon-badge',
            'items' => Array(
                (object) [
                    'name' => "menu.billing_pay",
                    'url' => '/admin/billing/pay',
                    'icon' => 'icon-credit-card'
                ],
                (object) [
                    'name' => "menu.billing_history",
                    'url' => '/admin/billing/history',
                    'icon' => 'icon-list'
                ],
                (object) [
                    'name' => "menu.subscriptions_history",
                    'url' => '/admin/billing/subscriptions_history',
                    'icon' => 'icon-wallet'
                ],
                (object) [
                    'name' => "menu.billing_create",
                    'url' => '/admin/billing/create',
                    'icon' => 'fa fa-plus'
                ],
                (object) [
                    'name' => "menu.billing_create_payout",
                    'url' => '/admin/billing/create_payout',
                    'icon' => 'fa fa-minus'
                ],
            ),
        ],
*/



/*
        ####################################
        (object) [
            'name' => 'menu.templater',
            'code' => 'templater',
            'url' => '#',
            'icon' => 'icon-docs',
            'items' => Array(
                (object) [
                    'name' => 'menu.templater_add',
                    'url' => '/admin/templater/add',
                    'icon' => 'fa fa-plus',
                ],
                (object) [
                    'name' => 'menu.templater_list',
                    'url' => '/admin/templater/list',
                    'icon' => 'icon-list',
                ],
            ),
        ],
*/


        //####################################
        /*
        (object) [
            'name' => "menu.afillater",
            'code' => 'partnership',
            'url' => '#',
            'icon' => 'icon-link',
            'items' => Array(
                (object) [
                    'name' => 'menu.afillater_invite',
                    'url' => '/admin/afillater/invite',
                    'icon' => 'icon-link',
                ],
                (object) [
                    'name' => 'menu.afillater_partnership',
                    'url' => '/admin/afillater/partnership',
                    'icon' => 'icon-trophy',
                ],
            ),
        ],
        */
        (object) [
            'name' => "menu.afillater",
            'code' => 'partnership',
            'url' => '/admin/afillater/invite',
            'icon' => 'icon-link',
        ],


        ####################################
        (object) [
            'name' => 'menu.support_service',
            'code' => 'support',
            'url' => '#',
            'icon' => 'icon-earphones',
            'items' => Array(
                (object) [
                    'name' => 'menu.support_panel',
                    'url' => '/tickets-admin',
                    'icon' => 'icon-flag',
                ],
                (object) [
                    'name' => 'menu.support_mytickets',
                    'url' => '/admin/helpdesk',
                    'icon' => 'icon-eye',
                ],
                (object) [
                    'name' => 'menu.support_newtickets',
                    'url' => '/admin/helpdesk/create',
                    'icon' => 'fa fa-plus',
                ],
            ),
        ],
        (object) [
            'name' => 'menu.news',
            'code' => 'news',
            'url' => '#',
            'icon' => 'icon-earphones',
            'items' => Array(
                (object) [
                    'name' => 'menu.news_all',
                    'url' => '/admin/new-news',
                    'icon' => 'icon-eye',
                ],
                (object) [
                    'name' => 'menu.news_create',
                    'url' => '/admin/new-news/0',
                    'icon' => 'fa fa-plus',
                ],
            ),
        ],






/*
        ####################################
        (object) [
            'name' => 'menu.inform',
            'code' => 'inform',
            'url' => '#',
            'icon' => 'icon-info',
            'items' => Array(
                (object) [
                    'name' => "menu.news",
                    'url' => '/admin/news',
                    'icon' => 'icon-eyeglasses'
                ],
                (object) [
                    'name' => "menu.support_faq",
                    'url' => '/admin/support/faq',
                    'icon' => 'icon-question'
                ],
                (object) [
                    'name' => "menu.support_learning",
                    'url' => '/admin/support/learning',
                    'icon' => 'icon-book-open'
                ],
            ),
        ],
*/







/*
        ####################################
        (object) [
            'name' => 'menu.reports',
            'code' => 'reports',
            'url' => '#',
            'icon' => 'icon-docs',
            'items' => Array(
                (object) [
                    'name' => 'menu.reports_promoters',
                    'url' => '/admin/reports/promoters',
                    'icon' => 'icon-user',
                ],
                (object) [
                    'name' => "menu.reports_operators",
                    'url' => '/admin/reports/operators',
                    'icon' => 'icon-user'
                ],
                (object) [
                    'name' => "menu.reports_managers",
                    'url' => '/admin/reports/managers',
                    'icon' => 'icon-user'
                ],
                (object) [
                    'name' => "menu.reports_lids",
                    'url' => '/admin/reports/lids',
                    'icon' => 'icon-doc'
                ],
                (object) [
                    'name' => "menu.reports_global",
                    'url' => '/admin/reports/global',
                    'icon' => 'icon-doc'
                ],
            ),
        ],
*/
        ####################################
        (object) [
            'name' => 'menu.configer',
            'code' => 'configer',
            'url' => '#',
            'icon' => 'icon-wrench',
            'items' => Array(
                (object) [
                    'name' => 'menu.configer_roles',
                    'url' => '/admin/configer/roles',
                    'icon' => 'icon-tag',
                ],
                (object) [
                    'name' => "menu.configer_users",
                    'url' => '/admin/configer/users',
                    'icon' => 'icon-anchor'
                ],
                (object) [
                    'name' => "menu.configer_users_archive",
                    'url' => '/admin/configer/users_archive',
                    'icon' => 'icon-lock'
                ],
                (object) [
                    'name' => "menu.configer_subdivisions",
                    'url' => '/admin/configer/subdivisions',
                    'icon' => 'icon-book-open'
                ],
                (object) [
                    'name' => "menu.configer_drugs",
                    'url' => '/admin/configer/drugs',
                    'icon' => 'icon-list'
                ],
                (object) [
                    'name' => "menu.configer_sms",
                    'url' => '/admin/configer/sms_api',
                    'icon' => 'icon-wrench'
                ],
                (object) [
                    'name' => "menu.configer_messages",
                    'url' => '/admin/messages/list',
                    'icon' => 'icon-list'
                ],
            ),
        ],

        ####################################
        (object) [
            'name' => 'menu.personal_settings',
            'code' => 'settings',
            'url' => '#',
            'icon' => 'icon-user',
            'items' => Array(
                (object) [
                    'name' => 'menu.personal_settings_profile',
                    'url' => '/admin/settings/personal',
                    'icon' => 'icon-wrench',
                ],
                (object) [
                    'name' => 'menu.exit',
                    'url' => '/auth/logout',
                    'icon' => 'icon-key',
                ],
            ),
        ],

        ####################################
        (object) [
            'name' => 'menu.personal_review',
            'code' => 'review',
            'url' => '/admin/personal/review',
            'icon' => 'icon-list'
        ],
    ],

];
