@extends('page')

@section('content')

	<div class="col-md-offset-1">
		<h1>{{ $publication->title }}</h1>
		{{ $publication->description }}
	</div>
	
@endsection