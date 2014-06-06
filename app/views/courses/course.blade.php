@extends('page')

@section('content')

	<div class="col-md-offset-1">
		<h1>
			{{ $course->title }} {{ CourseController:: editLink($course) }}
			@if (count($course->instructors))
			<small>with {{ CourseController::formatInstructors($course) }}</small>
			@endif
		</h1>

		{{ $course->description }}

		<dl>
			<dt>When</dt>
			<dd>Six Mondays, 1:30&ndash;3:30 p.m.</dd>

			<dt>Dates</dt>
			<dd>January 6&ndash;February 24 (No class on January 20 or February 17)</dd>

			<dt>Tuition</dt>
			<dd>${{ $course->tuition_member }} 
				@if ($course->tuition_member != $course->tuition_outside)
					members/${{ $course->tuition_outside }} non-members
				@endif
			</dd>
		</dl>

		@if (!empty($course->register_url))
		<a class="btn btn-primary" href="{{ $course->register_url }}">Register</a>
		@endif

		@if (count($course->instructors))
			@if (count($course->instructors) == 1)
				<h2>About the Instructor</h2>
			@else
				<h2>About the Instructors</h2>
			@endif

		<ul class="instructors">
			@foreach ($course->instructors as $instructor)
			<li>
				@if (!empty($instructor->image->url))
				<img src="{{ $instructor->image->url }}" width="{{ $instructor->image->width }}" height="{{ $instructor->image->height }}" alt="{{ $instructor->name }}">
				@endif
				{{ $instructor->bio }}
			</li>
			@endforeach
		</ul>
		@endif
	</div>
@endsection

@section('side')
	<div class="wallpaper">
		<span>You might also like</span>
		<h1>
			<a href="/courses/{{ $related->slug }}">{{ $related->title }}</a>
			<small>with {{ CourseController::formatInstructors($related) }}</small>
		</h1>
		<div class="description">{{ $related->description }}</div>
	</div>
@endsection