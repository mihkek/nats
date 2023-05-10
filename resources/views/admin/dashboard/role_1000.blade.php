@section('title', 'Кабинет администратора')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <admin_dashboard :user_id="{{Auth::id()}}"/>
        </div>
    </div>
</div>

@include('admin.orderer._modals')
@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush
