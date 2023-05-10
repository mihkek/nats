@section('title', 'Персональные настройки')
@extends('admin.template')

@section('main')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div id="app">
                <block_supliers :subliers="{{$block_subliers}}" :user_id="{{Auth::id()}}"/>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
