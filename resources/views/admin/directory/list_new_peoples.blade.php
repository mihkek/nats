@section('title', 'Список поставщиков')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
	<div class="page-content">
		<div id="app">
			<directory_people_list :user_id="{{Auth::id()}}" :listnew="true"/>
		</div>
	</div>
</div>

@endsection
@push('scripts')
@endpush