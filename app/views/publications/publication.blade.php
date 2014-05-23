@extends('page')

@section('content')

	<div class="col-md-offset-1">
		<h1>{{ $publication->title }}</h1>
		<img src="{{ $publication->image->url }}" width="{{ $publication->image->width }}" height="{{ $publication->image->height }}" class="{{ ($publication->image->width > $publication->image->height) ? 'landscape' : 'portrait' }}">
		{{ $publication->description }}
	</div>
	
@endsection

@section('side')
	<div class="wallpaper"></div>
@endsection