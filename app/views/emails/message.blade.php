@extends('emails.template')

@section('content')
	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		From Email: {{ $from_email }}
	</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		Message: {{ $text }}
	</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		Timestamp: {{ $timestamp }}
	</p>
@endsection
