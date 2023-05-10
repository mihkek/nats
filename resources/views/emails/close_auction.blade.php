@extends('emails.email_template')

@section('main')
	

    <a href="{{ route('auction_now_card', ['id' => $auction->id]) }}">
		@if ($auction->type == 'rise') Аукцион @else Тендер @endif №{{$auction->id}}</a> был успешно завершен.
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
				<br>Продавец
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<b><br>{{ $supplier }}</b>
			</TD>
		</TR>
		<TR>
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Покупатель
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<b><br>{{ $customer }}</b>
			</TD>
		</TR>
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>@if ($auction->type == 'rise') Аукцион @else Тендер @endif
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b><a HREF="{{ $conferenceUrl }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">{{ $conferenceUrl }}</a></b>
			</TD>
		</TR>
	</TABLE>
	<br>
	<p STYLE="color:#373d43; font-size:18px; font-family:Arial,Sans-serif;">
	Пожалуйста проверьте и&nbsp;подтвердите верность реквизитов для договора <a HREF="{{ $conferenceUrl }}">на&nbsp;странице@if ($auction->type == 'rise') аукциона@else тендера@endif</a>. 
	</p>

	<p STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
	После того как реквизиты будут подтверждены каждой стороной, вы сможете скачать договор для подписания. Мы уведомим вас о&nbsp;доступности договора для скачивания дополнительным сообщением.
	</p>

@endsection