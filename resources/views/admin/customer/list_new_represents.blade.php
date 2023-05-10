@section('title', 'Список покупателей')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
	<div class="page-content">
		<div id="app">
			<customers_list :user_id="{{Auth::id()}}" :listnew="true"/>
		</div>
	</div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush