@extends('emails.email_template')

@section('main')
	

	Новое сообщение {{ $auction_id }} № {{ $auction_title }}.<br>
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Сообщение
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<b><br>{{ $message_text }}</b>
			</TD>
		</TR>
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>От 
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<b><br></b>
			</TD>
		</TR>
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>
				{{ $auction_title }}
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b><a HREF="{{ $link_card }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;"> {{ $link_card }}</a></b>
			</TD>
		</TR>
	</TABLE>

@endsection