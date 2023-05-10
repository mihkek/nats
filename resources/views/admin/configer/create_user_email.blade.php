@extends('emails.email_template')

@section('main')

	@lang('user.save_email_text')<br>
	@lang('user.email_change_pass_text') «<a HREF="{{ Config('global.project.url') }}/admin/settings/" STYLE="color:#373d43; font-size:14px; 
	font-family:Arial,Sans-serif;">@lang('user.email_change_pass_link')</a>»<br>

	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">

		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>@lang('user.password')
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b>{{ $plainPassword }}</b>
			</TD>
		</TR>

		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>@lang('user.email_login')
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b><a HREF="mailto:{{ $emailTo }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif; 
					text-decoration:none;">{{ $emailTo }}</a></b>
			</TD>
		</TR>

		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>@lang('user.cabinet_address')
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b><a HREF="{{ Config('global.project.url') }}/admin" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
					{{ Config('global.project.url') }}/admin</a></b>
			</TD>
		</TR>

	</TABLE>

@endsection