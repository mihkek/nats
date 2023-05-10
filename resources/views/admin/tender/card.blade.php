@section('title', 'Карточка тендера')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <tender_card :user_id="{{Auth::id()}}" :new="false" :type="'drop'"/>
        </div>
    </div>
</div>

@endsection
