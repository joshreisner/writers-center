@foreach ($genres as $genre)
	<h2>{{ $genre->title }}</h2>
	<ul class="courses">
	@foreach ($genre->courses as $course)
		<li>
			<a href="/courses/{{ $course->slug }}">{{ $course->title }}</a>
			{{ CourseController::formatInstructors($course) }}
		</li>
	@endforeach
	</ul>
@endforeach
