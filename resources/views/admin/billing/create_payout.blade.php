@section('title', 'Добавить выплату')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <billing_create_payout :user_id="{{Auth::id()}}"/>
        </div>
    </div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush