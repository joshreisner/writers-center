@extends('page')

@section('content')
	<div class="col-md-offset-1">
	@foreach ($genres as $genre)
		<h2>{{ $genre->title }}</h2>
		<ul class="courses">
		@foreach ($genre->courses as $course)
			<li>
				<a href="/courses/{{ $course->slug }}">{{ $course->title }}</a>
				with {{ CourseController::formatInstructors($course) }}
			</li>
		@endforeach
		</ul>
	@endforeach
	</div>
@endsection

@section('side')
	<form class="switchboard">
		<div class="form-group">
			<div class="btn-group btn-group-justified">
					<div class="btn-group">
						<button type="button" class="btn btn-default active">Current Courses</button>							
					</div>
					<div class="btn-group">
					<button type="button" class="btn btn-default">Past Courses</button>							
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="genre">Genre</label>
			{{ Form::select('genre', $genre_select, false, array('class'=>'form-control')) }}
		</div>
		<div class="form-group">
			<label for="genre">Instructor</label>
			{{ Form::select('instructor', $instructor_select, false, array('class'=>'form-control')) }}
		</div>
		<div class="form-group">
			<label for="tags">Days</label>
			@foreach ($days as $day)
			<div class="checkbox">
				<label>
					<input type="checkbox" value="{{ $day->id }}">
					{{ $day->title }}
				</label>
			</div>
			@endforeach
		</div>
	</form>
@endsection