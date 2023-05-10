@section('title', 'Заявки в работе')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <requester_list :user_id="{{Auth::id()}}" :status="[1,2,3,4,5,6]" :now="true"/>
        </div>
    </div>
</div>

@endsection
