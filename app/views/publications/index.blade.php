@extends('publications.template')

@section('page')
	<h1>{{ $title }}</h1>

	<ul>
	@foreach ($publications as $publication)
		<li><a href="/publications/{{ $publication->slug }}">{{ $publication->title }}</a></li>
	@endforeach
	</ul>

@endsection