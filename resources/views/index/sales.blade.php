@extends('layouts.main_html')

@section("title", "Распродажи - Национальная Аграрная Тендерная Система (НАТС)")

@section('content')

<div id="app">
<div style="padding: 50px 0px 350px;">
	@if (Auth::id() > 0) 
		<index_sales :user_id="{{Auth::id()}}">
	@else 
		<index_sales :user_id="0">
	@endif
</div>
</div>

@endsection



