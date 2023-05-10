@extends('emails.email_template')

@section('main')

	<a href="{{ route('orderer_card', ['id' => $orderer->id]) }}">Видеозанятие</a>
	начнется через 10 минут.<br>
	Чтобы @if ($userType == 'directory_person') начать занятие, @else присоединиться к занятию, @endif перейдите по ссылке ниже:

	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Ссылка
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b><a HREF="{{ $conferenceUrl }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;"> {{ $conferenceUrl }}</a></b>
			</TD>
		</TR>

	</TABLE>

@endsection