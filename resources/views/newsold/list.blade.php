@section('title', 'VISTA - Новости и события')
@section('description', 'Все самые свежие новости о Финансовой Группе «ВИСТА» на нашем сайте. Открытия, запуски новых продуктов и интеграции с нашими партнерами.')
@extends('template')


@section('main')





<!--{{--############################# ЗАГОЛОВОК ######################################--}}-->
<section class="page-title bg-overlay-black-50 parallax" data-jarallax='{"speed": 0.6}' style="background-image: url(/img_public/bg/01.jpg);">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="page-breadcrumb">
					<li><a href="/"><i class="fa fa-home"></i> Главная</a> 
					<i class="fa fa-angle-double-right"></i></li>
					<li><a href="/about">О нас</a> 
				</ul>
				<div class="page-title-name">
					<h1 class="text-black">Новости и события</h1>
					<p class="text-black">VISTA - больше чем деньги</p>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="line01"></div>
<!--{{--############################# / ЗАГОЛОВОК ######################################--}}-->







<section class="page-section-ptb">
   <div class="container">






	<div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-30">
          <div class="card">
            <a href="/news/2019/06/14/add-market" style="height:100%;"><img class="card-img-top" src="/img_public/temp/category/06.jpg" alt=""></a>
            <div class="card-body">
              <h5 class="card-title">Уважаемые коллеги, мы рады сообщить Вам о пополнении в рядах наших партнеров-магазинов.</h5>
              <p class="card-text">
              </p>
              <a href="/news/2019/06/14/add-market" class="btn btn-lg btn-primary">Читать подробнее</a>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-30">
          <div class="card">
            <a href="/news/2019/06/15/integration" style="height:100%;"><img class="card-img-top" src="/img_public/temp/category/07.jpg" alt=""></a>
            <div class="card-body">
              <h5 class="card-title">Сегодня у нас для Вас отличная новость.</h5>
              <p class="card-text"></p>
              <a href="/news/2019/06/15/integration" class="btn btn-lg btn-primary">Читать подробнее</a>
            </div>
          </div>
        </div>

	  <div style="width:100%;" class="clearfix visible-sm visible-xs"></div><!--1-->

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-30">
          <div class="card">
            <a href="/news/2019/06/16/operation" style="height:100%;"><img class="card-img-top" src="/img_public/temp/category/08.jpg" alt=""></a>
            <div class="card-body">
              <h5 class="card-title">Для вашего удобства мы усовершенствовали систему отчетности.</h5>
              <p class="card-text"></p>
              <a href="/news/2019/06/16/operation" class="btn btn-lg btn-primary">Читать подробнее</a>
            </div>
          </div>
        </div>

        

	  <div style="width:100%;" class="clearfix"></div><!--2-->

        

	  <div style="width:100%;" class="clearfix visible-sm visible-xs"></div><!--1-->

        

	  <div style="width:100%;" class="clearfix"></div><!--2-->



     </div>





   </div>
 </section>











@endsection('main')
