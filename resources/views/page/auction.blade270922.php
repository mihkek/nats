@extends('layouts.main')

@section("title", "Аукцион №".$auction_id." ".$auction_title)

@section('content')
	@if (Auth::id() > 0) 
		<page_auction :user_id="{{Auth::id()}}" :item_id="{{$auction_id}}">
	@else 
		<page_auction :user_id="0" :item_id="{{$auction_id}}">
	@endif
@endsection



