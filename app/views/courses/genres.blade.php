@if (count($genres))
	@foreach ($genres as $genre)
		
		<h1 class="group">{{ $genre->title }}</h1>
		
		<ul class="courses">
		@foreach ($genre->courses as $course)
			<li>
				<a href="{{ $course->url }}">{{ $course->title }}</a>
				{{ CourseController::formatInstructors($course) }}
			</li>
		@endforeach
		</ul>

	@endforeach
@else
	<div class="alert alert-info">
		No courses matched the selected criteria.
	</div>
@endif