@section('title', 'Активные тендеры ДВ')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">

            <tenderdv_list :user_id="{{Auth::id()}}" :status="[1]" :type="'dropdv'" :now="true" :own="false"/>




        </div>
    </div>
</div>




@endsection
