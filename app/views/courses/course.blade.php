@extends('page')

@section('content')

	<a class="label" href="/courses">Courses</a>
	
	<div class="col-md-offset-1">

		<h1>
			{{ $course->title }}
			{{ BaseController:: editLink($course) }}
			@if (count($course->instructors))
				<small>{{ CourseController::formatInstructors($course) }}</small>
			@endif
		</h1>

		{{ $course->description }}

		<div class="row sessions">
		@foreach ($course->sessions as $session)
		<dl class="col-md-6">
			<dt>
				@if (count($course->sessions) == 1)
				When
				@else
				{{ $session->title }}
				@endif
			</dt>
			<dd>
				@if ($session->classes == 1)
				{{ $session->days->title }}, {{ $session->start_date->format('n/d/Y') }}<br>
				{{ BaseController::formatTimeRange($session->start_time, $session->end_time) }}				
				@else
				{{ $session->classes }} {{ $session->days->title }}s, {{ BaseController::formatTimeRange($session->start_time, $session->end_time) }}<br>
				{{ $session->start_date->format('n/d/Y') }}&ndash;{{ $session->end_date->format('n/d/Y') }}
				@endif
			</dd>

			<dt>Tuition</dt>
			<dd>${{ $session->member_tuition }} 
				@if ($session->member_tuition != $session->non_member_tuition)
					members<br>${{ $session->non_member_tuition }} non-members
				@endif
			</dd>
			
			@if (!empty($session->register_url))
				<dt><a class="btn btn-primary" href="{{ $session->register_url }}">Register</a></dt>
			@endif
		</dl>
		@endforeach
		</div>

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
		<span class="label">You might also like</span>
		<h1>
			<a href="/courses/{{ $related->slug }}">{{ $related->title }}</a>
			<small>with {{ CourseController::formatInstructors($related) }}</small>
		</h1>
		<div class="description">{{ $related->description }}</div>
	</div>
@endsection