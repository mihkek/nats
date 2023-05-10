@extends('emails.email_template')

@section('main')
	
    @if ($who == 'all')
    	Все стороны подтвердили свои реквизиты в <a href="{{ route('auction_now_card', ['id' => $auction->id]) }}">@if ($auction->type == 'rise') аукционе @else тендере @endif №{{$auction->id}}</a>
    @else
    	@if ($who == 'customer') Покупатель @else Продавец @endif подтвердил свои реквизиты в @if ($auction->type == 'rise') аукционе @else тендере @endif №{{$auction->id}}. Просим вас также проверить и подтвердить свои реквизиты в карточке <a href="{{ route('auction_now_card', ['id' => $auction->id]) }}">@if ($auction->type == 'rise') аукциона @else тендера @endif №{{$auction->id}}</a>.
    @endif
	<br>
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Выйгравшее предложение
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<b><br>{{ $rate }}</b>
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
				<br><b><a HREF="{{ $conferenceUrl }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;"> {{ $conferenceUrl }}</a></b>
			</TD>
		</TR>
	</TABLE>
	
    @if ($who == 'all')
	<p STYLE="color:#373d43; font-size:18px; font-family:Arial,Sans-serif;">
	Теперь вы можете скачать и распечатать договор, подписать его и загрузить отсканированные подписанные страницы договора <a HREF="{{ $conferenceUrl }}">на&nbsp;странице@if ($auction->type == 'rise') аукциона@else тендера@endif</a>. 
	</p>
    @endif
	
@endsection