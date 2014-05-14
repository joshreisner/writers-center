@extends('courses.template')

@section('page')

	<h1>{{ $course->title }}</h1>
	{{ $course->description }}

@endsection