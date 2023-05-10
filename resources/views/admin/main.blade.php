@section('title', 'Личный кабинет')
@extends('admin.template')

@section('main')






    <div class="page-content-wrapper">
        <div class="page-content">





            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="portlet light">
                        <div class="card-icon main-page-icon">
                            <span class="fa fa-plus font-blue"> </span>
                        </div>
                        <div class="card-title">
                            <span> ЗАПОЛНИТЬ ШАБЛОН </span>
                        </div>
                        <div class="card-desc">
                            <span>Создать документ на основа одного из шаблонов</span>
                        </div>
                        <p style="text-align: center;">
                            <a href="/admin/templater/add" class="btn blue"> ЗАПОЛНИТЬ&nbsp;&nbsp;
                                <i class="fa fa-arrow-right"></i></a>
                        </p>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="portlet light">
                        <div class="card-icon main-page-icon">
                            <span class="icon-folder font-blue"> </span>
                        </div>
                        <div class="card-title">
                            <span> ВСЕ ДОКУМЕНТЫ </span>
                        </div>
                        <div class="card-desc">
                            <span>Все мои документы, заполненные ранее</span>
                        </div>
                        <p style="text-align: center;">
                            <a href="/admin/documenter/list" class="btn blue"> ПОСМОТРЕТЬ&nbsp;&nbsp;
                                <i class="fa fa-arrow-right"></i></a>
                        </p>
                    </div>
                </div>


            </div>
            <div class="row">



                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="portlet light">
                        <div class="card-icon main-page-icon">
                            <span class="icon-link font-blue"> </span>
                        </div>
                        <div class="card-title">
                            <span> МОЙ ПРОФИЛЬ </span>
                        </div>
                        <div class="card-desc">
                            <span>Личный данные, контакты, и прочие настройки</span>
                        </div>
                        <p style="text-align: center;">
                            <a href="/admin/settings/personal" class="btn blue"> ИЗМЕНИТЬ&nbsp;&nbsp;
                                <i class="fa fa-arrow-right"></i></a>
                        </p>
                    </div>
                </div>



                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="portlet light">
                        <div class="card-icon main-page-icon">
                            <span class="icon-earphones font-blue"> </span>
                        </div>
                        <div class="card-title">
                            <span> ПОДДЕРЖКА </span>
                        </div>
                        <div class="card-desc">
                            <span>Задайте нам вопрос в режиме онлайн</span>
                        </div>
                        <p style="text-align: center;">
                            <a href="/admin/helpdesk" class="btn blue"> ПЕРЕЙТИ&nbsp;&nbsp;
				    	<i class="fa fa-arrow-right"></i></a>
                        </p>
                    </div>
                </div>



            </div>









        </div> <!-- Page Content Wrapper -->
    </div> <!-- Page Container -->

















{{--
    <link rel="stylesheet" type="text/css" href="/css/public_colors.css" />

@php 		
$ratings = config('ratings');
@endphp
    <div class="page-content-wrapper">
        <div class="page-content">



				<div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a href="/admin/billing/cards" class="dashboard-stat dashboard-stat-v2 blue">
                                    <div class="visual">
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number" style="font-size:22px; line-height:normal; font-weight:600;">
                                            {!! $tariffs[ $user->tariff]['logo'] !!}
                                        </div>
                                        <div class="desc" style="margin-top:10px;"> Текущий тариф </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a href="/admin/rating/history#settings" class="dashboard-stat dashboard-stat-v2 red">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number" style="font-size:22px; line-height:normal; font-weight:600;">
                                            {!! $rating->logo !!}
                                        </div>
                                        <div class="desc" style="margin-top:10px;"> Текущий рейтинг</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a href="/admin/rating/history" class="dashboard-stat dashboard-stat-v2 green">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="{{ $rating->price_to - $rating->total +0.01 }}">{{ $rating->price_to - $rating->total +0.01 }}</span>
                                        </div>
                                        <div class="desc"> Баллов до уровня </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

					@if ($user->tariff == 'STANDARD' || $user->tariff == 'GOLD')
                                <a href="/admin/billing/earning" class="dashboard-stat dashboard-stat-v2 purple">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <span data-counter="counterup" data-value="{{ $tariffs[$user->tariff]['tsp_license'] }}">{{ $tariffs[$user->tariff]['tsp_license'] }}</span></div>
                                        <div class="desc"> Активных лицензий </div>
                                    </div>
                                </a>
					@else
                                <a href="/admin/settings/tsp" class="dashboard-stat dashboard-stat-v2 purple">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <span data-counter="counterup" data-value="{{ $tariffs[$user->tariff]['tsp_license'] }}">{{ $tariffs[$user->tariff]['tsp_license'] }}</span></div>
                                        <div class="desc"> Активных лицензий </div>
                                    </div>
                                </a>
					@endif

                            </div>
                        </div>





            <div class="row">



@if ($balance > 0)
                <div class="col-md-9">
		    <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-cursor font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">
							  	<i class="icon-speedometer"></i> Твои доходы по месяцам
							</span>
                                        </div>
                                    </div>
		    <div class="portlet-body">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Месяц', 'Общая выручка', 'Выручка по бонусам', 'Выручка по кэшбэку'],
			@foreach ($stats as $stat)
			["{{ Helpers::$monthsNominative[$stat->month] }}", {{ $stat->total }}, {{ $stat->total1 }}, {{ $stat->total2 }}],
			@endforeach
		]);

		var options = {
			curveType: 'none',
			legend: { position: 'bottom' },
			vAxis: { format: '# руб'  },
			width: '100%',
			height: 312,
			animation: {startup: true, duration: 2000, easing: 'out'},
			pointSize: 10,
			chartArea:{left:100, top:20, bottom:80, width:'100%',height:'100%'}
		};

		var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
		chart.draw(data, options);
	}
</script>
<div id="curve_chart"></div>

                </div>
                </div>
                </div>
@else
                <div class="col-md-9 hidden-xs hidden-sm">
			    <div class="portlet light bordered" style="min-height:390px;">
			    		<div class="text-center" 
					style='font-size: 36px; font-weight: 300; line-height: 1.1; font-family: "Open Sans",sans-serif;'>
						<br /><br />
						Хочешь не&nbsp;только экономить, но и&nbsp;зарабатывать?
						<br /><br />
						Присоединяйся к&nbsp;нашей команде!
					</div>
      	          </div>
                </div>
@endif



                <div class="col-md-3">
					<div class="portlet light bordered">
                                    <div class="portlet-body">
                                                <!--begin: widget 1-3 -->
                                                <div class="mt-widget-1">
                                                    <div class="mt-img">
                                                        <a href="/admin/settings/personal"><img src="{{ User::getAvatar($user->id, 'medium') }}" style="max-width:150px; max-height:150px; border-radius:50%!important;"></a>
								    </div>
                                                    <div class="mt-body">
                                                        <h3 class="mt-username">{{ $user->name_family }} {{ $user->name }} {{ $user->name_patronymic }}</h3>
                                                        <p class="mt-user-title"> {{ $user->email }}<br />{{ $user->phone }} </p>
									  <div class="mt-stats">
                                                            <div class="btn-group btn-group btn-group-justified">
                                                                <a href="/admin/settings/personal" class="btn font-red">
                                                                     Профиль</a>
                                                                <a href="/admin/helpdesk" class="btn font-green">
                                                                     Поддержка</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end: widget 1-3 -->
                                    </div>
                                </div>

                </div>

            </div>


@include('admin.afillater.afilliate_matrix')


            <div class="row">



@if ($balance > 0)
                <div class="col-md-6">
<style>
.easy-pie-chart .number {
    font-size: 14px!important;
    position: relative;
    text-align: center;
    height: 75px;
    line-height: 75px
}
.easy-pie-chart .number canvas {
    position: absolute;
    top: 0;
    left: 0
}
.easy-pie-chart,.sparkline-chart {
    text-align: center
}
.easy-pie-chart .number {
    font-weight: 500;
    width: 85px;
    margin: 0 auto
}
.easy-pie-chart .number span {
    padding-right:8px;
}
.easy-pie-chart .title {
    display: block;
    text-align: center;
    color: #333;
    font-weight: 600;
    font-size: 16px;
    margin-top: 5px;
    margin-bottom: 10px;
    padding-right:8px;
}
.easy-pie-chart .title:hover {
    color: #666;
    text-decoration: none
}
.easy-pie-chart .title>i {
    margin-top: 5px
}
</style>

					<div class="portlet light bordered">

                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-cursor font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">
							  	<i class="icon-speedometer"></i> Твои бонусы
							</span>
                                        </div>
                                    </div>

                                    <div class="portlet-body">
                                        <div class="row">

                                            <div class="col-xs-6 col-sm-3">
                                                <div class="easy-pie-chart">
                                                    <div class="number color1" data-percent="{{ $stats_tariffs->percent2 }}">
                                                        <span>{{ $stats_tariffs->percent2 }}%</span> 
									  <canvas height="75" width="75"></canvas></div>
                                                    <div class="title"><span class="vista-box vista-box-sm"><span class="left">V</span><span class="right vista-gold-bg">G<span class="hidden-sm hidden-md">OLD</span></span></span></div>
                                                </div>
                                            </div>
                                            <div class="margin-bottom-10 visible-sm"> </div>

                                            <div class="col-xs-6 col-sm-3">
                                                <div class="easy-pie-chart">
                                                    <div class="number color2" data-percent="{{ $stats_tariffs->percent3 }}">
                                                        <span>{{ $stats_tariffs->percent3 }}%</span> 
									  <canvas height="75" width="75"></canvas></div>
                                                    <div class="title"><span class="vista-box vista-box-sm"><span class="left">B</span><span class="right vista-start-bg">ST<span class="hidden-sm hidden-md">ART</span></span></span></div>
                                                </div>
                                            </div>
                                            <div class="margin-bottom-10 visible-sm"> </div>

                                            <div class="col-xs-6 col-sm-3">
                                                <div class="easy-pie-chart">
                                                    <div class="number color3" data-percent="{{ $stats_tariffs->percent4 }}">
                                                        <span>{{ $stats_tariffs->percent4 }}%</span> 
									  <canvas height="75" width="75"></canvas></div>
                                                    <div class="title"><span class="vista-box vista-box-sm"><span class="left">B</span><span class="right vista-optimum-bg">OPT<span class="hidden-sm hidden-md">IMUM</span></span></span></div>
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-3">
                                                <div class="easy-pie-chart">
                                                    <div class="number color4" data-percent="{{ $stats_tariffs->percent5 }}">
                                                        <span>{{ $stats_tariffs->percent5 }}%</span> 
									  <canvas height="75" width="75"></canvas></div>
                                                    <div class="title"><span class="vista-box vista-box-sm"><span class="left">B</span><span class="right vista-max-bg">MAX</span></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>	
					  	    
		    </div>
@else
                <div class="col-md-6 hidden-xs hidden-sm">
			    <div class="portlet light bordered" style="min-height:207px;">
			    		<div class="text-center" 
					style='font-size: 36px; font-weight: 300; line-height: 1.1; font-family: "Open Sans",sans-serif;'>
						<br />
						Пройти обучение
					</div>
					<br />
			    		<div class="text-center">
						<a href="/admin/support/learning" class="btn btn-primary">
							<i class="icon-arrow-right"></i>&nbsp;&nbsp;ПЕРЕЙТИ</a>
					</div>
      	          </div>
                </div>
@endif


                <div class="col-md-6">


					<div class="portlet light bordered">

                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-bubble font-dark hide"></i>
                                            <span class="caption-subject font-hide bold uppercase">
							  	<i class="icon-speedometer"></i> Лидеры рейтинга
							   </span>
                                        </div>
                                    </div>

                                    <div class="portlet-body">
                                        <div class="row">

@foreach ($leaders as $row)
                                            <div class="col-xs-4">
                                                <!--begin: widget 1-1 -->
                                                <div class="mt-widget-1" style="border:0px;">
                                                    <div class="mt-img" style="margin:0px;">
                                                        <img src="{{ $row['avatar'] }}"> </div>
                                                    <div class="mt-body">
                                                        <h3 class="mt-username">{{ ceil($row['summ']) }}</h3>
                                                        <p class="mt-user-title" style="margin:8px;">{{ $row['name'] }}</p>
                                                    </div>
                                                </div>
                                                <!--end: widget 1-1 -->
                                            </div>
@endforeach

                                        </div>
                                    </div>
                                </div>

		    </div>


		</div>


        </div> <!-- Page Content Wrapper -->
    </div> <!-- Page Container -->
--}}






@endsection
@push('scripts')
{{--
<script type="text/javascript" src="/js/jquery.easypiechart.min.js"></script>
<script>
jQuery(document).ready(function() {
            $('.easy-pie-chart .number.color1').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 6,
		    barColor: '#FFFB4E'
            });
            $('.easy-pie-chart .number.color2').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 6,
		    barColor: '#B9B5E0'
            });
            $('.easy-pie-chart .number.color3').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 6,
		    barColor: '#2FCA9B'
            });
            $('.easy-pie-chart .number.color4').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 6,
		    barColor: '#2BB2EB'
            });
});
</script>
--}}
@endpush
