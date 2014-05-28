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
	<form class="switchboard form-horizontal">
		<div class="form-group">
			<label for="genre" class="col-md-3">Search</label>
			<div class="col-md-9">{{ Form::text('search', false, array('class'=>'form-control')) }}</div>
		</div>
		<div class="form-group">
			<label for="genre" class="col-md-3">Genre</label>
			<div class="col-md-9">{{ Form::dropdown('genre', $genre_select) }}</div>
		</div>
		<div class="form-group">
			<label for="tags" class="col-md-3">When</label>
			<div class="col-md-9">{{ Form::dropdown('days', $day_select) }}</div>
		</div>
		<div class="form-group">
			<label for="genre" class="col-md-3">Teacher</label>
			<div class="col-md-9">{{ Form::dropdown('instructor', $instructor_select) }}</div>
		</div>
		<div class="form-group">
			<label for="genre" class="col-md-3">Duration</label>
			<div class="col-md-9">{{ Form::dropdown('duration', $duration_select) }}</div>
		</div>
		<!--
		<div class="form-group">
			<label for="types" class="col-md-3">Scope</label>
			<div class="col-md-9">
				<div class="checkbox">
					<label>
						{{ Form::chkbox('scope', 'current') }}
						Currently Offered
					</label>
				</div>
				<div class="checkbox">
					<label>
						{{ Form::chkbox('scope', 'all') }}
						All Courses
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="btn-group btn-group-justified col-md-12">
				<div class="btn-group">
					<button type="button" class="btn btn-default active">Current Courses</button>							
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-default">Past Courses</button>							
				</div>
			</div>
		</div>
		-->
	</form>
@endsection