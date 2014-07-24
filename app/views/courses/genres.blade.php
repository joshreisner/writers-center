@foreach ($genres as $genre=>$courses)
	
	<h1 class="group">{{ $genre }}</h1>
	
	<ul class="courses">
	@foreach ($courses as $course)
		<li>
			<a href="{{ $course->url }}">{{ $course->title }}</a>
			{{ CourseController::formatInstructors($course) }}
		</li>
	@endforeach
	</ul>

@endforeach