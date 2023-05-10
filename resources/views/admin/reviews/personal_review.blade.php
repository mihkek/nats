@section('title', 'Оставить отзыв')
@extends('admin.template')

@section('main')

    <div class="page-content-wrapper">
		<div class="page-content">
			@if ($user->role_id == 101 || $user->role_id == 1000)
			<div id="app">
				<personal_review :user_id="{{Auth::id()}}"/>
			</div>
			@else
				Вы не можете оставить отзыв
			@endif
		</div>
    </div>
@endsection
@push('scripts')
@endpush