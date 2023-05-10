@section('title', 'Список занятий')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
	<div class="page-content">
		<div id="app">
			<orderer_list :status="[1,2]" :user_id="{{Auth::id()}}" :now="true"/>
		</div>
	</div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush