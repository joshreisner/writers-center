@extends('template')

@section('body_class') blog @endsection

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
	</div>
</div>

@endsection