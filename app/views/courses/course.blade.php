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
				<h1>{{ $course->title }}</h1>
			</div>
			{{ $course->description }}
		</div>
	</div>
</div>

@endsection