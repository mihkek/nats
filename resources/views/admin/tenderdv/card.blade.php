@section('title', 'Карточка тендера ДВ')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <tenderdv_card :user_id="{{Auth::id()}}" :new="false" :type="'dropdv'"/>
        </div>
    </div>
</div>

@endsection
