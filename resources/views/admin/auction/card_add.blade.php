@section('title', 'Новый аукцион')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <new_auction_card :user_id="{{Auth::id()}}" :new="true" :type="'rise'"/>
        </div>
    </div>
</div>

@endsection
