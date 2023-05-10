@section('title', 'Новый тендер ДВ')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <new_tenderdv_card :user_id="{{Auth::id()}}" :new="true" :type="'dropdv'"/>
        </div>
    </div>
</div>

@endsection
