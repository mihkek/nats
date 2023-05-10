<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8"/>
	<title>Распродажи - Национальная Аграрная Тендерная Система (НАТС)</title>
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

	<link href="/css/vuetify.min.css" rel="stylesheet" type="text/css"/>
	<style>
	body {
	  background: #f1f1f1;
	}
	#app {
		min-height: 100vh;
	}
	</style>
</head>
<body>
<div id="app">
	@if (Auth::id() > 0) 
		<index_sales :user_id="{{Auth::id()}}">
	@else 
		<index_sales :user_id="0">
	@endif
</div>

<style>
	@media screen and (max-width: 600px) {
		.btn600 {
			margin-top: -160px;
		}
	}
	@media screen and (min-width: 600px) {
		.btn600 {
			margin-top: -140px;
		}
	}
</style>

<script type="text/javascript" src="/js/lang.js"></script>
<script>
  Lang.setLocale(document.querySelector('meta[property="lang"]').getAttribute('content'));
  window.__ = (key) => Lang.get(key);
</script>
<script src="{{ asset('/main.js') }}"></script>
<script type="text/javascript" src="/js/admin_jquery.js"></script>
<script type="text/javascript" src="/js/admin_bootstrap.js"></script>



@include('counter.counter')

@include('form.form')

</body>
</html>