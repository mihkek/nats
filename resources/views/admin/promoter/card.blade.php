@section('title', 'Карточка промоутера')
@extends('admin.template')

@section('main')
<div class="page-content-wrapper">
	<div class="page-content">
		<div id="app">
			<promoter_card :user_id="{{Auth::id()}}" :new="false" :item_id="{{$promoter->id}}"/>
		</div>
	</div>
</div>

@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush