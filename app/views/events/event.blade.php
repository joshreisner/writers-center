@extends('page')

@section('content')

	<div class="col-md-offset-1">
		<h1>{{ $event->title }}</h1>
		{{ $event->description }}
	</div>

@endsection

@section('side')
	<div class="wallpaper"></div>
@endsection