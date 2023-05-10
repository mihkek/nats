@section('title', 'Приобретение услуги')
@extends('admin.template')

@section('main')




<link rel="stylesheet" type="text/css" href="/css/public_typography.css" />
<link rel="stylesheet" type="text/css" href="/css/public_shortcodes/shortcodes.css" />
<link rel="stylesheet" type="text/css" href="/css/public_colors.css" />
<style>
.superbig {
	margin:30px 0;
	font-size:36px;
	font-weight: 300;
	font-family: Open Sans,sans-serif;
	padding:15px;
	text-align:center;
	width:100%;
}
h1 i {
	font-size:92px
}
h1 {
	font-size: 36px;
	font-weight: 300;
	font-family: "Open Sans",sans-serif;
	margin-top: 20px;
	margin-bottom: 10px;
	line-height: 1.1;
}
.btn-lgg {
	padding: 35px 25px;
	font-size: 24px;
	}
</style>





<div class="page-content-wrapper">
<div class="page-content">




		@if ($request->message == 'more' && $request->summ)
		<div class="alert-area">
			<div class="custom-alerts alert alert-danger fade in" id="alertMore" style="font-size:18px;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				<i class="icon-info"></i> 
				<span>Для окончательного оформления заказа  
				тебе не&nbsp;хватает <b>всего лишь {{$request->summ}}&nbsp;руб</b>&nbsp;— пожалуйста
				оплати их&nbsp;прямо сейчас, 
				и&nbsp;сразу после этого ты&nbsp;сможешь оформить заказ</span>
			</div>
		</div>
{{--
		<script>
			setTimeout(function() {
				jQuery("#alertMore").fadeOut(500, function() {});
				}, 8000);
		</script>
--}}
		@endif 








	<div class="row">
		<div class="col-xs-12">
			<div class="portlet light">
				<div class="portlet-body text-center">
					<br />
					<br />
					<h1>
						<i class="icon-basket-loaded"></i><br />
						<br />
						ПОКУПКА
					</h1>
					<br />

					<div class="text-center" style="font-size: 38px; font-weight: 700;">
						{!! $tariffs[ $request->tariff ]['emblem'] !!}
					</div>

					<br />
					<h1>
						СТОИМОСТЬ
					</h1>
					<br />

					<div class="text-center" style="font-size: 38px; font-weight: 700;">
						<span class="vista-box vista-box-md"><span class="left" style="margin-right:-5px;">
							{{  Helpers::VerbalDigit($price, 'рубль', 'рубля', 'рублей', true)  }}
						</span></span>
					</div>

					<br />
					<h1>
						ДОСТУПНО НА СЧЕТУ
					</h1>
					<br />

					<div class="text-center" style="font-size: 38px; font-weight: 700;">
						<span class="vista-box vista-box-md"><span class="left" style="margin-right:-5px;">
							{{  Helpers::VerbalDigit($balance, 'рубль', 'рубля', 'рублей', true)  }}
						</span></span>
					</div>

					<br />
				</div>
			</div>
		</div>
	</div>


	<div class="text-center" style="font-size: 38px; font-weight: 700;">
		@if ( $balance >= $price )
		<form action="/admin/billing/order" method="post">{{ csrf_field() }}
			<input type="hidden" name="tariff" value="{{ $request->tariff }}" />
			<button type="submit" class="btn btn-lg btn-lgg btn-success"><i class="icon-basket-loaded"></i> ПОДТВЕРДИТЬ</button>
		</form>
		@else
		<a href="/admin/billing/pay?message=more&summ={{ $price - $balance }}" class="btn btn-lg btn-lgg btn-primary"><i class="icon-basket-loaded"></i> ПОПОЛНИТЬ БАЛАНС</a>
		@endif
	</div>


	<br />



</div><!-- page-content -->
</div><!-- page-content-wrapper -->





@endsection

@push('scripts')
<script>
App.components.admin_payment.init({});
</script>
@endpush