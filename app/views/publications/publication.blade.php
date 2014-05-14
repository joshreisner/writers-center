@extends('publications.template')

@section('page')

	<div class="page-header">
		<h1>{{ $publication->title }}</h1>
	</div>
	{{ $publication->description }}

@endsection