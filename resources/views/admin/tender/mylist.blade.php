@section('title', 'Мои тендеры')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <tender_list :user_id="{{Auth::id()}}" :status="[1, 2]" :type="'drop'" :own="true" :now="true" deleted="false" />
        </div>
    </div>
</div>

@endsection
