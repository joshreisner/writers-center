@extends('template')

@section('body_class') courses @endsection

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-4 side">
			<div class="inner">
				<form role="form">
					<div class="form-group">
						Upcoming Courses | <a href="">Past Courses</a>
					</div>
					<div class="form-group">
						<label for="genre">Genre</label>
						<select name="genre" id="genre" class="form-control">
							<option selected="selected">All</option>
							@foreach ($genres as $genre)
								<option value="{{ $genre->id }}">{{ $genre->title }}</option>
							@endforeach
						</select>
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
		<div class="col-md-8 page">
			<div class="inner">
				<div class="col-md-offset-1">
					@yield('page')
				</div>
			</div>
		</div>
	</div>
</div>

@endsection