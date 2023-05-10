@section('title', 'Архив заявок')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <requester_list :user_id="{{Auth::id()}}" :status="[7]" :now="false"/>
        </div>
    </div>
</div>

@endsection
