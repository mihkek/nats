@section('title', 'Новости и события')
@extends('admin.template')


@section('main')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div id="app">
                <news :user_id="{{Auth::id()}}"/>
            </div>
        </div>
    </div>
@endsection('main')
