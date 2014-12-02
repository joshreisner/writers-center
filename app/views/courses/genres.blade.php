@if (count($genres))
	@foreach ($genres as $title=>$statuses)
		<h1 class="group">{{ $title }}</h1>
		@foreach (['open', 'closed'] as $status)
			@if (count($statuses[$status]))
				<ul class="courses">
				<h4>@lang('messages.course_status_' . $status)</h4>
				@foreach ($statuses[$status] as $course)
					<li>
						<a href="{{ CourseController::url($course) }}">{{ $course->title }}</a>
						{{ CourseController::formatInstructors($course) }}
					</li>
				@endforeach
				</ul>
			@endif
		@endforeach
	@endforeach
@else
	<div class="alert alert-info">
		No courses matched the selected criteria.
	</div>
@endif