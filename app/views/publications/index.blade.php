@extends('publications.template')

@section('page')

	<div class="page-header">
		<h1>{{ $title }}</h1>
	</div>
	<ul>
	@foreach ($publications as $publication)
		<li><a href="/publications/{{ $publication->slug }}">{{ $publication->title }}</a></li>
	@endforeach
	</ul>

@endsection