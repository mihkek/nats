@section('title', 'Поддержка и помощь')
@extends('admin.template')

@section('main')
    <div class="page-content-wrapper">
        <div class="page-content">
        	<div id="app" style="margin-bottom: 0 !important;">
            	<support_service :user_id="{{Auth::id()}}">
        	</div>
            <div class="row">
                <div class="col-lg-12">

<iframe style="width: 100%; height: 600px; border: 0;" frameborder="0" src="{{ Config('reformal.url') }}"></iframe>

                </div>
            </div>

        </div>
    </div>
@endsection