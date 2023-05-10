@extends('emails.email_template')

@section('main')
	<b>Ваша регистрация на сайте <a HREF="{{ Config('global.project.url') }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">{{ Config('global.project.url') }}</a> в качестве поставщика подтверждена.</b><br><br>
	<b>Ваши данные для авторизации:</b><br>

	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">

		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Пароль
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b>{{ $plainPassword }}</b>
			</TD>
		</TR>

		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>E-mail (он же логин)
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b><a HREF="mailto:{{ $emailTo }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif; 
					text-decoration:none;">{{ $emailTo }}</a></b>
			</TD>
		</TR>

		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Адрес «Личного кабинета»
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b><a HREF="{{ Config('global.project.url') }}/admin" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
					{{ Config('global.project.url') }}/admin</a></b>
			</TD>
		</TR>

	</TABLE>
	<br>
	Сохраните это письмо на будущее, в нём содержится необходимая для доступа информация.<br>
	Вы можете изменить пароль на удобный и запоминающийся прямо сейчас 
	в «<a HREF="{{ Config('global.project.url') }}/admin/settings/personal" STYLE="color:#373d43; font-size:14px; 
	font-family:Arial,Sans-serif;">Персональных настройках</a>»<br>

@endsection