@section('title', 'Новая распродажа')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <new_sale_card :user_id="{{Auth::id()}}" :new="true" :type="'sale'"/>
        </div>
    </div>
</div>

@endsection
