@section('title', 'Заявка или сделка')
@extends('admin.template')

@section('main')
<?PHP use App\Models\User; ?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div id="app">
			<requester_card :user_id="{{Auth::id()}}" :new="false"/>
		</div>
	</div>
</div>


@endsection
@push('scripts')
@endpush