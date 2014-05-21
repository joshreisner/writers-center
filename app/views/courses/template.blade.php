@extends('template')

@section('body_class') courses @endsection

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-8 page">
			<div class="inner">
				<div class="col-md-offset-1">
					@yield('page')
				</div>
			</div>
		</div>
		<div class="col-md-4 side">
			<div class="inner">
				<form role="form">
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
			</div>
		</div>
	</div>
</div>

@endsection