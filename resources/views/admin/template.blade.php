<!DOCTYPE html>
<!--[if IE 8]>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js"> <!--<![endif]--><head>
    <meta charset="utf-8"/>

	<title>@yield('title') – Национальная Аграрная Тендерная Система (НАТС)</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta content="{{ \Illuminate\Support\Facades\App::getLocale() }}" property="lang" />
    <meta content="{{ csrf_token() }}" name="csrf-token"/>
    <meta content="{{ Auth::user()->api_token ?? '' }}" name="api_token" />
    <meta content="{{ Route::currentRouteName() ?? '' }}" name="route_name" />


	<link rel="shortcut icon" href="/favicon.png" type="image/png">

    <link href="/css/admin_bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_jquery.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_fonts.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_app.css" rel="stylesheet" type="text/css"/>
    <link href="/css/public_tariffs.css" rel="stylesheet" type="text/css" />
    <link href="/css/vuetify.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/mdi/font/css/materialdesignicons.css" rel="stylesheet" type="text/css"/>
    
    <style>
        @media (max-width: 415px) {
            .bigg {font-size:11px!important;}
        }
        @media (max-width: 376px) {
            .user_ava_box {display:none!important;}
        }
        .page-header.navbar.navbar-fixed-top {
            border-bottom: 1px solid #47484B;
            -webkit-box-shadow: 0 3px 5px 0 rgba(64,64,64,1);
            -moz-box-shadow: 0 3px 5px 0 rgba(64,64,64,1);
            box-shadow: 0 3px 5px 0 rgba(64,64,64,1);
        }
    </style>

</head>

<body class="page-header-fixed page-content-white">
<style>
    #app{
        background: #c0c0c0 !important;
    }
    #main{
        background: #c0c0c0 !important;
    }
    #vue_block{
        background: #c0c0c0 !important;
    }
    .well{
        background: transparent;
    }
</style>





    <div class="page-wrapper admin-page">
        <a name="top"></a>


        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner">

                @if(Config('global.logo_title.img'))
                    <div class="page-logo">
                        <a href="/admin"><img src="{{ Config('global.logo_title.img') }}" alt="" style="
                            @if(Config('global.logo_title.width')) width: {{ Config('global.logo_title.width') }}; @endif
                            @if(Config('global.logo_title.height')) height: {{ Config('global.logo_title.height') }}; @endif
                                    "></a>
                    </div>
                @endif

                <div class="slogan">
                    @if ($user->role_id == 1000)
                        {{ Config('global.project.title_role_1000') }}
                    @elseif ($user->role_id == 103)
                        {{ Config('global.project.title_role_103') }}
                    @elseif ($user->role_id == 102)
                        {{ Config('global.project.title_role_102') }}
                    @elseif ($user->role_id == 101)
                        {{ Config('global.project.title_role_101') }}
                    @endif
                </div>

                <a href="javascript:;" class="menu-toggler responsive-toggler btn-nvabar" data-toggle="collapse"
                   data-target=".navbar-collapse" style="margin-right:20px;">
                    <span></span>
                </a>




                <div class="top-menu @if ($impersonated) impersonated @endif">





                    {{-- АДМИН --}}
                    @if ($user->role_id == 1000)




                        <ul class="nav navbar-nav pull-right">

                            <li class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Сообщения" title="Сообщения">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <span>Сообщения</span> (<strong id="message-counter">0</strong>)
                                </a>
                                 <ul class="dropdown-menu dropdown-menu-default" id="dropdownMessages">
                                    <li><a href="/admin/messages/list_new"><i class="icon-user"></i> Новые сообщения</a></li>
                                   
                                    <li><a href="/admin/messages/list" id="buttonLogout"><i class="icon-key"></i> Все сообщения</a></li>
                                </ul>
                            </li>

                            <li class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Последние новости" title="Последние новости">
                                <a href="/admin/new-news" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <i class="icon-flag" style="font-size:18px;"></i>
                                </a>
                            </li>

                            <li class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Помощь и пддержка" title="Помощь и пддержка">
                                <a href="/admin/helpdesk" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <i class="icon-bulb" style="font-size:18px;"></i>
                                </a>
                            </li>

                            <li class="dropdown dropdown-user user_ava_box hidden-xs">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="{{ User::getAvatar($user->id, 'small') }}">
                                    <span class="username username-hide-on-mobile">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default" id="dropdownUser">
                                    <li><a href="/admin/settings/personal"><i class="icon-user"></i> Мой профиль</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/auth/logout" id="buttonLogout"><i class="icon-key"></i> Выход</a></li>
                                </ul>
                            </li>
                        </ul>


 


                        {{-- помещение --}}
                    @elseif ($user->role_id == 103)




                        <ul class="nav navbar-nav pull-right">
{{--
                            <li class="dropdown dropdown-user" data-toggle="tooltip" data-placement="bottom" data-original-title="Текущий баланс - {{ $currency[$user->currency]['Name']}}" title="Текущий баланс - {{ $currency[$user->currency]['Name']}}">
                                <a href="/admin/billing/history" class="dropdown-toggle" data-close-others="true" style="padding: 14px 8px 11px 8px;">
                                    <span class="username bigg" style="font-size:22px; font-weight:bold; padding-right:0px;">{{ floor( ($balance / $currency[$user->currency]['Value']) * $currency[$user->currency]['Nominal']  ) }}</span>
                                    <span class="username" style="padding-left:0px;">
                                        <b>{{ $user->currency }}</b>
                                    </span>
                                </a>
                            </li>
--}}

                            <li id="menu_agronomic" class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Заказать агрономическое сопровождение" title="Заказать агрономическое сопровождение" style="display:none;">
                                <a href="#" data-toggle="modal" data-target="#CallMeAgro" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <span>Заказать агрономическое сопровождение</span>
                                </a>
                            </li>


                            <li class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Последние новости" title="Последние новости">
                                <a href="/news" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <i class="icon-flag" style="font-size:18px;"></i>
                                </a>
                            </li>

                            <li class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Помощь и пддержка" title="Помощь и пддержка">
                                <a href="/admin/helpdesk" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <i class="icon-bulb" style="font-size:18px;"></i>
                                </a>
                            </li>

                            <li class="dropdown dropdown-user user_ava_box hidden-xs">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="{{ User::getAvatar($user->id, 'small') }}">
                                    <span class="username username-hide-on-mobile">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default" id="dropdownUser" style="width: auto;">
                                    <li><a href="/admin/settings/personal"><i class="icon-user"></i> Мои регистрационные данные</a></li>
                                    <li class="divider"></li>
                                    @if ($impersonated)
                                        <li><a href="/auth/relogin?back={{ request()->getUri() }}" id="buttonLogout"><i class="icon-key"></i> Вернуться в свой аккаунт</a></li>
                                    @endif
                                    <li><a href="/auth/logout" id="buttonLogout"><i class="icon-key"></i> Выход</a></li>
                                </ul>
                            </li>

                        </ul>





                        {{-- преподаватель --}}
                    @elseif ($user->role_id == 102)



                        <ul class="nav navbar-nav pull-right">
{{--
                            <li class="dropdown dropdown-user" data-toggle="tooltip" data-placement="bottom" data-original-title="Текущий баланс - {{ $currency[$user->currency]['Name']}}" title="Текущий баланс - {{ $currency[$user->currency]['Name']}}">
                                <a href="/admin/billing/history" class="dropdown-toggle" data-close-others="true" style="padding: 14px 8px 11px 8px;">
                                    <span class="username bigg" style="font-size:22px; font-weight:bold; padding-right:0px;">{{ floor( ($balance / $currency[$user->currency]['Value']) * $currency[$user->currency]['Nominal']  ) }}</span>
                                    <span class="username" style="padding-left:0px;">
                                        <b>{{ $user->currency }}</b>
                                    </span>
                                </a>
                            </li>
--}}

                            <li id="menu_agronomic" class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Заказать агрономическое сопровождение" title="Заказать агрономическое сопровождение"  style="display:none;">
                                <a href="#" data-toggle="modal" data-target="#CallMeAgro" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <span>Заказать агрономическое сопровождение</span>
                                </a>
                            </li>


                            <li class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Последние новости" title="Последние новости">
                                <a href="/news" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <i class="icon-flag" style="font-size:18px;"></i>
                                </a>
                            </li>

                            <li class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Помощь и пддержка" title="Помощь и пддержка">
                                <a href="/admin/helpdesk" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <i class="icon-bulb" style="font-size:18px;"></i>
                                </a>
                            </li>

                            <li class="dropdown dropdown-user user_ava_box hidden-xs">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="{{ User::getAvatar($user->id, 'small') }}">
                                    <span class="username username-hide-on-mobile">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default" id="dropdownUser" style="width: auto;">
                                    <li><a href="/admin/settings/personal"><i class="icon-user"></i> Мои регистрационные данные</a></li>
                                    <li class="divider"></li>
                                    @if ($impersonated)
                                        <li><a href="/auth/relogin?back={{ request()->getUri() }}" id="buttonLogout"><i class="icon-key"></i> Вернуться в свой аккаунт</a></li>
                                    @endif
                                    <li><a href="/auth/logout" id="buttonLogout"><i class="icon-key"></i> Выход</a></li>
                                </ul>
                            </li>

                        </ul>





                        {{-- ЮЗЕР --}}
                    @else




                        <ul class="nav navbar-nav pull-right">
{{--
                            <li class="dropdown dropdown-user" data-toggle="tooltip" data-placement="bottom" data-original-title="Добавить новое занятие" title="Добавить новое занятие">
                                <a href="/admin/orderer/add" class="dropdown-toggle" data-close-others="true" style="padding: 14px 8px 11px 8px;">
                                    <span class="username bigg" style="font-size:22px; font-weight:bold; padding-right:0px;">{{$user->count}}</span>
                                    <span class="username" style="padding-left:0px;">
                                        <b>занятий</b>
                                    </span>
                                </a>
                            </li>
--}}
{{--
                            <li class="dropdown dropdown-user" data-toggle="tooltip" data-placement="bottom" data-original-title="Текущий баланс - {{ $currency[$user->currency]['Name']}}" title="Текущий баланс - {{ $currency[$user->currency]['Name']}}">
                                <a href="/admin/billing/history" class="dropdown-toggle" data-close-others="true" style="padding: 14px 8px 11px 8px;">
                                    <span class="username bigg" style="font-size:22px; font-weight:bold; padding-right:0px;">{{ floor( ($balance / $currency[$user->currency]['Value']) * $currency[$user->currency]['Nominal']  ) }}</span>
                                    <span class="username" style="padding-left:0px;">
                                        <b>{{ $user->currency }}</b>
                                    </span>
                                </a>
                            </li>
--}}

                            <li id="menu_agronomic" class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Заказать агрономическое сопровождение" title="Заказать агрономическое сопровождение"  style="display:none;">
                                <a href="#" data-toggle="modal" data-target="#CallMeAgro" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <span>Заказать агрономическое сопровождение</span>
                                </a>
                            </li>

                            <li class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Последние новости" title="Последние новости">
                                <a href="/news" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <i class="icon-flag" style="font-size:18px;"></i>
                                </a>
                            </li>

                            <li class="dropdown dropdown-user hidden-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Помощь и поддержка" title="Помощь и поддержка">
                                <a href="/admin/helpdesk" class="dropdown-toggle" data-close-others="true" style="padding: 16px 8px 13px 8px;">
                                    <i class="icon-bulb" style="font-size:18px;"></i>
                                </a>
                            </li>

                            <li class="dropdown dropdown-user user_ava_box hidden-xs">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="{{ User::getAvatar($user->id, 'small') }}">
                                    <span class="username username-hide-on-mobile">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default" id="dropdownUser" style="width: auto;">

                                    <li><a href="/admin/settings/personal"><i class="icon-user"></i> Мои регистрационные данные</a></li>
                                    <li class="divider"></li>
                                    @if ($impersonated)
                                        <li><a href="/auth/relogin?back={{ request()->getUri() }}" id="buttonRelogin"><i class="icon-key"></i> Вернуться в свой аккаунт</a></li>
                                    @endif
                                    <li><a href="/auth/logout" id="buttonLogout"><i class="icon-key"></i> Выход</a></li>
                                </ul>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse hidden-xs hidden-sm" id="page-sidebar">
                    @include('admin.menu')
                    @if(Config('global.logo_sidebar.img'))
                        <div class="text-center">
                            <img src="{{ Config('global.logo_sidebar.img') }}" alt="" style="
                            @if(Config('global.logo_sidebar.width')) width: {{ Config('global.logo_sidebar.width') }}; @endif
                            @if(Config('global.logo_sidebar.height')) height: {{ Config('global.logo_sidebar.height') }}; @endif
                                    margin:12px;">
                        </div>
                    @endif
                </div>
            </div>
            @yield('main')
        </div>

        <div class="page-footer">
            <div class="page-footer-inner">
                <div class="row" style="height: 0px; ">
                    <div class="rounded-btn px-6 text-decoration-none v-btn v-btn--has-bg theme--light v-size--default success" style="background-color: red; cursor: pointer; margin-top: -65px; font-size: 10px; ">
                        <span class="v-btn__content" data-toggle="modal" data-target="#CallMe">Заказать обратный звонок</span>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-9">
                        <small>
                            &copy; 2020-2023 •
                            ООО "НАТС" •
                			105203, г. Москва, вн.тер.г. Муниципальный округ Восточное Измайлово, ул 14-я Парковая, д. 8, помещ. 1/5, офис 38 •
                			ИНН 7719723080,
                			ОГРН 1097746251096 •
                            Телефон: 7 (495) 128-67-71 •
                            Веб-сайт: <a href="https://agtender.com" style="color:#CCCCCB;" target="_blank"><u>https://agtender.com</u></a> •
                            Почта: <a href="mailto:info@agtender.com" style="color:#CCCCCB;" target="_blank"><u>info@agtender.com</u></a>
                        </small>
                    </div>
                    <div class="col-sm-3 text-right">
                        <small>
                            &copy; 2020-2023 • ООО "НАТС" ИНН 7719723080
                        </small>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div id="back-to-top"><a class="top arrow" href="#top"><i class="fa fa-angle-up"></i> <span>ВВЕРХ</span></a></div>
    <script type="text/javascript" src="/js/lang.js"></script>
    <script>
      Lang.setLocale(document.querySelector('meta[property="lang"]').getAttribute('content'));
      window.__ = (key) => Lang.get(key);
    </script>
    <script src="{{ asset('/main.js') }}"></script>
    <script type="text/javascript" src="/js/admin_jquery.js"></script>
    <script type="text/javascript" src="/js/admin_bootstrap.js"></script>

    <script type="text/javascript" src="/js/admin_app.js"></script>
    <script>
        App.menu.init( {!! $menu !!} );

        jQuery(".icon-action-undo").css('color', '#FFFFFF').next().css('font-weight', 'bold').css('color', '#FFFFFF');

        (function($){
            "use strict";
            var POTENZA = {};

            var $window = $(window), $document = $(document);

            /*************************
             Back to top
             *************************/
            POTENZA.goToTop = function () {
                var $goToTop = jQuery('#back-to-top');
                $goToTop.hide();
                $window.scroll(function(){
                    if ($window.scrollTop()>100) $goToTop.fadeIn();
                    else $goToTop.fadeOut();
                });
                $goToTop.on("click", function () {
                    jQuery('body,html').animate({scrollTop:0},1000);
                    return false;
                });
            }

            $document.ready(function () {
                POTENZA.goToTop()
            });
        })(jQuery);

    </script>
@stack('scripts')




<!--{{-- FED --}}-->  

    
@include('counter.counter')

@include('form.form')


{{-- АДМИН --}}
@if ($user->role_id == 1000)
<script src="/js/messages/admin_messages.js"></script>
@endif

<script src="/js/form/agronomic.js"></script>

</body>
</html>
