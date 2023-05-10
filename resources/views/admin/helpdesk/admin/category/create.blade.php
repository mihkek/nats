@extends($master)
@section('page', trans('ticketit::admin.category-create-title'))

@section('content')
    @include('ticketit::shared.header')

    <legend>{{ trans('ticketit::admin.category-create-title') }}</legend>

    <div class="well bs-component">
        {!! CollectiveForm::open(['route'=> $setting->grab('admin_route').'.category.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            {{--<legend>{{ trans('ticketit::admin.category-create-title') }}</legend>--}}
            @include('ticketit::admin.category.form')
        {!! CollectiveForm::close() !!}
    </div>
@stop
