@extends('publications.template')

@section('page')

	<h1>{{ $publication->title }}</h1>
	{{ $publication->description }}

@endsection