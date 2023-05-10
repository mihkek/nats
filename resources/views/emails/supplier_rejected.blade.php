@extends('emails.email_template')

@section('main')
	<b>Ваша регистрация на сайте <a HREF="{{ Config('global.project.url') }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">{{ Config('global.project.url') }}</a> в качестве поставщика отклонена.</b><br><br>
	<b>{{ $rejectReason }}</b><br>

	<br>
	Если вы считаете данное решение ошибочным, пожалуйста свяжитесь с нами по контактам, указанным в конце любой страницы сайта <a HREF="{{ Config('global.project.url') }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">{{ Config('global.project.url') }}</a>.

@endsection