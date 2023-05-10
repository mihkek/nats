@section('title', 'Активные аукционы')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <auction_list :user_id="{{Auth::id()}}" :status="[1]" :type="'rise'" :now="true" :own="false" />
        </div>
    </div>
</div>

@endsection
