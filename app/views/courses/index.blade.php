@extends('page')

@section('content')
	<div class="indent target">
		@include('courses.genres')
	</div>
@endsection

@section('side')
	<form class="switchboard form-horizontal" data-model="courses">
		<div class="form-group">
			<label for="search" class="col-md-3">Search</label>
			<div class="col-md-9">{{ Form::text('search', false, array('class'=>'form-control')) }}</div>
		</div>
		<div class="form-group">
			<label for="genre" class="col-md-3">Genre</label>
			<div class="col-md-9">{{ Form::dropdown('genre', $genre_select, Input::get('genre')) }}</div>
		</div>
		<div class="form-group">
			<label for="day" class="col-md-3">Day</label>
			<div class="col-md-9">{{ Form::dropdown('day', $day_select, Input::get('day')) }}</div>
		</div>
		<div class="form-group">
			<label for="instructor" class="col-md-3">Teacher</label>
			<div class="col-md-9">{{ Form::dropdown('instructor', $instructor_select, Input::get('instructor')) }}</div>
		</div>
		<div class="form-group">
			<label for="duration" class="col-md-3">Duration</label>
			<div class="col-md-9">{{ Form::dropdown('duration', $duration_select, Input::get('duration')) }}</div>
		</div>
	</form>

	<div class="wallpaper">
		<span class="label">Tutorials</span>
		<h3>Tutorials are Available</h3>
		<p>To arrange a tutorial with your instructor of choice please contact the Hudson Valley Writers Center's office by calling (914) 332-5953 or by emailing <a href="mailto:info@writerscenter.org">info@writerscenter.org</a>.</p>
		<div class="image" style="background-image:url({{ $wallpaper}})">
	</div>
@endsection