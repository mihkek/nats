@section('title', 'Архив промоутеров')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
	<div class="page-content">
		<div id="app">
			<promoter_list :user_id="{{Auth::id()}}" :is_delete="true" />
		</div>
	</div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush