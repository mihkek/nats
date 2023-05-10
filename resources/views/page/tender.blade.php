@extends('layouts.main_html')

@section("title", "Тендер №".$auction->id . " " . $auction_title . " " . $auction->active_material . " | agtender.com")
@section("description", "Тендер №".$auction->id . " " . $auction_title . " " . $auction->active_material . ". «НАТС» - agtender.com")

@section('content')

@php

$payment = "";
if($auction->payment_condition === 1) {
$payment = "В течение 5 дней после поставки";
}
elseif ($auction->payment_condition === 2) {
$payment = "Через 30 дней после доставки";	
}
elseif ($auction->payment_condition === 3) {
$payment = "Через 60 дней после доставки";	
}
elseif ($auction->payment_condition === 4) {
$payment = "Через 90 дней после доставки";	
}
elseif ($auction->payment_condition === 5) {
$payment = "Предоплата";	
}
else {
$payment = $auction->payment_condition;	
}

@endphp

<main class="v-main" style="padding: 50px 0px 350px;" data-booted="true">
	<div class="v-main__wrap">
		<div class="container container--fluid grid-list-lg">
			<div class="layout row wrap">
				<div class="flex xs12">
					<ul class="v-breadcrumbs v-breadcrumbs--large theme--light">
						<li><a href="/" class="v-breadcrumbs__item">Главная</a></li>
						<li class="v-breadcrumbs__divider">/</li>
						<li><a href="/tenders" class="v-breadcrumbs__item">Все тендеры</a></li>
						<li class="v-breadcrumbs__divider">/</li>
						<li>
							<div class="v-breadcrumbs__item v-breadcrumbs__item--disabled">Тендер №{{ $auction->id }}</div>
						</li>
					</ul>
					<div class="v-card v-sheet theme--light">
						<div class="v-card__title px-6 pt-6 mr-6" style="line-height: 1.2;">
							<h1><span style="word-break: normal;">Тендер №{{ $auction->id }} {{ $auction->title }} <span class="font-weight-regular">{{ $auction->active_material }}</span></span></h1>

							<!--<span>
								<span class="font-weight-regular">
									<br>или аналог
									
								</span>
							</span>-->
							<div class="spacer"></div>
						</div>
						<div class="v-card__text py-0 px-2" style="max-height: 75vh;">
							<div class="container py-0 container--fluid grid-list-md">
								<hr role="separator" aria-orientation="horizontal" class="mx-2 my-0 v-divider theme--light">
								<div class="layout row wrap">
									<div class="flex md4">
										<div tabindex="-1" class="px-2 v-list-item theme--light">
											<div class="v-list-item__content">
												<p class="mb-2 label text-left px-0">Объем:</p>
												<div class="v-list-item__title">
													{{ $auction->size }} {{ $auction->unit }} 
												</div>
											</div>
										</div>
									</div>
									<div class="flex md4">
										<div tabindex="-1" class="px-2 v-list-item theme--light">
											<div class="v-list-item__content">
												<p class="mb-2 label text-left px-0">Дата окончания:</p>
												<div class="v-list-item__title">
													{{ $auction->date_formated }}	
													
												</div>
											</div>
										</div>
									</div>
									<div class="flex md4">
										<div tabindex="-1" class="px-2 v-list-item theme--light">
											<div class="v-list-item__content">
												<p class="mb-2 label text-left px-0">Срок доставки:</p>
												<div class="v-list-item__title">
													до {{ $auction->delivery_date_formated }}												
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr role="separator" aria-orientation="horizontal" class="mx-2 my-0 v-divider theme--light">
								<div class="layout row wrap">
									<div class="flex md8">
										<div tabindex="-1" class="px-2 v-list-item theme--light">
											<div class="v-list-item__content">
												<p class="mb-2 label text-left px-0">Способ доставки:</p>
												<div class="v-list-item__title">
											
													@if($auction->delivery_condition === 1)
													Со склада поставщика  
													@endif

													@if($auction->delivery_condition === 2)
													Поставка на склад покупателя
													@endif

													@if($auction->delivery_condition === 3)
													Транспортной компанией до терминала
													@endif						

												</div>
											</div>
										</div>
									</div>
									<div class="flex md4">
										<div tabindex="-1" class="px-2 v-list-item theme--light">
											<div class="v-list-item__content">
												<p class="mb-2 label text-left px-0">Регион поставки:</p>
												<div class="v-list-item__title">
													{{ $auction->delivery_region }}	
													
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr role="separator" aria-orientation="horizontal" class="mx-2 my-0 v-divider theme--light">
								<div class="layout row wrap">
									<div class="flex xs12">
										<div tabindex="-1" class="px-2 v-list-item theme--light">
											<div class="v-list-item__content">
												<p class="mb-2 label text-left px-0">Условия оплаты:</p>
												<div class="v-list-item__title">
													
													{{$payment}}
													
												</div>
											</div>
										</div>
										<div tabindex="-1" class="px-2 v-list-item theme--light">
											<div class="v-list-item__content">
												<p class="mb-2 label text-left px-0">Особые условия:</p>
												<div class="v-list-item__title">

													@if($auction->special_terms)
														{{ $auction->special_terms }}	
													@else
														нет
													@endif

													
													
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr role="separator" aria-orientation="horizontal" class="mx-2 my-0 v-divider theme--light">
							</div>
						</div>
						<div class="v-card__actions pb-4">
							<div class="container container--fluid">
								<div class="layout row wrap">
									<div class="flex md4">
										<div tabindex="-1" class="px-2 v-list-item theme--light">
											<div class="v-list-item__content">
												<p class="mb-2 label text-left px-0">Текущее предложение:</p>
												<div class="v-list-item__title">
													<span style="font-size: 24px; line-height: 32px; zoom: 1;" class="font-weight-bold">
													@if($rate)												
													{{ $rate->price }}  ₽<span class="font-weight-light">/{{ $auction->unit }}</span>
													@else
													0 ₽
													@endif
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="flex md8">
										<div class="v-card__actions pt-6">
											<div class="spacer"></div>
											<a href="/admin/tender/now/card/{{ $auction->id }}" class="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--large success" rel="nofollow"><span class="v-btn__content">Предложить цену</span></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>






	<div class="container container--fluid grid-list-lg">
			<div class="layout row wrap">
				<div class="flex xs12">

<h2>{{$auction_full_title}}: что нужно знать покупателям и продавцам</h2>

<p>Сельскохозяйственная деятельность требует множества финансовых затрат и вложений для поддержания техники в исправном состоянии, а также для обработки земли. Электронная торговая площадка — это выгодная не только для частных лиц, но и для предпринимателей платформа, где можно совершать покупки и не переплачивать. НАТС размещает тендеры, на которых покупатели могут купить удобрения, химические и биологические средства защиты и многое другое. Продавцы и поставщики, в свою очередь, могут ответить на запрос потребителя и предложить свой товар.</p>

<h2>{{$auction_full_title}}: принципы проведения и условия</h2>

<p>Каждый тендер формируется в индивидуальном порядке. После авторизации на сайте пользователь получает возможность размещать собственные объявления и дополнять их необходимой информацией. {{$auction_full_title}} содержит информацию о необходимом товаре, его объеме, способах доставки и оплаты, а также о сроках проведения торгов. Также в заявке указан регион. Исходя из этих данных, продавец, которому подходят условия, могут откликнуться и предложить свою стоимость продукции. {{$auction_full_title}} будет завершен, когда его инициатор выберет наиболее приемлемое для себя предложение и заключит договор.</p>

<h2>Главные плюсы тендерной системы</h2>
<p>Система торгов очень выгодна по нескольким причинам. Во-первых, значительная экономия времени — его не нужно тратить на поиск товаров и сравнения цен. Во-вторых, тендерная система предназначена для физических и юридических лиц, поэтому расчёт можно провести в удобном для каждого формате. В-третьих, снижается риск попасть на мошенников, которые либо не имеют гарантии на товар, либо требуют деньги вперед. НАТС следит за тем, чтобы в торгах учувствовали только добросовестные покупатели и продавцы.</p>

</div>
</div>
</div>





	</div>







</main>





@endsection



