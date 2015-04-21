@extends('emails.template')

@section('content')
	<p style="margin: 0 0 20px 0;">Encountered by {{ $user }} on {{ $file }} at line {{ $line }}.</p>
	<p style="margin: 0 0 20px 0;">URL: <a href="{{ $url }}" style="color: {{ $green }};">{{ $url }}</a>.</p>
	@if (!empty($previous))
	<p style="margin: 0 0 20px 0;">Previous: <a href="{{ $previous }}" style="color: {{ $green }};">{{ $previous }}</a>.</p>
	@endif
@endsection