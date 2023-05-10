<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content=" " />
	<meta name="description" content="@yield('description')" />
	<meta name="author" content="mrnx.ru">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>@yield('title')</title>

	<meta name="verify-admitad" content="c605fcddbf" />

	<link rel="shortcut icon" href="/favicon.png" type="image/png">

	<!-- bootstrap -->
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-3.3.7.min.css">

</head>
<body>
<div class="wrapper">






    <div style="padding: 20px; background-color: #999999; margin-bottom: 20px;">ШАПКА</div>

    @yield('main')

    <div style="padding: 20px; background-color: #999999; margin-top: 20px;">ПОДВАЛ</div>





    <!-- jquery -->
    <script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>

    <!-- bootstrap -->
    <script type="text/javascript" src="/js/bootstrap-3.3.7.min.js"></script>

    @stack('scripts')

</body>
</html>