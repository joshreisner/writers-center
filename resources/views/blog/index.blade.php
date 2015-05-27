@extends('page')

@section('content')
	<div class="indent">
		<h1>Blog</h1>
		<div class="target">
			@include('blog.posts')
		</div>
	</div>
@endsection

@section('switchboard')
	<form class="switchboard form-horizontal" data-model="blog">
		{!! Form::hidden('limit', 10) !!}
		<div class="form-group">
			<label for="genre" class="col-md-3">Search</label>
			<div class="col-md-9">{!! Form::text('search', false, ['class'=>'form-control']) !!}</div>
		</div>
		<div class="form-group">
			<label for="genre" class="col-md-3">Year</label>
			<div class="col-md-9">
				{!! Form::dropdown('year', $years) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="tags" class="col-md-3">Tags</label>
			<div class="col-md-9">
				@foreach ($tags as $tag)
				<div class="checkbox">
					<label>
						{!! Form::chkbox('tags[]', $tag->id) !!}
						{{ $tag->title }}
					</label>
				</div>
				@endforeach
			</div>
		</div>
	</form>
@endsection