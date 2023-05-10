@section('title', 'Новый тендер')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <new_tender_card :user_id="{{Auth::id()}}" :new="true" :type="'drop'"/>
        </div>
    </div>
</div>

@endsection
