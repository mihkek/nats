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





@php
$price = 1000; // начальный прайс данной услуги
@endphp

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

					Приоритетное размещение в категории на сайте<br />
					<div class="text-center" style="font-size: 38px; font-weight: 700;">
						<span class="vista-box vista-box-md"><span class="left" style="margin-right:-5px;">
						<select name="total" id="myTotal">
							<option value="1" data-price="1000">1 неделя</option>
							<option value="2" data-price="2000">2 недели</option>
							<option value="3" data-price="3000">3 недели</option>
							<option value="4" data-price="4000">1 месяц</option>
						</select>
						</span></span>
					</div>

					<br />
					<h1>
						СТОИМОСТЬ
					</h1>

					<div class="text-center" style="font-size: 38px; font-weight: 700;">
						<span class="vista-box vista-box-md"><span class="left" style="margin-right:-5px;">
							<span id="myPrice">{{ $price }}</span> рублей
						</span></span>
					</div>

					<br />
					<h1>
						ДОСТУПНО НА СЧЕТУ
					</h1>

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
		

		<div id="myLinkOrder" style="display: @if ($balance >= $price) block @else none @endif">
		<form action="/admin/services/order" method="post">{{ csrf_field() }}
			<input type="hidden" name="tariff" value="{{ $request->tariff }}" />
			<button type="submit" class="btn btn-lg btn-lgg btn-success"><i class="icon-basket-loaded"></i> ПОДТВЕРДИТЬ</button>
		</form>
		</div>

		<div id="myLinkPayment" style="display: @if ($balance >= $price) none @else block @endif">
		<a href="/admin/billing/pay?message=more&summ={{ $price - $balance }}" id="myLinkPayment" class="btn btn-lg btn-lgg btn-primary"><i class="icon-basket-loaded"></i> ПОПОЛНИТЬ БАЛАНС</a>
		</div>
	</div>


	<br />



</div><!-- page-content -->
</div><!-- page-content-wrapper -->





@endsection

@push('scripts')
<script>
App.components.admin_payment.init({});

jQuery(document).ready(function() {

	jQuery("#myTotal").change(function(){
		var myPrice = jQuery(this).find(':selected').attr('data-price');
		jQuery("#myPrice").html( myPrice );
		var myPricePay = Math.ceil(myPrice - {{ $balance}});
		jQuery("#myLinkPayment a").attr('href', '/admin/billing/pay?message=more&summ=' + myPricePay);

		if ({{ $balance}} >= myPrice) {
			jQuery("#myLinkPayment").css('display', 'none');
			jQuery("#myLinkOrder").css('display', 'block');
		} else {
			jQuery("#myLinkPayment").css('display', 'block');
			jQuery("#myLinkOrder").css('display', 'none');
		}

	});

});
</script>
@endpush