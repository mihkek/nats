@section('title', 'Занятие')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
	<div class="page-content">
		<div id="app">
			<orderer_card :user_id="{{Auth::id()}}" :new="false"/>
		</div>
	</div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush