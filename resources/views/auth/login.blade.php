<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js"> <!--<![endif]--><head>
    <meta charset="utf-8"/>
    <title>Вход</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta content="{{ \Illuminate\Support\Facades\App::getLocale() }}" property="lang" />
    <meta content="{{ csrf_token() }}" name="csrf-token"/>
    <link rel="shortcut icon" href="/favicon.ico"/>

    <link href="/css/admin_bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_jquery.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_fonts.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_app.css" rel="stylesheet" type="text/css"/>
    <link href="/css/admin_login.css" rel="stylesheet" type="text/css"/>


</head>
<body class="login" style="
@if(Config('global.logo_login.color_bg'))
background-color: {{ Config('global.logo_login.color_bg') }};
@endif
@if(Config('global.logo_login.img_bg'))
background-image: url('{{ Config('global.logo_login.img_bg') }}'); background-position: center center; background-repeat: no-repeat;
@endif
"
>


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














<div class="content page-auth"  style="width:auto; max-width:550px;">






{{--
<h2 class="text-center"><b>Внимание! Идёт перепрограммирование авторизации в системе - возможны ошибки, или может иногда не пускать внутрь по рабочим паролям - просьба не волноваться.</b></h2>
--}}

<!--{{--#################### СООБЩЕНИЯ-ОШИБКИ ################--}}-->
    @if(Request::has('needconfirm'))
        <div class="alert alert-danger text-center" style="margin-top:20px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <b>Требуется подтверждение!</b><br><br>
            Мы отправили на ваш e-mail письмо, содержащее ссылку для подтверждения. Пожалуйста нажмите на неё.<br><br>
            Если вы вдруг не найдёте письмо в своей почте, обязательно проверьте папку "СПАМ" или "Нежелательная почта", письмо может оказаться там
        </div>
    @endif

    @if(Request::has('needconfirmsms'))
        <div class="alert alert-danger text-center" style="margin-top:20px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <b>
                Мы только что отправили на&nbsp;телефон
                <span style="white-space:nowrap;"> @if(Session::has('phone')) {{ Session::get('phone') }} @endif </span>
                сообщение с&nbsp;коротким паролем.
            </b><br><br>
            Если этот телефон был указан правильно, то <nowrap>SMS-сообщение</nowrap> обязательно должно быть доставлено в ближайшие пару минут.<br><br>
            После входа мы рекомендуем сразу же сменить пароль на любой удобный и запоминающийся.<br><br>
<!--
			@if(Session::has('phone') && preg_match("/\((901|902|904|908|910|911|912|913|914|915|916|917|918|919|950|978|980|981|982|983|984|985|986|987|988|989)\)/",Session::get('phone')))
				<hr>
				<b>Внимение, СМС на&nbsp;номера МТС временно&nbsp;не&nbsp;доставляются.</b><br>Для получения пароля свяжитесь с&nbsp;нами по&nbsp;телефону <nobr><a href="tel:+74991120811">8 (499) 112-08-11</a></nobr> или напишите на&nbsp;<a href="mailto:info@agtender.com">info@agtender.com</a>
        	@endif
-->
        </div>
    @endif

    @if(Request::has('needconfirmsupplier'))
        <div class="alert alert-info text-center" style="margin-top:20px;">
            <b>Данные поставщика приняты и&nbsp;переданы на&nbsp;проверку</b><br><br>
            Как только данные организации будут подтверждены, мы&nbsp;немедленно оповестим вас об&nbsp;этом.<br><br>
            Пожалуйста, дождитесь сообщения с результатами проверки, обычно обработка данных занимает один рабочий день.
        </div>
    @endif
   
    @if(Request::has('notfoundconfirm'))
        <div class="alert alert-danger text-center" style="margin-top:20px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <b>Внимание!</b>
            Ваша ссылка для подтверждения уже устарела, либо повредилась в процессе копирования.<br><br>
            Пожалуйста сделай новый <a href="javascript:;" class="button-forget alert-link" style="text-decoration:underline;">сброс пароля</a>
        </div>
    @endif

    @if(Request::has('confirmedbefore'))
        <div class="alert alert-danger text-center" style="margin-top:20px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <b>Внимание!</b>
            Ваш адрес e-mail уже был подтверждён ранее и не требует повторного подвтерждения.<br><br>
            Если вы забыли пароль, то можете воспользоваться <a href="javascript:;" class="button-forget alert-link" style="text-decoration:underline;">сбросом пароля</a>
        </div>
    @endif

    @if(Request::has('confirmed'))
        <div class="alert alert-danger text-center" style="margin-top:20px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <b>Поздравляем с успешной регистрацией!</b>
            На ваш e-mail только что был выслан пароль.<br><br>
            Если вы не найдёте письмо в своей почте, обязательно проверь папку "СПАМ" или "Нежелательная почта", письмо может оказаться там
        </div>
    @endif

    @if(Request::has('reminded'))
        <div class="alert alert-danger text-center" style="margin-top:20px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <b>Внимание!</b>
            На ваш e-mail только что было отправлено письмо с новым паролем.<br><br>
            Если вы вдруг не найдёте письмо в своей почте, обязательно проверь папку "СПАМ" или "Нежелательная почта", письмо может оказаться там
        </div>
    @endif






<!--{{--#################### ВСЕ ОСТАЛЬНЫЕ ЛОГИНЫ-ПАРОЛИ ################--}}-->

   	@if(Request::has('needconfirmsupplier'))
    
		@if( Config('auth.global.registration') )
        <div class="create-account" style="background-color: #607D8B;">
            <p>
                <a href="/" class="uppercase ">Вернуться на главную</a>
            </p>
        </div>
		@endif

    @else
    <form class="form-horizontal login-form" action="/auth/login" method="post" id="formLogin" name="formLogin">
        {{ csrf_field() }}
{{--        <input type="hidden" name="_back" value="/admin/281/site/settings.html"/> --}}

        <h3 class="font-blue">ВХОД</h3>
		<br>

        <div class="form-group">
            <label class="col-md-4 control-label">E-mail/Телефон<br>(+7 495 000 11 22) <span class="font-red-mint">*</span></label>
            <div class="col-md-8">
                <div class="input-icon"><i class="fa fa-envelope"></i>
                    <input class="form-control" autocomplete="on" name="email" type="text"/>
                </div>
                <label class="help-inline help-small no-left-padding hidden error"></label>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Пароль <span class="font-red-mint">*</span></label>
            <div class="col-md-8">
                <div class="input-icon"><i class="fa fa-key"></i>
                    <input class="form-control" autocomplete="off" name="password" type="password"/>
                </div>
                <label class="help-inline help-small no-left-padding hidden error"></label>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" style="padding-top:0px;">
				<a href="javascript:;" class="button-forget" id="reminderActivate">Сбросить пароль?</a>
				<span class="visible-xs"><br></span>
			</label>
            <div class="col-md-8">
				<button type="submit" class="btn blue uppercase" style="width:100%; height:43px;">Вход</button>
            </div>
        </div>

	  <br>

		@if( Config('auth.global.registration') )
        <div class="create-account" style="background-color: #607D8B;">
            <p>
                <a href="/registration" class="uppercase ">Регистрация <span class="hidden-xs">нового пользователя</span></a>
            </p>
        </div>
		@endif
    </form>
	@endif










@if( Config('auth.global.registration') )
    <form class="form-horizontal register-form" action="/auth/register" method="post" id="formRegister" name="formRegister">
        {{ csrf_field() }}

        <h3 class="font-blue">РЕГИСТРАЦИЯ</h3>
		<br>

        <div class="form-group">
            <label class="col-md-4 control-label">Ваше имя <span class="font-red-mint">*</span></label>
            <div class="col-md-8">
                <div class="input-icon"><i class="fa fa-user"></i>
                    <input class="form-control" autocomplete="off" name="name" type="text" placeholder="Введите ваше имя"/>
                </div>
                <label class="help-inline help-small no-left-padding hidden error"></label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Ваш E-mail <span class="font-red-mint">*</span></label>
            <div class="col-md-8">
                <div class="input-icon"><i class="fa fa-envelope"></i>
                    <input class="form-control" autocomplete="off" name="email" type="email" placeholder="Введите E-mail"/>
                </div>
                <label class="help-inline help-small no-left-padding hidden error"></label>
            </div>
        </div>

        {{--
        <div class="form-group">
            <label class="col-md-4 control-label">Кто пригласил?</label>
            <div class="col-md-8">
                <div class="input-icon"><i class="fa fa-phone"></i>
                    <input class="form-control" autocomplete="off" name="phone_afillate" type="phone" value="" placeholder="Телефон пригласившего" maxlength="18"/>
                </div>
                <label class="help-inline help-small no-left-padding hidden error"></label>
            </div>
        </div>
        --}}
        <input name="phone_afillate" type="hidden" value=""/>

         <div class="form-group">
            <label class="col-md-4 control-label">&nbsp;</label>
            <div class="col-md-8">
                <div class="input-icon">
                    <label><input type="checkbox" name="oferta" value="on">
                        Я принимаю <a href="/oferta" target="_blank">договор оферты</a>
                        <span class="font-red-mint">*</span></label>
                </div>
                <label class="help-inline help-small no-left-padding hidden error"></label>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">&nbsp;</label>
            <div class="col-md-8" style="padding-left:12px;">
            	<button type="submit" id="register-submit-btn" class="btn blue uppercase" style="width:100%; height:43px;">Регистрация</button>
            </div>
        </div>

	  <br>

        <div class="create-account clearfix">
            <p>
                <a href="/login" class="uppercase button-login">Вход <span class="hidden-xs">с логином и паролем</span></a>
            </p>
        </div>
    </form>
@endif












    <form class="form-horizontal forget-form" action="/auth/reminder" method="post" id="formRemindPassword" name="formRemindPassword">
        {{ csrf_field() }}

        <h3 class="form-title font-blue">СБРОСИТЬ ПАРОЛЬ</h3>
        <p>Введите свой e-mail, на него будет отправлено письмо с новым паролем</p>

        <div class="form-group">
            <label class="col-md-4 control-label">E-mail <span class="font-red-mint">*</span></label>
            <div class="col-md-8">
                <div class="input-icon"><i class="fa fa-envelope"></i>
                    <input class="form-control" autocomplete="off" placeholder="Email" name="email" type="email"/>
					<label class="help-inline help-small no-left-padding error hidden" id="reminderError"></label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">&nbsp;</label>
            <div class="col-md-8">
				<button type="submit" class="btn blue uppercase" style="width:100%; height:43px;">ОТПРАВИТЬ</button>
            </div>
        </div>

		<br>
        <div class="create-account clearfix" style="background-color: #607D8B;">
            <p>
                <a href="/login" class="uppercase button-login">Вход <span class="hidden-xs">с логином и паролем</span></a>
            </p>
        </div>
@if( Config('auth.global.registration') )
        <div class="create-account" style="background-color: #607D8B;">
            <p>
                <a href="/registration" class="uppercase">Регистрация <span class="hidden-xs">нового пользователя</span></a>
            </p>
        </div>
@endif
    </form>





</div>






<!-- <div class="page-auth"  style="width:auto; padding: 30px; margin: 0 auto; max-width:550px; ">
        <div class="form-group" style="color:#ffffff;">
            <label class="col-md-12 control-label text-center">
			<b>Или быстро войти без пароля</b> с помощью одной из соцсетей
		</label>
            <div class="col-md-12 text-center">
			<div id="uLogin" data-ulogin="display=panel;theme=flat;sort=default;lang=ru;mobilebuttons=1;
			fields=email;
			optional=first_name,last_name,bdate,sex,phone,photo_big,city,country;
			providers=vkontakte,odnoklassniki,yandex,google,liveid,facebook,instagram;
{{--
			providers=vkontakte,odnoklassniki,mailru,yandex,livejournal,
			google,googleplus,liveid,facebook,twitter,flickr,instagram,tumblr,vimeo,uid,webmoney,foursquare,
			youtube,lastfm,soundcloud,wargaming,steam,openid;
--}}
			hidden=none;
			redirect_uri={{ urlencode('https://' . $_SERVER['HTTP_HOST']) }}/ulogin;"></div>
            </div>
        </div>
</div> -->
<br><br><br>





</div>



<script type="text/javascript" src="/js/lang.js"></script>
<script>
  Lang.setLocale(document.querySelector('meta[property="lang"]').getAttribute('content'));
  window.__ = (key) => Lang.get(key);
</script>
<script src="/js/admin_jquery.js"></script>
<script src="/js/admin_bootstrap.js"></script>
<script src="/js/admin_app.js"></script>

<script src="/js/jquery.mask.min.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {
	jQuery(function() {
		jQuery( "input[name$='phone_afillate']" ).mask("+0 (000) 000-00-00", {
			placeholder: "",
		});
	});
});
</script>

@if(isset($reg)) 
<script>
	jQuery('#regActivate').click(); 
</script>
@endif

@if(isset($reminder)) 
<script>
	jQuery('#reminderActivate').click(); 
</script>
@endif

<script src="//ulogin.ru/js/ulogin.js"></script>

<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(76337959, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/76337959" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

</body>
</html>
