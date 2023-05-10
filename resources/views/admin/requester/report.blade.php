@section('title', 'Отчет ОРС')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <requester_report :user_id="{{Auth::id()}}"/>
        </div>
    </div>
</div>

@endsection
