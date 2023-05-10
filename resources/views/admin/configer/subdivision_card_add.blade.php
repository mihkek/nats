@section('title', 'Новое подразделение')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <subdivision_card :user_id="{{Auth::id()}}" :new="true"/>
        </div>
    </div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush