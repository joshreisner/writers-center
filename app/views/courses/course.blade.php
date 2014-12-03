@extends('page')

@section('content')

	<a class="label" href="/courses">Courses</a>
	
	<div class="indent">

		<h1>
			{{ $course->title }}
			{{ BaseController:: editLink($course) }}
			<small>{{ CourseController::formatInstructors($course) }}</small>
		</h1>

		<div class="description">{{ nl2br($course->description) }}</div>

		<?php $open_courses = 0; ?>

		@foreach ($course->sections as $section)
			<h3>{{ $section->title }}</h3>

			<div>
			@if ($section->classes)
				@if ($section->classes == 1)
				{{ !empty($section->days->title) ? $section->days->title . ', ' : '' }}{{ $section->start->format('n/d/Y') }}<br>
				{{ BaseController::formatTimeRange($section->start, $section->end) }}				
				@else
				{{ $section->start->format('n/d/Y') }}&ndash;{{ $section->end->format('n/d/Y') }}, {{ $section->classes }} {{ !empty($section->days->title) ? $section->days->title : 'day' }}s, {{ BaseController::formatTimeRange($section->start, $section->end) }}<br>
				{{ $section->notes }}
				@endif
			@endif
			</div>

			@if (!empty($section->register_url) && ($section->start > new DateTime))
				<?php $open_courses++; ?>
				<div>{{ BaseController::formatPrice($section->price) }} members / {{ BaseController::formatPrice($section->price, true) }} non-members</div>
				<div class="register"><a class="btn btn-primary" href="{{ $section->register_url }}">Register</a></div>
			@endif

		@endforeach

		@if ($course->tutorial_available)
			<div class="tutorial">
				<p>@lang('messages.course_tutorial_available')</p>
				<p><a class="btn btn-primary" href="mailto:info@writerscenter.org?subject={{ rawurlencode($course->title . ' Tutorial Inquiry') }}">Contact</a></p>
			</div>
		@elseif (!$open_courses)
			<div class="tutorial">
				<p>@lang('messages.course_enrollment_closed')</p>
			</div>
		@endif

		@if (count($course->instructors))
			<h3>@choice('messages.course_instructor', count($course->instructors))</h3>

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
	@if (!empty($related))
	<div class="wallpaper">
		<span class="label">You might also like</span>
		<h1>
			<a href="/courses/{{ $related->slug }}">{{ $related->title }}</a>
			<small>with {{ CourseController::formatInstructors($related) }}</small>
		</h1>
		<div class="description">{{ $related->description }}</div>
	</div>
	@endif
@endsection