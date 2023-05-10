@section('title', 'Архив сотрудников организации')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <users_list :user_id="{{Auth::id()}}" :deleted="'on'" />
        </div>
    </div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush