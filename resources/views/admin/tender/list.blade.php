@section('title', 'Активные тендеры')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">

            <tender_list :user_id="{{Auth::id()}}" :status="[1]" :type="'drop'" :now="true" :own="false"/>




        </div>
    </div>
</div>




@endsection
