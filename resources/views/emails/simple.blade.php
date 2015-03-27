@extends('emails.template')

@section('content')
	@foreach ($paragraphs as $paragraph)
	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		{!! $paragraph !!}
	</p>
	@endforeach
@endsection
