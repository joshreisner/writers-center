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
					<div class="form-group">
						<label for="tags">Tags</label>
						@foreach ($tags as $tag)
						<div class="checkbox">
							<label>
								<input type="checkbox" value="{{ $tag->id }}">
								{{ $tag->title }}
							</label>
						</div>
						@endforeach
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-9">
			<div class="page-header">
				<h1>{{ $post->title }}</h1>
			</div>
			<div class="date">Published: {{ $post->publish_date->format(Config::get('config.date_format')) }}</div>
			<div class="content">{{ $post->content }}</div>
		</div>

	</div>
</div>

@endsection