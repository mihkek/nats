@section('title', 'Группы клиентов')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
	<div class="page-content">
		<div id="app">
			<customers_groups :user_id="{{Auth::id()}}" :is_delete="true" />
		</div>
	</div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush