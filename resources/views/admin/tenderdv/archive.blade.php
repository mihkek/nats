@section('title', 'Архив тендеров ДВ')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <tenderdv_list :user_id="{{Auth::id()}}" :status="[2]" :type="'dropdv'" :now="false" :own="true"/>
        </div>
    </div>
</div>

@endsection
