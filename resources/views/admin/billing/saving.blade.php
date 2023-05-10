@section('title', 'Экономить')
@extends('admin.template')

@section('main')




<link rel="stylesheet" type="text/css" href="/css/public_typography.css" />
<link rel="stylesheet" type="text/css" href="/css/public_shortcodes/shortcodes.css" />
<link rel="stylesheet" type="text/css" href="/css/public_colors.css" />





<div class="page-content-wrapper">
<div class="page-content">
<div class="alert-area"></div>









<!--{{--############################# ТАРИФЫ ######################################--}}-->
		<div class="row">

              <div class="col-lg-6 col-md-6 mb-60">
                <ul class="price active" style="border: 1px solid #cccccc;">
                  <li class="header">КАРТА</li>
                  <li class="subheader">
				<span class="vista-box vista-box-md"><span class="left">VISTA</span><span class="right vista-standart-bg">STANDARD</span></span>
			</li>
                  <li>Стоимость <span class="vista-box vista-box-sm">0&nbsp;рублей</span></li>
                  <li>Гарантированный кэшбэк с покупок в магазинахпартнерах</li>
                  <li>Бонус за привлеченных пользователей <span class="vista-box vista-box-sm">10%</span> от их кэшбэка</li>
                  <li class="blue">
				@if ($tariffs[$user->tariff]['level'] > 1)
				<a href="/admin/billing/cards" class="button" style="background-color:#999999; border:0px;">Тариф недоступен</a>
				@elseif ($user->tariff == 'STANDARD')
				<a href="/admin/billing/cards" class="button" style="background-color:#666666; border:0px;">Действующий сейчас тариф</a>
				@else
				<a href="/admin/billing/order?tariff=STANDARD" class="button">Приобрести</a>
				@endif
			</li>
                </ul>
              </div>

              <div class="col-lg-6 col-md-6 mb-60">
                <ul class="price active" style="border: 1px solid #cccccc;">
                  <li class="header">КАРТА</li>
                  <li class="subheader">
				<span class="vista-box vista-box-md"><span class="left">VISTA</span><span class="right vista-gold-bg">GOLD</span></span>
			</li>
                  <li>Стоимость <span class="vista-box vista-box-sm">300&nbsp;рублей</span></li>
                  <li>Кэшбэк за личные покупки <span class="vista-box vista-box-sm">в&nbsp;2&nbsp;раза</span> больше по сравнению с картой
			<span class="vista-box vista-box-sm"><span class="left">VISTA</span><span class="right vista-standart-bg">STANDARD</span></span>
			</li>
                  <li>Отчисления от кэшбэка приглашенных вами пользователей <span class="vista-box vista-box-sm">20%</span></li>
                  <li>За каждую проданную вами карту 
			<span class="vista-box vista-box-sm"><span class="left">VISTA</span><span class="right vista-gold-bg">GOLD</span></span>
			ваш личный бонус <span class="vista-box vista-box-sm">100&nbsp;руб</span></li>
                  <li class="blue">
				@if ($tariffs[$user->tariff]['level'] > 2)
				<a href="/admin/billing/cards" class="button" style="background-color:#999999; border:0px;">Тариф недоступен</a>
				@elseif ($user->tariff == 'GOLD')
				<a href="/admin/billing/cards" class="button" style="background-color:#666666; border:0px;">Действующий сейчас тариф</a>
				@else
				<a href="/admin/billing/order?tariff=GOLD" class="button">Приобрести</a>
				@endif
			</li>
                </ul>
              </div>

          </div>
<!--{{--############################# /// ТАРИФЫ ######################################--}}-->








</div>
</div>
@endsection
