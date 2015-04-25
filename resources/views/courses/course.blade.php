@extends('page')

@section('content')

	<a class="label" href="/courses">Courses</a>
	
	<div class="indent">

		<h1>
			{{ $course->title }}
			{!! App\Http\Controllers\Controller:: editLink($course) !!}
			<small>{{ App\Http\Controllers\CourseController::formatInstructors($course) }}</small>
		</h1>

		@if (!empty($course->description))
			<div class="description">{{ nl2br($course->description) }}</div>
		@endif

		@if (!empty($course->price))
			<h3>Tuition</h3>
			<div class="price">{{ App\Http\Controllers\Controller::formatPrice($course->price) }} members / {{ App\Http\Controllers\Controller::formatPrice($course->price, true) }} non-members</div>
		@endif

		@if (count($course->sections))
			@foreach ($course->sections as $section)
				<h3>{{ $section->title }} {!! App\Http\Controllers\Controller:: editLink($section) !!}</h3>
	
				@if ($section->classes)
				<div>
					@if ($section->classes == 1)
					{{ !empty($section->days->title) ? $section->days->title . ', ' : '' }}{{ $section->start->format('n/d/Y') }}, {{ App\Http\Controllers\Controller::formatTimeRange($section->start, $section->end) }}
					@else
					{{ $section->start->format('n/d/Y') }}&ndash;{{ $section->end->format('n/d/Y') }}, {{ $section->classes }} {{ !empty($section->days->title) ? $section->days->title : 'day' }}s, {{ App\Http\Controllers\Controller::formatTimeRange($section->start, $section->end) }}
					@endif
				</div>
				@endif
	
				@if (!empty($section->notes))
					<div class="notes">{{ $section->notes }}</div>
				@endif
	
				@if (!empty($section->price) && ($section->price != $course->price))
					<div class="price">{{ App\Http\Controllers\Controller::formatPrice($section->price) }} members / {{ App\Http\Controllers\Controller::formatPrice($section->price, true) }} non-members</div>
				@endif
				
				@if (App::environment('production') && !empty($section->register_url))
					<div class="register"><a class="btn btn-primary" href="{{ $section->register_url }}">Register</a></div>
				@elseif ($section->open)
					<div class="register">
						@if (App\Http\Controllers\PaymentController::has_course($section->id))
						<a class="btn btn-disabled">Course Added</a>
						@else
						<a class="btn btn-primary" href="{{ URL::action('PaymentController@add_course', $section->id) }}">Register</a>
						@endif
					</div>
				@endif
	
			@endforeach
			@if ($course->tutorial_available)
				<h3>Tutorial</h3>
				<div class="tutorial">
					<p>@lang('messages.course_tutorial_also_available')</p>
					<p><a class="btn btn-primary" href="mailto:info@writerscenter.org?subject={{ rawurlencode($course->title . ' Tutorial Inquiry') }}">Contact</a></p>
				</div>
			@endif
		@elseif ($course->tutorial_available)
			<div class="tutorial">
				<p>@lang('messages.course_tutorial_available')</p>
				<p><a class="btn btn-primary" href="mailto:info@writerscenter.org?subject={{ rawurlencode($course->title . ' Tutorial Inquiry') }}">Contact</a></p>
			</div>
		@else
			<div class="closed">
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
					{!! App\Http\Controllers\Controller::insertIntoHtml($instructor->bio, App\Http\Controllers\Controller:: editLink($instructor)) !!}
				</li>
				@endforeach
			</ul>
		@endif
		
		@if (count($past_sections))
			<h3>Past Sections</h3>
			<ul class="past_sections">
			@foreach ($past_sections as $section)
			<li>{{ $section->title }} <em>{{ App\Http\Controllers\Controller::formatDateRange($section->start, $section->end) }}</em></li>
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
			<small>with {{ App\Http\Controllers\CourseController::formatInstructors($related) }}</small>
		</h1>
		<div class="description">{{ $related->description }}</div>
	</div>
	@endif
@endsection