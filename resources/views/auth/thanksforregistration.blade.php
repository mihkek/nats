<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js"> <!--<![endif]--><head>
    <meta charset="utf-8"/>
    <title>Спасибо за регистрацию</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta content="{{ \Illuminate\Support\Facades\App::getLocale() }}" property="lang" />
    <meta content="{{ csrf_token() }}" name="csrf-token"/>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <link href="/css/vuetify.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_login.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_app.css" rel="stylesheet" type="text/css"/>

</head>
<body class="login" style="background-color: #fff">
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

  <div id="app" style="background-color: transparent !important; text-align: center;">
      <h1>СПАСИБО ЗА РЕГИСТРАЦИЮ</h1>
      <br />
      <h3>ПРИЯТНОГО ПОЛЬЗОВАНИЯ НАШИМ СЕРВИСОМ</h3>
      <br />
      <h3>ТЕХНИЧЕСКАЯ ПОДДЕРЖКА: <a href="tel:+74951286771">+7 (495) 128-67-71</a></h3>

      <div class="alert alert-danger text-center" style="margin-top:20px;">            
            <b>
                Мы только что отправили на&nbsp;телефон сообщение с&nbsp;коротким паролем.
            </b><br><br>
            Если этот телефон был указан правильно, то <nowrap>SMS-сообщение</nowrap> обязательно должно быть доставлено в ближайшие пару минут.<br><br>
            После входа мы рекомендуем сразу же сменить пароль на любой удобный и запоминающийся.<br><br>
        </div>

      <div style="width: 250px; margin: 0 auto;">
        <a href="/login?needconfirmsms"><button class="btn blue uppercase" style="width:100%; height:43px;">Вход в личный кабинет</button></a>
      </div>

	</div>


<script type="text/javascript" src="/js/lang.js"></script>
<script>
  Lang.setLocale(document.querySelector('meta[property="lang"]').getAttribute('content'));
  window.__ = (key) => Lang.get(key);
</script>
<script src="{{ asset('/main.js') }}"></script>


<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(76337959, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/76337959" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->


</body>
</html>
