@section('title', 'Добавить начисление')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <billing_create :user_id="{{Auth::id()}}"/>
        </div>
    </div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush