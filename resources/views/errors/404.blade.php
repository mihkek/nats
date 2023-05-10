<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8"/>
	<title>Страница не найдена...</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content=" " />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta content="{{ \Illuminate\Support\Facades\App::getLocale() }}" property="lang" />
    <meta content="{{ csrf_token() }}" name="csrf-token"/>
    <meta content="{{ Auth::user()->api_token ?? '' }}" name="api_token" />
    <meta content="{{ Route::currentRouteName() ?? '' }}" name="route_name" />


    <link href="/css/vuetify.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_login.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_app.css" rel="stylesheet" type="text/css"/>
	<style>
	body {
	  background: #f1f1f1;
	}
	#app {
		min-height: 100vh;
	}

	.error-page {
		text-align: center;
	}
	</style>

</head>
<body style="background-color: #fff">


<div id="app-error" >
	<div class="error-page">
		 <br><br>
@if(Config('global.logo_login.img'))
	<div class="logo">
        <a href="/">
		<img src="{{ Config('global.logo_login.img') }}" alt="" style="
		@if(Config('global.logo_login.width')) width: {{ Config('global.logo_login.width') }}; @endif
		@if(Config('global.logo_login.height')) height: {{ Config('global.logo_login.height') }}; @endif
		">
        </a>
    </div>
@endif
  		   <br><br>

		<h1 class="title">Страница не найдена...</h1>
		 <br><br>
		<div style="width: 250px; margin: 0px auto;"><a href="/"><button class="btn blue uppercase" style="width: 100%; height: 43px;">на главную</button></a></div>

	</div>
</div>


<script type="text/javascript" src="/js/lang.js"></script>
<script>
  Lang.setLocale(document.querySelector('meta[property="lang"]').getAttribute('content'));
  window.__ = (key) => Lang.get(key);
</script>
<script src="{{ asset('/main.js') }}"></script>

</body>
</html>



