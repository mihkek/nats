<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js"> <!--<![endif]--><head>
    <meta charset="utf-8"/>
    <title>Вход</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <link href="/css/vuetify.min.css" rel="stylesheet" type="text/css"/>

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
		<img src="{{ Config('global.logo_login.img') }}" alt="" style="
		@if(Config('global.logo_login.width')) width: {{ Config('global.logo_login.width') }}; @endif
		@if(Config('global.logo_login.height')) height: {{ Config('global.logo_login.height') }}; @endif
		">
	</div>
@endif

<div id="app" style="background: transparent !important;">
		<promoter_go/>
	</div>

<!-- <div class="content page-auth"  style="width:auto; max-width:420px;">
	
</div> -->


<script type="text/javascript" src="/js/lang.js"></script>
<script>
  Lang.setLocale(document.querySelector('meta[property="lang"]').getAttribute('content'));
  window.__ = (key) => Lang.get(key);
</script>
<script src="{{ asset('/main.js') }}"></script>
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
</body>
</html>
