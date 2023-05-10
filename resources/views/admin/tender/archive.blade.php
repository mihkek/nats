@section('title', 'Архив тендеров')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <tender_list :user_id="{{Auth::id()}}" :status="[2]" :type="'drop'" :now="false" :own="true"/>
        </div>
    </div>
</div>

@endsection
