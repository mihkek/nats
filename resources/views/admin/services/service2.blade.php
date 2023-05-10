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
$price = 6000; // начальный прайс данной услуги
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

					Пакет кобрэндинговых карт с индивидуальным дизайном<br />
					<div class="text-center" style="font-size: 38px; font-weight: 700;">
						<span class="vista-box vista-box-md"><span class="left" style="margin-right:-5px;">
						<select name="total" id="myTotal">
							<option value="100" data-price="6000">100</option>
							<option value="200" data-price="12000">200</option>
							<option value="300" data-price="18000">300</option>
							<option value="500" data-price="30000">500</option>
						</select> КАРТ
						</span></span>
					</div>

					<br />
					<div class="text-center">
						Закачать файл со своим дизайном:<br />
						<input name="file" type="file" class="center-block" 
						style="border:1px solid #000000; color:#000000; padding:10px; border-radius:8px!important;">
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