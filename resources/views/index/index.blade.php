@extends('layouts.main_page')

@section("title", "Национальная Аграрная Тендерная Система (НАТС) – Работаем по РФ")

@section("description", "«Национальная Аграрная Тендерная Система» позволяет Покупателям со своего компьютера провести online торги, ознакомиться с предложениями многочисленных независимых поставщиков и заказать все необходимые средства защиты растений по самой лучшей цене.")

@section('content')



	<main class="v-main" style="padding: 50px 0px 350px;">
		<div class="v-main__wrap">
			<div class="flex v-card v-card--flat v-sheet theme--dark rounded-0"  style="background-color: rgb(69, 96, 24); border-color: rgb(69, 96, 24);">
				<div style="display: flex; flex-flow: column nowrap; place-content: flex-end; height: 25vw; min-height: 600px; background: url(&quot;/img/custom/bg02.jpg&quot;) 85% 50% / cover; margin-bottom: -25px;">
					<div><counters_block /></div>
					<h1 class="title-nats">Национальная Аграрная Тендерная Система (НАТС)</h1>
					<div class="container container--fluid grid-list-lg">
						<div class="layout row wrap">
							<div class="flex md10 xs12">
								<div class="layout row wrap">
									<div class="flex md6 xs12">
										<div class="flex xs12">
											<div class="tender-box"><a href="/tenders" class="tender-box-btn button-1"><span class="tender-box-btn-left"></span> <span>Тендеры</span> <span class="tender-box-btn-right"></span></a></div>
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
					<div class="flex md10 xs12">
						<div class="layout row wrap">
							<div class="flex box-tenders md12 xs12">
								<div class="flex xs12">
									<div class="my-3 v-card v-card--flat v-sheet theme--light transparent">
										<div class="v-card__title pb-0 justify-center">
											<h2 class="my-0 last-title">Последние тендеры</h2>
											<div class="flex text-center"><a href="/admin/tender/add"
																			 class="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--large success btn-success">
													<span class="v-btn__content">Разместить тендер</span></a></div>
										</div>
									</div>
									<div class="spacer"></div>
									<div class="mb-3 v-card v-card--flat v-sheet theme--light transparent">

									</div>
									<div class="v-data-table theme--light">
										<div class="v-data-table__wrapper">
											<table>
												<colgroup>
													<col class="">
													<col class="">
													<col class="">
													<col class="">
													<col class="">
													<col class="">
												</colgroup>
												<div class="container container--fluid grid-list-lg">
													<div class="layout row wrap">
														@foreach($tenders as $item)
															<div class="flex xs12">
																<a tabindex="0" href="/tenders/{{$item['auction']->id}}-{{$item['auction']->slug}}" target="_blank" class="v-card v-card--link v-sheet theme--light elevation-2">
																	<div class="container container--fluid grid-list-xs">
																		<div class="layout row wrap">
																			<div class="flex md8">
																				<div class="my-1 v-card v-card--flat v-sheet theme--light transparent">
																					<button type="button" class="v-btn v-btn--absolute v-btn--icon v-btn--round v-btn--text theme--light v-size--x-small success--text" size="8" style="left: 0px; top: 8px;"><span class="v-btn__content"><i aria-hidden="true" class="v-icon notranslate mdi mdi-circle-slice-8 theme--light" style="font-size: 8px;"></i></span></button>
																					<div class="v-card__text py-2 px-6"><span class="grey--text text--darken-3 font-weight-bold mr-3" style="font-size: 16px;">{{$item['auction']->article}} </span><br> <span class="grey--text text--lighten-1 font-weight-light" style="font-size: 13px;">от {{$item['auction']->created}}</span></div>
																					<div primary-title="" class="v-card__text py-0 px-6 subtitle">
																						<p class="font-weight-medium text-decoration-none my-0 mat-title">
															<span>
																{{$item['auction']->title}} 
																<br><span class="font-weight-regular">{{ $item['auction']->active_material }}</span>	
															</span>
																						</p>
																					</div>
																					<div class="v-card__actions px-6"><span class="grey--text text--darken-3 font-weight-light" style="font-size: 14px;">
													@if($item['auction']->delivery_condition == 1)
																								Со склада поставщика
																							@else
																								{{ $item['auction']->delivery_region }}
																							@endif
												</span></div>
																				</div>
																			</div>
																			<div class="flex my-auto md4">
																				<div role="list" class="v-list v-sheet theme--light">
																					<div tabindex="-1" role="listitem" class="v-list-item v-list-item--three-line theme--light">
																						<div class="v-list-item__content">
																							<div class="v-list-item__subtitle grey--text text--darken-2 font-weight-medium mb-1">
																								Текущее предложение
																							</div>
																							<div class="v-list-item__title mb-2">
																								@if(isset($item['rate']->price))
																									<span class="price-title font-weight-bold">{{$item['rate']->price}} ₽
																<span  class="font-weight-light">/{{$item['auction']->unit }}</span>
															</span>
																								@else
																									<span class="price-title font-weight-bold grey--text">0 ₽</span>
																								@endif

																							</div>
																							<div class="v-list-item__subtitle grey--text text--darken-3 font-weight-medium">
																								Окончание:<br>{{$item['auction']->date_formated}} ({{$item['auction']->datediff}} дн.
																								@if($item['auction']->timeiff==0)
																									меньше часа. )
																								@else
																									{{$item['auction']->timeiff}} часов. )
																								@endif
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</a>
															</div>
														@endforeach
													</div>
												</div>
											</table>
										</div>
									</div>
									<div class="flex my-4 xs12">
										<div class="flex text-center"><button type="button" class="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default "><span class="v-btn__content"><a href="/tenders" class="more-btn">Показать больше</a></span></button></div>
									</div>
									<div role="dialog" class="v-dialog__container">
										<!---->
									</div>
								</div>
							</div>
							<?php /* ?>
						<div class="flex box-sales md6 xs12">
	<div class="flex xs12">
		<div class="my-3 v-card v-card--flat v-sheet theme--light transparent">
			<div class="v-card__title pb-0 justify-center">
				<h2 class="my-0 last-title">Последние распродажи</h2>
				<div class="flex text-center"><a href="/admin/sale/add"
				 class="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--large success btn-success">
				 <span class="v-btn__content">Разместить распродажу</span></a></div>
			</div>
		</div>
		<div class="spacer"></div>
		<div class="mb-3 v-card v-card--flat v-sheet theme--light transparent">
		</div>
		<!----> 
		<div class="v-data-table theme--light">
			<div class="v-data-table__wrapper">
				<table>
					<colgroup>
						<col class="">
						<col class="">
						<col class="">
						<col class="">
						<col class="">
						<col class="">
					</colgroup>
					<div class="container container--fluid grid-list-lg">
						<div class="layout row wrap">
							@foreach($sales as $item)						
							<div class="flex xs12">
								<a tabindex="0" href="/tenders/{{$item['auction']->id}}-{{$item['auction']->slug}}" target="_blank" class="v-card v-card--link v-sheet theme--light elevation-2">
									<div class="container container--fluid grid-list-xs">
										<div class="layout row wrap">
											<div class="flex md8">
												<div class="my-1 v-card v-card--flat v-sheet theme--light transparent">
													<button type="button" class="v-btn v-btn--absolute v-btn--icon v-btn--round v-btn--text theme--light v-size--x-small success--text" size="8" style="left: 0px; top: 8px;"><span class="v-btn__content"><i aria-hidden="true" class="v-icon notranslate mdi mdi-circle-slice-8 theme--light" style="font-size: 8px;"></i></span></button> 
													<div class="v-card__text py-2 px-6"><span class="grey--text text--darken-3 font-weight-bold mr-3" style="font-size: 16px;">{{$item['auction']->article}} </span><br> <span class="grey--text text--lighten-1 font-weight-light" style="font-size: 13px;">от {{$item['auction']->created}}</span></div>
													<div primary-title="" class="v-card__text py-0 px-6 subtitle">
														<p class="font-weight-medium text-decoration-none my-0 mat-title">
															<span>
																{{$item['auction']->title}} 
																<br><span class="font-weight-regular">{{ $item['auction']->active_material }}</span>	
															</span>
														</p>
													</div>
													<div class="v-card__actions px-6"><span class="grey--text text--darken-3 font-weight-light" style="font-size: 14px;">
													@if(isset($item['auction']->delivery_region))	
														{{ $item['auction']->delivery_region }}	
													@endif
												</span></div>
												</div>
											</div>
											<div class="flex my-auto md4">
												<div role="list" class="v-list v-sheet theme--light">
													<div tabindex="-1" role="listitem" class="v-list-item v-list-item--three-line theme--light">
														<div class="v-list-item__content">
															<div class="v-list-item__subtitle grey--text text--darken-2 font-weight-medium mb-1">
																Стартовая цена
															</div>
															<div class="v-list-item__title mb-2">	
															<span class="price-title font-weight-bold">{{$item['auction']->start_price}} ₽</span>	
															</div>
															<div class="v-list-item__subtitle grey--text text--darken-3 font-weight-medium">
																Окончание:<br>{{$item['auction']->date_formated}} ({{$item['auction']->datediff}} дн.)
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
							 @endforeach
						</div>
					</div>
				</table>
			</div>
		</div>
		<div class="flex my-4 xs12">
			<div class="flex text-center"><button type="button" class="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--default"><span class="v-btn__content"><a href="/sales" class="more-btn">Показать больше</a></span></button></div>
		</div>
		<div role="dialog" class="v-dialog__container">
			<!---->
		</div>
	</div>
							<!--<sales_block :user_id="1"/>-->
						</div>
						<?php */ ?>
						</div>

						<div>
							<reviews_block />
						</div>

						<div class="container container--fluid">
							<div class="mb-3 v-card v-card--flat v-sheet v-sheet--outlined theme--light">
								<div class="v-card__title">
									<h2 class="my-0 display-1">О площадке</h2>
									<div class="spacer"></div>
								</div>
								<div class="v-card__text">
									<h2>Современный формат ведения бизнеса</h2>
									<p>В мире покупка и продажа уже давно ушли в онлайн-пространство. Это коснулось и фермерского хозяйства. Государство активно помогает в развитии данной отрасли. Одни из главных задач нашей страны в сфере сельхоз хозяйства — создать дополнительные рабочие места, сократить импорт и снизить цены на продукцию. Разработка онлайн-программ помогает упросить ведение бизнеса, привлекать и наращивать сотрудничество между компаниями и частными лицами по всей стране. </p>
									<h2>О компании</h2>
									<p>Мы — аграрный портал с площадкой электронных торгов, помогающий фермерам и сельскохозяйственным компаниям разместить на нашем сайте (химические средства защиты растений) свою продукцию химической защиты растений, найти постоянный поток клиентов и реализовать свой товар по конкурентным ценам. Покупатели в свою очередь получают широкий выбор продукции по выгодной стоимости.</p>
									<h2>Почему стоит выбрать наш портал?   Почему стоит выбрать нашу площадку? </h2>
									<p>Наш национальный тендерный портал (наша электронная торговая площадка) — один из первых в России, готовый помочь быстро и просто разместить агро объявление, найти поставщиков или покупателей фермерской химической продукции. Удобный интерфейс и простая форма регистрации позволят за пару минут внести нужную информацию.</p>
									<h2>Плюсы нашего портала</h2>
									<p><u><strong>Экономия времени</strong></u> — в режиме онлайн вы видите все доступные предложения. Никаких лишних встреч и звонков, вы не отрываетесь от работы, только периодически заглядываете на электронную торговую площадку.</p>
									<p><u><strong>Минимум затрат</strong></u> — вы не тратите средства на дополнительный штат сотрудников, наша платформа проста и понятна в использовании. Вам нужно лишь разместить подробную информацию о тендере на электронной торговой площадке и ожидать встречных предложений.</p>
									<p><u><strong>Экономия на закупках</strong></u> — тендерная система позволит быстро провести анализ предложений и выбрать наиболее подходящий для вас вариант. Наша электронная торговая площадка работает по всей России, а значит компании со всей страны готовы представить свою продукцию.</p>
									<p><u><strong>Надежность сделки</strong></u> — мы контролируем сделки на всех этапах. Наши менеджеры всегда готовы помочь правильно заключить договор в режиме онлайн, ответят на все возникающие вопросы, организуют отгрузку товара даже на поле. Гарантируем порядок в документации и исполнение заказов в срок.</p>
									<h2>Какую продукцию вы можете разместить на нашем портале</h2>
									<p>Ваши запросы могут быть любого характера: это может быть тендер на покупку /продажу средств для защиты растений от сорняков, насекомых (гербицидов (в том числе сплошного действия), пестицидов, фунгицидов, инсектицидов и пр.), оборудование или сельскохозяйственные культуры. На нашей электронной торговой площадке размещают запросы на выгодную закупку топлива. Расширенный поиск с удобными фильтрами поможет оперативно найти необходимую продукцию.</p>
									<p><strong>Наша задача</strong> — быстро и без лишних финансовых затрат помочь вашему бизнесу заключить выгодные контракты. Через нашу электронную торговую площадку возможно осуществлять госзакупки и небольшие частные тендеры на всей территории России. Если у вас возникли вопросы, нажмите кнопку «Заказать обратный звонок», и наши специалисты оперативно свяжутся с вами.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="flex md2 xs12">
						<div class="container container--fluid">
							<div  class="sidebar-box-title my-3 v-card v-card--flat v-sheet theme--light transparent"><span  class="rek-title">Ваша реклама</span></div>
							<div  class="v-card v-card--flat v-sheet theme--light transparent">
								<div  class="flex">
									<a  href="http://www.proagro.su/" target="_blank"><img  src="/img/banners/proagro-3.jpg"
																							title="www.proagro.su" alt="www.proagro.su"
																							class="img-responsive img-banner"></a>
									<br ><br > <a  href="https://b2bservice.su/" target="_blank"><img  src="/img/banners/betobe-3.jpg"
																									   title="b2bservice.su" alt="b2bservice.su"
																									   class="img-responsive img-banner"></a>
									<br ><br > <a  href="http://www.proagro.su/" target="_blank"><img  src="/img/banners/proagro-2.jpg"
																									   title="www.proagro.su" alt="www.proagro.su"
																									   class="img-responsive img-banner"></a>
									<br ><br > <a  href="https://b2bservice.su/" target="_blank"><img  src="/img/banners/betobe-3.jpg"
																									   title="b2bservice.su" alt="b2bservice.su"
																									   class="img-responsive img-banner"></a>
									<br ><br > <a  href="http://www.proagro.su/" target="_blank"><img  src="/img/banners/proagro-1.jpg"
																									   title="www.proagro.su" alt="www.proagro.su"
																									   class="img-responsive img-banner"></a>
									<br ><br > <a  href="https://b2bservice.su/" target="_blank"><img  src="/img/banners/betobe-2.jpg"
																									   title="b2bservice.su" alt="b2bservice.su"
																									   class="img-responsive img-banner"></a>
									<br ><br >
									<a  href="http://www.flora-center.ru/" target="_blank"><img  src="/img/banners/101.jpg"
																								 title="flora center" alt="flora center"
																								 class="img-responsive img-banner"></a> <br ><br >
									<div  class="banner-form-box">
										<div  class="banner-form-box-title"><span >тут может быть ваша реклама</span></div>
										<div  class="banner-form-box-button"><a  data-toggle="modal" data-target="#CallMe"
																				 class="v-btn v-btn--is-elevated v-btn--has-bg theme--light v-size--large success btn-success"><span >Заказать</span></a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr role="separator" aria-orientation="horizontal" class="my-0 v-divider theme--light">
				<div class="layout row wrap">
					<div class="flex xs12">


					<?php /*
<div class="container container--fluid">
	<div class="my-3 v-card v-card--flat v-sheet theme--light transparent">
		<div class="v-card__title news-title">
			<div class="spacer"></div>
			<h2 class="h2">Актуальные новости с полей</h2> 
			<div class="spacer"></div>
		</div>
	</div>
	<div class="mb-3 v-card v-card--flat v-sheet theme--light transparent">
		<div class="flex xs12">
			<div class="layout row wrap">
				<div class="swiper-container">
					<div class="swiper-wrapper">
                        @foreach($news as $new)
						<div class="swiper-slide">
							<div class="swiper-slide-box">
								<div class="mx-auto v-card v-sheet theme--light" style="max-width: 400px;">
									<div class="v-card__subtitle pb-0 ">
										{{$new->created_formated}}
									</div>
									<div class="v-card__title"><a href="/news/{{$new->slug}}" class="swiper-slide-title">{{$new->title}}</a></div>
									<div class="v-card__text swiper-slide-text text--primary">
										<div>{{$new->description}}</div>
									</div>
									<div class="v-card__actions"><a href="/news/{{$new->slug}}" target="_blank" 
									class="v-btn v-btn--text theme--light v-size--default primary--text swiper-slide-btn">
									<span class="v-btn__content">Просмотр</span></a></div>
								</div>
							</div>
						</div>
                        @endforeach
					</div>
					<div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></div>
					<div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="false"></div>
					<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
				</div>
			</div>
		</div>
	</div>
</div>
*/?>
					<!--<slider_block />-->

					</div>
				</div>
				<hr role="separator" aria-orientation="horizontal" class="my-0 v-divider theme--light">
				<div class="layout row wrap">
					<div class="flex xs12">
						<div class="container container--fluid">
							<div class="my-3 v-card v-card--flat v-sheet theme--light transparent">
								<div class="v-card__title brend-title">
									<div class="spacer"></div>
									<h2 class="h2">На нашей площадке вы можете приобрести продукцию мировых брендов</h2>
									<div class="spacer"></div>
								</div>
							</div>
							<div class="ma-auto v-card v-card--flat v-sheet theme--light transparent">
								<div class="flex float-left xs2"><a href="#"><img src="/img/banners/1.jpg" title="" alt="" class="img-responsive img-brend"></a></div>
								<div class="flex float-left xs2"><a href="#"><img src="/img/banners/2.jpg" title="" alt="" class="img-responsive img-brend"></a></div>
								<div class="flex float-left xs2"><a href="#"><img src="/img/banners/3.jpg" title="" alt="" class="img-responsive img-brend"></a></div>
								<div class="flex float-left xs2"><a href="#"><img src="/img/banners/4.jpg" title="" alt="" class="img-responsive img-brend"></a></div>
								<div class="flex float-left xs2"><a href="#"><img src="/img/banners/5.jpg" title="" alt="" class="img-responsive img-brend"></a></div>
								<div class="flex float-left xs2"><a href="#"><img src="/img/banners/115.jpg" title="" alt="" class="img-responsive img-brend"></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>


@endsection



