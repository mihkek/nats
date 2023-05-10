<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8"/>
	<title>Национальная Аграрная Тендерная Система (НАТС) – Работаем по РФ</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content=" " />
	<meta name="description" content="@yield('description','«Национальная Аграрная Тендерная Система» позволяет Покупателям со своего компьютера провести online торги, ознакомиться с предложениями многочисленных независимых поставщиков и заказать все необходимые средства защиты растений по самой лучшей цене.')" />
	<meta name="author" content="mrnx.ru">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta content="{{ \Illuminate\Support\Facades\App::getLocale() }}" property="lang" />
    <meta content="{{ csrf_token() }}" name="csrf-token"/>
    <meta content="{{ Auth::user()->api_token ?? '' }}" name="api_token" />
    <meta content="{{ Route::currentRouteName() ?? '' }}" name="route_name" />
    <meta name="yandex-verification" content="9fb2f3311df93aff" />
    <meta name="google-site-verification" content="C0k9z2B0cywHNg7OelHkwSdC7E5ocH9IZzYvLIT9Lmo" />

	<link href="/css/admin_bootstrap.css" rel="stylesheet" type="text/css"/>
	<link href="/css/admin_fonts.css" rel="stylesheet" type="text/css"/>

	<!--<link href="/css/vuetify.min.css" rel="stylesheet" type="text/css"/>-->
	<style>
	body {
	  background: #f1f1f1;
	}
	#app {
		min-height: 100vh;
	}
	</style>
	<link href="/js/swiper/swiper.min.css" rel="stylesheet" />
	<script src="/js/swiper/swiper.min.js"></script>

</head>
<body>
<div id="app">
	@if (Auth::id() > 0) 
		<index :user_id="{{Auth::id()}}">
	@else 
		<index :user_id="0">
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

<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(76337959, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/76337959" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-SR8K5N6LKV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-SR8K5N6LKV');
</script>
<script src="/js/gsap.min.js"></script>
<!-- WWW -->


<!--{{-- Modal Обратный звонок --}}-->
<div class="modal fade" id="CallMe" tabindex="-1" role="dialog" aria-labelledby="CallMeLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="CallMeLabel">Обратный звонок</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="recipient" class="col-form-label">Ваше имя:</label>
						<input type="text" class="form-control" id="recipient" name="recipient">
					</div>
					<div class="form-group">
						<label for="phone" class="col-form-label">Номер телефона:</label>
						<input type="text" class="form-control" id="phone" name="phone">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>-->
				<button type="button" class="btn btn-primary success" onclick="CallMe();" style="background-color: lightgreen;">Заказать звонок</button>
			</div>
		</div>
	</div>
</div>


<script src="/js/jquery.maskedinput.min.js"></script>
<script>
	function CallMe() {
		console.log('отправили запрос');

		$.ajax({
			method: "get",
			url: "/callme",
			data: {
				recipient: $("#recipient").val(),
				phone: $("#phone").val()
			},
			success: function (result) {
				console.log('запрос успешно ушел:' + result);
				$("#recipient").val('');
				$("#phone").val('');
			},
			error: function (result) {
				console.log('ошибка');
				console.log(result);
			}
		});

		$("#CallMe").modal('hide');

	}
	$('#phone').mask("+7 (999) 999-99-99");
</script>

</body>
</html>