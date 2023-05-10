@section('title', 'Персональные настройки')
@extends('admin.template')

@section('main')
    <div class="page-content-wrapper">
		<div class="page-content">
    	    <div id="app">
    	        <personal_settings :user_id="{{Auth::id()}}"/>
    	    </div>
		</div>
    </div>
@endsection
@push('scripts')
@endpush