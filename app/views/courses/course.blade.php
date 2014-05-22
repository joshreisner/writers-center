@extends('page')

@section('content')

	<div class="col-md-offset-1">
		<h1>
			{{ $course->title }}
			<small>with {{ CourseController::formatInstructors($course) }}</small>
		</h1>

		{{ $course->description }}

		<dl>
			<dt>When</dt>
			<dd>Six Mondays, 1:30&ndash;3:30 p.m.</dd>

			<dt>Dates</dt>
			<dd>January 6&ndash;February 24 (No class on January 20 or February 17)</dd>

			<dt>Code</dt>
			<dd>PAw14a</dd>

			<dt>Tuition</dt>
			<dd>${{ $course->tuition_member }} members/${{ $course->tuition_outside }} non-members</dd>
		</dl>

		@if (count($course->instructors) > 0)
			@if (count($course->instructors) == 1)
				<h3>About the Instructor</h3>
			@else
				<h3>About the Instructors</h3>
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