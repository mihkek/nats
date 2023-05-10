@section('title', 'Активные распродажи')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <sale_list :user_id="{{Auth::id()}}" :status="[1]" :type="'sale'" :now="true" :own="false" />
        </div>
    </div>
</div>

@endsection
