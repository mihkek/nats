@section('title', 'Карточка аукциона')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <auction_card :user_id="{{Auth::id()}}" :new="false" :type="'rise'"/>
        </div>
    </div>
</div>

@endsection
