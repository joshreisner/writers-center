@extends('page')

@section('content')
	<h1>My HVWC</h1>


	<div class="my-hvwc">

		<form>
			<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
			<h2>
				Josh Reisner <i class="fa fa-caret-right"></i> {{ Form::dropdown('to', [1=>'HVWC Admin', 1=>'Writing Flash Fiction'], null, 'HVWC') }}
			</h2>
			{{ Form::textarea('post', false, array('class'=>'form-control', 'placeholder'=>'Make your voice heard')) }}
		</form>

		<article>
			<img src="/assets/img/avatar-kate.jpg" width="200" height="200">
			<h2>
				Kate Howe <i class="fa fa-caret-right"></i> HVWC
				<small>8 hrs</small>
			</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<p>
				Like &middot; Comment &middot; Share
			</p>
		</article>

		<article>
			<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
			<h2>
				Josh Reisner <i class="fa fa-caret-right"></i> Writing Flash Fiction
				<small>10 hrs</small>
			</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<p>
				Like &middot; Comment &middot; Share
			</p>
		</article>
	
	</div>

@endsection

@section('side')

	<form class="switchboard form-horizontal" data-model="courses">
		<div class="form-group">
			<label for="search" class="col-md-3">Search</label>
			<div class="col-md-9">{{ Form::text('search', false, array('class'=>'form-control')) }}</div>
		</div>
	</form>

	<div class="wallpaper">
		<span class="label">All About You</span>
		<p>Your current membership will expire on April 13, 2015. <a href="">Renew now!</a></p>
		<p>Welcome back Josh Reisner.</p>
		<p>
			<i class="fa fa-cog"></i> <a href="">Adjust your settings</a><br>
			<i class="fa fa-ban"></i> <a href="/logout">Log out</a>
		</p>
	</div>

@endsection