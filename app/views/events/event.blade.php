@extends('events.template')

@section('page')

	<h1>{{ $event->title }}</h1>

	{{ $event->description }}

@endsection