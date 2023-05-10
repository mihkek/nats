@section('title', 'Тендеры покупателя')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <user_tender_list :user_id="{{Auth::id()}}" :status="[1]" :type="'drop'" :own="false" :now="true" deleted="false" :author_user_id="{{$author_user_id}}" />
        </div>
    </div>
</div>

@endsection
