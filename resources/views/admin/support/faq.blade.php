@section('title', 'Частые вопросы (FAQ)')
@extends('admin.template')
@section('main')


<div class="page-content-wrapper">
	<div class="page-content">
        <div id="app">
            <faq :user_id="{{Auth::id()}}"/>
        </div>
	</div>
</div>

@endsection
@push('scripts')
@endpush
