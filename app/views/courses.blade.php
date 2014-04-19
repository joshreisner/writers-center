@extends('template')

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-3">
			<div class="well">
				<form role="form">
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
						<label for="genre">Day of Week</label>
						<select name="genre" id="genre" class="form-control">
							<option selected="selected">Any</option>
							@foreach ($days as $day)
								<option value="{{ $day->id }}">{{ $day->title }}</option>
							@endforeach
						</select>
					</div>
					<button type="submit" class="btn btn-default">Filter</button>
				</form>

			</div>
		</div>
		<div class="col-md-9">
			@foreach ($genres as $genre)
				<h2>{{ $genre->title }}</h2>
				<ul>
				@foreach ($genre->courses as $course)
					<li><a href="#">{{ $course->title }}</a></li>
				@endforeach
				</ul>
			@endforeach
		</div>
	</div>
</div>

@endsection