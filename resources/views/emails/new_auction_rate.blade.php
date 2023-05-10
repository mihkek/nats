@extends('emails.email_template')

@section('main')
	

	Сделана новая ставка в 
	<!--<a href="{{ route('auction_now_card', ['id' => $auction->id]) }}">
		@if ($auction->type == 'rise') аукционе @else тендере @endif 
		номер {{$auction->id}}
	</a>-->
	<a href="{{ $conferenceUrl }}">		
		@if ($auction->type == 'drop') тендере  @endif 
		@if ($auction->type == 'rise') аукционе  @endif 
		@if ($auction->type == 'sale') распродаже  @endif 
		номер {{$auction->id}}</a>.<br>
	<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Прошлая ставка
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<b><br>{{ $last_rate }}</b>
			</TD>
		</TR>
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>Новая ставка
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<b><br>{{ $rate }}</b>
			</TD>
		</TR>
		<TR>
			<TD style="padding-right:20px; color:#AAAAAA; font-size:14px; font-family:Arial,Sans-serif;">
				<br>
				@if ($auction->type == 'drop') Тендер  @endif 
				@if ($auction->type == 'rise') Аукцион  @endif 
				@if ($auction->type == 'sale') Распродажа  @endif 
			</TD>
			<TD style="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;">
				<br><b><a HREF="{{ $conferenceUrl }}" STYLE="color:#373d43; font-size:14px; font-family:Arial,Sans-serif;"> {{ $conferenceUrl }}</a></b>
			</TD>
		</TR>
	</TABLE>

@endsection