@extends('template')

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-3">
			<div class="well">
				<form role="form">
					<div class="form-group">
						<label for="genre">Show</label>
						<select name="genre" id="genre" class="form-control">
							<option selected="selected">Most Recent Posts</option>
							@foreach ($years as $year)
							<option value="{{ $year }}">{{ $year }}</option>
							@endforeach
						</select>
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-9">
			<div class="page-header">
				<h1>{{ $title }}</h1>
			</div>
			<ul>
			@foreach ($posts as $post)
				<li><a href="#">{{ $post->title }}</a></li>
			@endforeach
			</ul>
		</div>

	</div>
</div>

@endsection