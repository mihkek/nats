@section('title', 'Календарь занятий')
@extends('admin.template')

@section('main')
	<link href='/engines/fullcalendar-4.3.1/packages/core/main.css' rel='stylesheet' />
	<link href='/engines/fullcalendar-4.3.1/packages/daygrid/main.css' rel='stylesheet' />
	<link href='/engines/fullcalendar-4.3.1/packages/timegrid/main.css' rel='stylesheet' />
	<link href='/engines/fullcalendar-4.3.1/packages/list/main.css' rel='stylesheet' />
	<style>
		.fc-button-primary {
			border-radius: 50px!important;
			background-color: #377BB5!important;
			border-color: #377BB5!important;
		}
	</style>


	<div class="page-content-wrapper">
		<div class="page-content">
			<div id="app">
				<orderer_calendar :user_id="{{Auth::id()}}" />
			</div>
		</div>
	</div>
@endsection
