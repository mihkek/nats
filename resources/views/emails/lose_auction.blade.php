@extends('emails.email_template')

@section('main')
	

    <a href="{{ route('auction_now_card', ['id' => $auction->id]) }}">@if ($auction->type == 'rise') Аукцион @else Тендер @endif №{{$auction->id}}</a> был завершен. Ваша ставка проиграла.
	<br>
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Выйгравшее предложение
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<b><br>{{ $rate }} ₽/{{ $auction->unit }}</b>
			</TD>
		</TR>
        <TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Ваша ставка
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<b><br>{{ $lose_rate }} ₽/{{ $auction->unit }}</b>
			</TD>
		</TR>
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>@if ($auction->type == 'rise') Аукцион @else Тендер @endif
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b><a HREF="{{ $conferenceUrl }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;"> {{ $conferenceUrl }}</a></b>
			</TD>
		</TR>
	</TABLE>

@endsection