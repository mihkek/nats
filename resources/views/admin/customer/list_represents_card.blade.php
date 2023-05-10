@section('title', 'Карточка покупателя')
@extends('admin.template')

@section('main')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div id="app">
                <customer_card :user_id="{{Auth::id()}}" :new="false" :user="{{Auth::user()}}"/>
            </div>
        </div>
    </div>

    @include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
@endpush
