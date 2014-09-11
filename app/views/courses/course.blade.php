@extends('page')

@section('content')

	<a class="label" href="/courses">Courses</a>
	
	<div class="indent">

		<h1>
			{{ $course->title }}
			{{ BaseController:: editLink($course) }}
			<small>{{ CourseController::formatInstructors($course) }}</small>
		</h1>

		{{ $course->description }}

		@foreach ($course->sections as $section)
		<dl>
			<dt>
				@if (count($course->sections) == 1)
				When
				@else
				{{ $section->title }}
				@endif
			</dt>
			<dd>
				@if ($section->classes)
					@if ($section->classes == 1)
					{{ $section->days->title }}, {{ $section->start->format('n/d/Y') }}<br>
					{{ BaseController::formatTimeRange($section->start, $section->end) }}				
					@else
					{{ $section->classes }} {{ $section->days->title }}s, {{ BaseController::formatTimeRange($section->start, $section->end) }}<br>
					{{ $section->start->format('n/d/Y') }}&ndash;{{ $section->end->format('n/d/Y') }} <em>{{ $section->notes }}</em>
					@endif
				@endif
			</dd>

			<dt>Tuition</dt>
			<dd>{{ BaseController::formatPrice($section->member_tuition) }} 
				@if ($section->member_tuition != $section->non_member_tuition)
					members<br>{{ BaseController::formatPrice($section->non_member_tuition) }} non-members
				@endif
			</dd>
			
			@if (!empty($section->register_url))
				<dt><a class="btn btn-primary" href="{{ $section->register_url }}">Register</a></dt>
			@endif

			{{--
			<dt>
			@if (section::has('cart.courses') && array_key_exists($section->id, section::get('cart.courses')))
				<a class="btn btn-disabled">Added to Cart</a>
			@else
				<a class="btn btn-primary" href="{{ URL::action('PaymentController@add_course', $section->id) }}">Register</a>
			@endif
			</dt>
			--}}
		</dl>
		@endforeach

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
	@if (!empty($related))
	<div class="wallpaper">
		<span class="label">You might also like</span>
		<h1>
			<a href="/courses/{{ $related->slug }}">{{ $related->title }}</a>
			<small>with {{ CourseController::formatInstructors($related) }}</small>
		</h1>
		<div class="description">{{ $related->description }}</div>
		<div class="image" style="background-image:url({{ $wallpaper}})">
	</div>
	@endif
@endsection