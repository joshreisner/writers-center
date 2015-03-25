@extends('page')

@section('content')
	
	<div class="indent">
		<h1>My HVWC</h1>
	</div>

	<div class="my-hvwc">

		<article>
			{!! Form::open(['action'=>'MyController@message', 'class'=>'message']) !!}
				<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
				<h2>
					<div class="prefix">Josh Reisner <span>to</span></div>
					<div class="select">{!! Form::select('to', $targets, null, ['class'=>'form-control ']) !!}</div>
				</h2>
				<div class="form-group">
						{!! Form::textarea('content', false, array('class'=>'form-control', 'placeholder'=>'Make your voice heard')) !!}
				</div>
				<div class="form-group buttons">
					{!! Form::submit('Publish', ['class'=>'btn btn-primary']) !!}
					<a href="#cancel" class="btn btn-default">Cancel</a>
				</div>
			{!! Form::close() !!}
		</article>

		<div class="messages">
			@include('my.messages')
		</div>
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