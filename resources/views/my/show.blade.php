@extends('page')

@section('content')
	
	<div class="indent">
		<h1>My HVWC</h1>
	</div>

	<div class="my-hvwc">
		@include('my.message')
	</div>

@endsection

@section('side')

	<form class="switchboard form-horizontal" data-model="courses">
		<div class="form-group">
			<label for="search" class="col-md-3">Search</label>
			<div class="col-md-9">{!! Form::text('search', false, array('class'=>'form-control')) !!}</div>
		</div>
	</form>

	<div class="wallpaper">
		<!-- <span class="label">All About You</span> -->
		<p>Welcome back <span>Josh Reisner</span>.</p>
		<p>Your current membership will expire on April 13, 2015. <a href="">Renew now!</a></p>
		<p>
			{!! link_to_action('MyController@settings', 'Settings', null, ['class'=>'pull-left']) !!}
			{!! link_to_action('MyController@logout', 'Log out', null, ['class'=>'pull-right']) !!}
		</p>
	</div>

@endsection