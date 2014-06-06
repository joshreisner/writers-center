@extends('page')

@section('content')

	<div class="target">
		@include('events.events')
	</div>
	
@endsection

@section('side')

	<form class="switchboard form-horizontal" data-model="events">
		<div class="form-group">
			<label for="genre" class="col-md-3">Search</label>
			<div class="col-md-9">{{ Form::text('search', false, array('class'=>'form-control')) }}</div>
		</div>
		<div class="form-group">
			<label for="timeframe" class="col-md-3">Year</label>
			<div class="col-md-9">
				{{ Form::dropdown('year', $years) }}
			</div>
		</div>
	</form>

@endsection