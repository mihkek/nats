@section('title', 'Зарабатывать')
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

              <div class="col-lg-4 col-md-4 mb-60">
                <ul class="price active" style="border: 1px solid #cccccc;">
                  <li class="header">ПАРТНЁРСКИЙ ПАКЕТ</li>
                  <li class="subheader">
				<span class="vista-box vista-box-md"><span class="left">BUSINESS</span><span class="right vista-start-bg">START</span></span>
			</li>
                  <li>Стоимость <span class="vista-box vista-box-sm">5&nbsp;000&nbsp;рублей</span></li>
                  <li>Кэшбэк за личные покупки, <span class="vista-box vista-box-sm">в&nbsp;2&nbsp;раза</span> больше по сравнению с картой
				<span class="vista-box vista-box-sm"><span class="left">VISTA</span><span class="right vista-standart-bg">STANDARD</span></span>
			</li>
                  <li><span class="vista-box vista-box-sm">3&nbsp;уровня</span> для получения бонуса от кэшбэка привлеченных пользователей</li>
                  <li><span class="vista-box vista-box-sm">5&nbsp;лицензий</span> на подключение торгово-сервисных предприятий</li>
                  <li class="blue">
				@if ($tariffs[$user->tariff]['level'] > 3)
				<a href="/admin/billing/cards" class="button" style="background-color:#999999; border:0px;">Тариф недоступен</a>
				@elseif  ($user->tariff == 'BUSINESS START')
				<a href="/admin/billing/cards" class="button" style="background-color:#666666; border:0px;">Действующий сейчас тариф</a>
				@else
				<a href="/admin/billing/order?tariff=BUSINESS START" class="button">Приобрести</a>
				@endif
			</li>
                </ul>
              </div>

              <div class="col-lg-4 col-md-4 mb-60">
                <ul class="price active" style="border: 1px solid #cccccc;">
                  <li class="header">ПАРТНЁРСКИЙ ПАКЕТ</li>
                  <li class="subheader">
				<span class="vista-box vista-box-md"><span class="left">BUSINESS</span><span class="right vista-optimum-bg">OPTIMUM</span></span>
			</li>
                  <li>Стоимость <span class="vista-box vista-box-sm">50&nbsp;000&nbsp;рублей</span></li>
                  <li>Кэшбэк за личные покупки, <span class="vista-box vista-box-sm">в&nbsp;2&nbsp;раза</span> больше по сравнению с картой
				<span class="vista-box vista-box-sm"><span class="left">VISTA</span><span class="right vista-standart-bg">STANDARD</span></span>
			</li>
                  <li><span class="vista-box vista-box-sm">5&nbsp;уровней</span> для получения бонуса от кэшбэка привлеченных пользователей</li>
                  <li>Опция перевода ваших баллов на вашу банковскую карту или другую платежную систему</li>
                  <li><span class="vista-box vista-box-sm">50&nbsp;лицензий</span> на подключение торговосервисных предприятий</li>
                  <li>В партнерский пакет входят <span class="vista-box vista-box-sm">20&nbsp;карт</span>
			 <span class="vista-box vista-box-sm"><span class="left">VISTA</span><span class="right vista-gold-bg">GOLD</span></span> 
			 и 
			 <span class="vista-box vista-box-sm">2&nbsp;пакета</span>
			 <span class="vista-box vista-box-sm"><span class="left">BUSINESS</span><span class="right vista-standart-bg">STANDARD</span></span>
			 </li>
                  <li class="blue">
				@if ($tariffs[$user->tariff]['level'] > 4)
				<a href="/admin/billing/cards" class="button" style="background-color:#999999; border:0px;">Тариф недоступен</a>
				@elseif  ($user->tariff == 'BUSINESS OPTIMUM')
				<a href="/admin/billing/cards" class="button" style="background-color:#666666; border:0px;">Действующий сейчас тариф</a>
				@else
				<a href="/admin/billing/order?tariff=BUSINESS OPTIMUM" class="button">Приобрести</a>
				@endif
			</li>
                </ul>
              </div>

              <div class="col-lg-4 col-md-4 mb-60">
                <ul class="price active" style="border: 1px solid #cccccc;">
                  <li class="header">ПАРТНЁРСКИЙ ПАКЕТ</li>
                  <li class="subheader">
				<span class="vista-box vista-box-md"><span class="left">BUSINESS</span><span class="right vista-max-bg">MAX</span></span>
			</li>
                  <li>Стоимость <span class="vista-box vista-box-sm">150&nbsp;000&nbsp;рублей</span></li>
                  <li>Кэшбэк за личные покупки, <span class="vista-box vista-box-sm">в&nbsp;2&nbsp;раза</span> больше по сравнению с картой
				<span class="vista-box vista-box-sm"><span class="left">VISTA</span><span class="right vista-standart-bg">STANDARD</span></span>
			</li>
                  <li><span class="vista-box vista-box-sm">8&nbsp;уровней</span> для получения бонуса от кэшбэка привлеченных пользователей:<br />
1 уровень <span class="vista-box vista-box-sm">20%</span><br />
2 уровень <span class="vista-box vista-box-sm">10%</span><br />
3 уровень <span class="vista-box vista-box-sm">3%</span><br />
далее по <span class="vista-box vista-box-sm">1%</span></li>
                  <li><span class="vista-box vista-box-sm">200&nbsp;лицензий</span> на подключение торговосервисных предприятий к системе лояльности, и получение дохода с кэшбэка, от <span class="vista-box vista-box-sm">8-ми&nbsp;уровней</span> пользователей данных предприятий</li>
                  <li>Опция перевода ваших баллов на вашу банковскую карту или другую платежную систему</li>
                  <li>В партнерский пакет входят <span class="vista-box vista-box-sm">50&nbsp;карт</span>
			 <span class="vista-box vista-box-sm"><span class="left">VISTA</span><span class="right vista-gold-bg">GOLD</span></span> 
			 и 
			 <span class="vista-box vista-box-sm">4&nbsp;пакета</span>
			 <span class="vista-box vista-box-sm"><span class="left">BUSINESS</span><span class="right vista-standart-bg">STANDART</span></span>
			 </li>
                  <li>За продажу любого из пакетов вашей командой, вы получаете бонусы в зависимости от уровня на котором он был продан</li>
                  <li class="blue">
				@if ($tariffs[$user->tariff]['level'] > 5)
				<a href="/admin/billing/cards" class="button" style="background-color:#999999; border:0px;">Тариф недоступен</a>
				@elseif  ($user->tariff == 'BUSINESS MAX')
				<a href="/admin/billing/cards" class="button" style="background-color:#666666; border:0px;">Действующий сейчас тариф</a>
				@else
				<a href="/admin/billing/order?tariff=BUSINESS MAX" class="button">Приобрести</a>
				@endif
			</li>
                </ul>
              </div>

          </div>
<!--{{--############################# /// ТАРИФЫ ######################################--}}-->








</div>
</div>
@endsection
