@section('title', 'VISTA - Новость')
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
					<li><a href="/news">Все новости</a> 
				</ul>
				<div class="page-title-name">
					<h1 class="text-black">Для вашего удобства мы усовершенствовали систему отчетности.
</h1>
					<p class="text-black">VISTA - больше чем деньги</p>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="line01"></div>
<!--{{--############################# / ЗАГОЛОВОК ######################################--}}-->






<section class="white-bg page-section-ptb">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">

				<img src="/img_public/texts/09.jpg" alt="" style="float:right; width:50%; margin:0 0 20px 20px;" />
				<p>Приветствуем. Надеемся, что теперь вы очень просто и легко сможете получать всю информацию о всех операциях, связанных с вашими операциями и деятельностью вашей команды.</p>


			</div>
		</div>
	</div>
</section>








@endsection('main')
