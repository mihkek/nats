@section('title', 'Оплата услуг')
@extends('admin.template')

@section('main')




<style>
.btn-lgg {
	padding: 35px 25px;
	font-size: 24px;
	background:#FC0D1B;
	}
</style>





    <div class="page-content-wrapper">
        <div class="page-content">
        <div id="app" style="margin-bottom: 0 !important;">
            <billing_pay :user_id="{{Auth::id()}}">
        </div>



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



<!--{{--
            <div class="row">
                <div class="col-lg-12">
					<h3 class="page-title">Оплата и пополнение баланса</h3>
					<div class="img-glyph"><span class="icon-credit-card"> </span></div>
                    <p>
						Оплата происходит через сервис «Робокасса», где можно будет выбрать удобный способ платежа.
						Платежи с&nbsp;кредитных карт и&nbsp;любые другие электронные платежи зачисляются <strong>моментально</strong>. 
                        При оплате наш сервис не&nbsp;получает ваши платежные данные&nbsp;— ни&nbsp;данные
                        кредитных карт, ни&nbsp;телефоны, ни&nbsp;иную конфиденциальную информацию.</p>
                </div>
            </div>
--}}-->






            <div class="row">
                <div class="col-md-6">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-credit-card font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">@lang('billing.pay_variants')</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="payment-var">
                                <b>@lang('billing.banks_cards')</b><br>
                                <img src="/img/payment2/BankCard/cards_mir.svg" alt="">
                                <img src="/img/payment2/BankCard/cards_visa.svg" alt="">
                                <img src="/img/payment2/BankCard/cards_mastercard.svg" alt="">
                                <img src="/img/payment2/BankCard/cards_maestro.svg" alt="">
                                <img src="/img/payment2/BankCard/cards_applepay.svg" alt="">
                            </a>
                            </div>
                            <div class="payment-var">
                                <b>@lang('billing.e_money')</b><br>
                                <img src="/img/payment2/EMoney/emoney_yamoney.svg" alt=""> 
                                <img src="/img/payment2/EMoney/emoney_webmoney.svg" alt=""> 
                                <img src="/img/payment2/EMoney/emoney_qiwi.svg" alt=""> 
                            </div>
                            <div class="payment-var">
                                <b>@lang('billing.phone_pay')</b><br>
                                <img src="/img/payment2/Mobile/phone_beeline.svg" alt=""> 
                                <img src="/img/payment2/Mobile/phone_megafon.svg" alt=""> 
                                <img src="/img/payment2/Mobile/phone_mts.svg" alt=""> 
                                <img src="/img/payment2/Mobile/phone_tele2.svg" alt=""> 
                            </div>
                            <div class="payment-var">
                                <b>@lang('billing.internet_bank')</b><br>
                                <img src="/img/payment2/Bank/banking_sberbank.svg" alt=""> 
                                <img src="/img/payment2/Bank/banking_alfa.svg" alt=""> 
                                <img src="/img/payment2/Bank/banking_psb.svg" alt=""> 
                                <img src="/img/payment2/Bank/banking_masterpass.svg" alt=""> 
                            </div>
                            <div class="payment-var">
                                <b>@lang('billing.cash')</b><br>
                                <img src="/img/payment2/Other/nal_comepay.svg" alt=""> 
                                <img src="/img/payment2/Other/nal_svyaznoy.svg" alt=""> 
                                <img src="/img/payment2/Other/nal_euroset.svg" alt=""> 
                            </div>
                            <p>@lang('billing.money_descr')</p>
							<p>@lang('billing.use_descr')</p>
                        </div><!-- portlet-body -->
                    </div><!-- portlet light -->
                </div><!-- col-md-6 -->






                <div class="col-md-6">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-credit-card font-blue-soft"></i>
                                <span class="caption-subject font-blue-soft sbold uppercase">@lang('billing.replenish_account')</span>
                            </div>
                        </div>
                        <div class="portlet-body">                    
                            <form name="formPayment" id="formPayment" action="/admin/billing/pay/robokassa" method="post">
                                {{ csrf_field() }}

                                <div class="modal-body">
                                    <div class="form-group ">
							<label>
								@if ($request->message == 'more' && $request->summ)
									<span class="font-red">Для оформления заказа тебе 
									не&nbsp;хватает <b>всего лишь {{$request->summ}}&nbsp;руб</b>&nbsp;— 
									оплати их&nbsp;прямо сейчас, 
									и&nbsp;сразу после этого ты&nbsp;сможешь оформить заказ</span><br /><br />
								@else
									<b class="font-blue-soft">@lang('billing.replenish_account_form_label')</b>
								@endif
							</label>
                                        <input type="text" name="sum" class="form-control 
						    	@if ($request->message == 'more' && $request->summ)  font-red @else font-blue-soft @endif
						    " value="@if ($request->summ){{$request->summ}}@else{{0}}@endif"
						    style="width: 200px; height:75px; font-size:36px; font-weight:bold; text-align:center;">
                                        <label class="help-block help-block-error no-left-padding hidden error"></label>
                                    </div>
                                    <p>@lang('billing.replenish_account_descr')</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-lg btn-lgg btn-primary"><i class="icon-basket-loaded"></i> @lang('buttons.pay')</button>
                                </div>
                            </form>
                        </div><!-- portlet-body -->
                    </div><!-- portlet light -->
                </div>
            </div>    






        </div><!-- page-content -->
    </div><!-- page-content-wrapper -->





@endsection

@push('scripts')
    <script>
        App.components.admin_payment.init({});
    </script>
@endpush