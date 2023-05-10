@section('title', 'Мои аукционы')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <auction_list :user_id="{{Auth::id()}}" :status="[1,2,3]" :type="'rise'" :own="true" />
        </div>
    </div>
</div>

@endsection
