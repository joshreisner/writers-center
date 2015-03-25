@extends('page')

@section('content')
	<div class="indent">
		<h1>Courses</h1>
		<div class="target">
			@include('courses.genres')
		</div>
	</div>
@endsection

@section('side')
	<form class="switchboard form-horizontal" data-model="courses">
		<div class="form-group">
			<label for="search" class="col-md-3">Search</label>
			<div class="col-md-9">{!! Form::text('search', false, ['class'=>'form-control']) !!}</div>
		</div>
		<div class="form-group">
			<label for="genre" class="col-md-3">Genre</label>
			<div class="col-md-9">{!! Form::dropdown('genre', $genre_select, Request::input('genre')) !!}</div>
		</div>
		<div class="form-group">
			<label for="day" class="col-md-3">Day</label>
			<div class="col-md-9">{!! Form::dropdown('day', $day_select, Request::input('day')) !!}</div>
		</div>
		<div class="form-group">
			<label for="instructor" class="col-md-3">Teacher</label>
			<div class="col-md-9">{!! Form::dropdown('instructor', $instructor_select, Request::input('instructor')) !!}</div>
		</div>
		<div class="form-group">
			<label for="duration" class="col-md-3">Duration</label>
			<div class="col-md-9">{!! Form::dropdown('duration', $duration_select, Request::input('duration')) !!}</div>
		</div>
	</form>

	<div class="wallpaper">
		<span class="label">Tutorials</span>
		<h3>Tutorials are Available</h3>
		<p>To arrange a tutorial with your instructor of choice please contact the Hudson Valley Writers Center's office by calling (914) 332-5953 or by emailing <a href="mailto:info@writerscenter.org">info@writerscenter.org</a>.</p>
	</div>

	<div class="wallpaper">
		<span class="label">Special Series</span>
		<h3>The Year of Your Book</h3>
		<p>How long have you been saying that you want to write a book? How much longer do you have to wait? This series of classes (fiction, poetry, and mystery) begins at the start of 2015, when the New Year inspires serious resolutions. With emphasis on deadlines, how to structure and revise a manuscript and, most of all, mutual support—the goal is a solid draft (and a reading at HVWC to celebrate your accomplishment) by the end of the year.</p>
		<ul>
		@foreach ($year_of_your_book as $course)
			<li><a href="{{ App\Http\Controllers\CourseController::url($course) }}">{{ $course->title }}</a></li>
		@endforeach
		</ul>
	</div>
@endsection