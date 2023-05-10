@section('title', 'Карточка распродажи')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <sale_card :user_id="{{Auth::id()}}" :new="false" :type="'sale'"/>
        </div>
    </div>
</div>

@endsection
