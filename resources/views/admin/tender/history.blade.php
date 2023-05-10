@section('title', 'История ставок')
@extends('admin.template')
@section('main')

<div class="page-content-wrapper">
    <div class="page-content">
        <div id="app">
            <history_tender_list :user_id="{{Auth::id()}}" :status="[2]" :type="'drop'" :own="false" :now="false" deleted="false" />
        </div>
    </div>
</div>

@endsection
