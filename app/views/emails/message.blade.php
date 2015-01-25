@extends('emails.template')

@section('content')
	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		From Email: {{ $from }}
	</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		Message: {{ $message }}
	</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		Timestamp: {{ $timestamp }}
	</p>
@endsection
