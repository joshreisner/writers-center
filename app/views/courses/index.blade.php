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
		<div class="col-md-9">
			<div class="page-header">
				<h1>{{ $title }}</h1>
			</div>
			@foreach ($genres as $genre)
				<h3>{{ $genre->title }}</h3>
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