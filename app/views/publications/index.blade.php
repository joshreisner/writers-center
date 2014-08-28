@extends('page')

@section('content')
	<div class="indent">
		<h1>{{ $title }}</h1>
	</div>
	<div class="row target">
		@include('publications.publications')
	</div>
@endsection

@section('side')
	<form class="switchboard form-horizontal" data-model="publications">
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
		<div class="form-group">
			<label for="timeframe" class="col-md-3">Type</label>
			<div class="col-md-9">
				{{ Form::dropdown('type_id', $types) }}
			</div>
		</div>
	</form>

	@include('publications.masthead') 
@endsection