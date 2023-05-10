@section('title', 'Пригласить друга')
@extends('admin.template')
@section('main')



    <div class="page-content-wrapper">
        <div class="page-content">



            {{--
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light" id="for-service">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-link font-red-mint"></i> 
                                <span class="caption-subject font-red-mint sbold uppercase">Получай до 10% ОТ ПРИГЛАШЁННЫХ ТОБОЙ ДРУЗЕЙ</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            Пригласи своих друзей, опубликуй ссылку в своих соцсетях, да и просто отправь её всем знакомым -
                            и ты будешь получать доход от их платежей. Всегда. Пожизненно.
                        </div>
                    </div>
                </div>
            </div>
            --}}






            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light" id="for-service">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-trophy font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Твоя персональная партнерская ссылка</span>
                            </div>
                        </div>
                        <div class="portlet-body">


					<div class="text-center">
						<span class="personal-link">{{ Config('global.project.url') }}/?ref{{ $referal }}</span><br />

                        <div class="text-center">
							<?PHP
							use App\Models\Barcode;
							$generator = new Barcode();
							$param = Config('global.project.url') . "/?ref" . $referal;
							$options = Array();
							$options['w'] = 250;
							$options['h'] = 250;
							$options['wq'] = 0;
							$result = $generator->output_image("svg", "qr", $param, $options);
							echo $result;
							?>
						</div>

						<br /><br />

						<style>
						.ya-share2__container_size_m .ya-share2__icon {height: 48px; width: 48px;}
						.ya-share2__item_service_moimir .ya-share2__badge {margin-bottom: 4px;}
						</style>
						<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" async="async"></script>
						<script src="//yastatic.net/share2/share.js" async="async"></script>
						<h2>Поделиться ссылкой:</h2>
						<div style="margin-top:-25px;">
							<div class="ya-share2"
							data-services="collections,vkontakte,facebook,odnoklassniki,moimir,pinterest,twitter,blogger,delicious,digg,reddit,evernote,linkedin,lj,viber,whatsapp,skype,telegram"
							data-image="{{ Config("global.project.url") }}/img_public/ico/02.png"
							data-url="{{ Config('global.project.url') }}/?ref{{ $referal }}"
							data-title="{{ Config("global.project.sitename") }}"
							data-description="{{ Config("global.project.sitedescription") }}"
							data-lang="ru"
							data-size="m"
							></div>
						</div>
                        <br /><br />

					</div>


                      		<div>
								Скопируй ссылку, и&nbsp;отправь приятелю.
                     Или даже просто опубликуй её в&nbsp;блоге или в&nbsp;соцсети&nbsp;- пусть заходят все!
                     Чем больше людей ее увидят и&nbsp;кликнут, тем больше будет твой доход.
                                Запрещается рассылать СПАМ, публиковать ссылку на "дорвей"-сайтах, давайть рекламу на&nbspбрэнд, применять Adult-площадки, и&nbsp;использовать другие нелегальные или полу-легальные способы продвижения.

					</div>
                            {{--

                   		<div>
                                * мы можем вручную задать для тебя персональную "красивую" ссылку типа
                                <B>{{ Config("global.project.url") }}/?ref<span class="font-red-soft">XXXXXXXXXXX</span></B>
                                где в конце будет не набор цифр, а внятное слово или цифры.
                                Для этого <a href="/admin/helpdesk">
                                напиши нам</A> свой логин и желаемое имя для ссылки.
					</div>
                            --}}

                        </div><!-- portlet-body -->
                    </div>
                </div>
            </div>




        </div>
    </div>
@endsection