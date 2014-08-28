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

	{{-- 
	<div class="wallpaper">
		<span class="label">SHP Masthead</span>
		<h3>Slapering Hol Press</h3>
		<ul>
			<li>Peggy Ellsberg <em>Co-Editor</em></li>
			<li>Jennifer Franklin <em>Co-Editor</em></li>
			<li>Margo Taft Stever <em>Co-Editor</em></li>
		</ul>
		<h3>Advisory Committee</h3>
		<ul>
			<li>‎Cindy Beer-Fouhy</li>
			<li>Sally Bliumis-Dunn</li>
			<li>Susana H. Case</li>
			<li>Susanne Cleary</li>
			<li>Julie Danho</li>
			<li>Ann Lauinger</li>
			<li>Kathleen Ossip</li>
			<li>Mervyn Taylor</li>
			<li>Meredith Trede</li>
			<li>Estha Weiner</li>
		</ul>
		<div class="image" style="background-image:url({{ $wallpaper}})">
	</div>
	--}}
@endsection