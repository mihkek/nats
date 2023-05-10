@section('title', 'Сообщения')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
	<div class="page-content">
		<div id="app">
			<messages_list :user_id="{{Auth::id()}}" :is_new="false"/>
		</div>
	</div>
</div>


@endsection
@push('scripts')
@endpush