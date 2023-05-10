@section('title', 'Архив распродаж')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <sale_list :user_id="{{Auth::id()}}" :status="[1,2,3]" :type="'sale'" :now="false" :own="true" />
        </div>
    </div>
</div>

@endsection
