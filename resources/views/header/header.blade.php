<header class="elevation-2 v-sheet theme--light rounded-0 v-toolbar v-app-bar v-app-bar--clipped v-app-bar--fixed" style="height: 50px; margin-top: 0px; transform: translateY(0px); left: 0px; right: 0px; background-color: rgb(255, 255, 255); border-color: rgb(255, 255, 255);" data-booted="true">
	<div class="v-toolbar__content" style="height: 50px;">
		<nav class="navbar navbar-default navbar-fixed-top" style="background-color: rgb(255, 255, 255);">
			<div class="container-fluid" style="padding-right: 35px; padding-left: 25px;">
				<div class="navbar-header"><button type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button> <a href="/" class="navbar-brand" style="padding: 2px 20px;"><img src="/img/logo/on-white-middle1.png" alt="" style="height: 45px;"></a></div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li>
							@if ($_SERVER['REQUEST_URI'] === "/")
							<a class="active">Главная</a>								
							@else
							<a href="/">Главная</a>
							@endif
						</li>
						<li>
							@if ($_SERVER['REQUEST_URI'] === "/about_service")
							<a class="active">О проекте</a>								
							@else
							<a href="/about_service">О проекте</a>
							@endif	
						</li>		
						<li>							
							<a data-toggle="modal" data-target="#CallMeSaturn">Регистрация в САТУРН</a>
						</li>	
						<li>
							@if ($_SERVER['REQUEST_URI'] === "/tenders")
							<a class="active">Все тендеры</a>								
							@else
							<a href="/tenders">Все тендеры</a>
							@endif								
							
						</li>
						<!--<li>
							@if ($_SERVER['REQUEST_URI'] === "/sales")
							<a class="active">Все распродажи</a>								
							@else
							<a href="/sales">Все распродажи</a>
							@endif						
						</li>-->
						<!--<li>
							@if ($_SERVER['REQUEST_URI'] === "/history")
							<a class="active">История ставок</a>								
							@else
							<a href="/history">История ставок</a>
							@endif
						</li>-->

						<li>
							@if ($_SERVER['REQUEST_URI'] === "/news")
							<a class="active">Блог</a>								
							@else
							<a href="/news">Блог</a>
							@endif							
							
						</li>
						<li>
							<a href="/registration">Регистрация</a>
						</li>
						<li>
							<a href="/login">Вход</a>
						</li>						
					</ul>
				</div>
			</div>
		</nav>
		<div class="clearfix"></div>
	</div>
</header>