@extends('emails.template')

@section('content')
	@foreach ($data as $key=>$value)
	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		{{ $key }}: {{ $value }}
	</p>
	@endforeach
@endsection
