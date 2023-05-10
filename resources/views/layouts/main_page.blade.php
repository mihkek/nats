<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content=" " />
    <meta name="description" content="@yield('description')" />
    <meta name="author" content="mrnx.ru">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta content="{{ \Illuminate\Support\Facades\App::getLocale() }}" property="lang" />
    <meta content="{{ csrf_token() }}" name="csrf-token"/>
    <meta content="{{ Auth::user()->api_token ?? '' }}" name="api_token" />
    <meta content="{{ Route::currentRouteName() ?? '' }}" name="route_name" />

<link href="/css/admin_bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="/css/admin_fonts.css" rel="stylesheet" type="text/css"/>
<link href="/css/main.css" rel="stylesheet" type="text/css"/>
<link href="/css/vuetify.min.css" rel="stylesheet" type="text/css"/>
<link href="/js/swiper/swiper.min.css" rel="stylesheet" />   
<link href="/css/mdi/font/css/materialdesignicons.css" rel="stylesheet" type="text/css"/>


</head>
<body>
<!--theme--light-->

<div>
<div data-app="true" class="v-application v-application--is-ltr ">
<div class="v-application--wrap">

@include('header.header')

<div id="app">
@yield('content')
</div>

@include('footer.footer')


</div>
</div>
</div>





<script type="text/javascript" src="/js/lang.js"></script>
<script>
  Lang.setLocale(document.querySelector('meta[property="lang"]').getAttribute('content'));
  window.__ = (key) => Lang.get(key);
</script>
<script src="{{ asset('/main.js') }}"></script>
<script type="text/javascript" src="/js/admin_jquery.js"></script>
<script type="text/javascript" src="/js/admin_bootstrap.js"></script>
<script src="/js/swiper/swiper.min.js"></script>
<script type="text/javascript" src="/js/swiper/slider.js"></script>




@include('counter.counter')

@include('form.form')



</body>
</html>