@extends('page')

@section('content')
	
	<div class="indent">
		<h1>My HVWC</h1>
	</div>

	<div class="my-hvwc">

		<article>
			<form>
				<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
				<h2>
					Josh Reisner <span>to</span> {{ Form::dropdown('to', [1=>'HVWC Admin', 1=>'Writing Flash Fiction'], null, 'Everyone') }}
				</h2>
				{{ Form::textarea('post', false, array('class'=>'form-control', 'placeholder'=>'Make your voice heard')) }}
			</form>
		</article>

		<article>
			<img src="/assets/img/avatar-kate.jpg" width="200" height="200">
			<h2>
				Kate Howe <span>to</span> Everyone
				<small>8 hrs</small>
			</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<ul class="replies">
				<li>
					<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
					<h2>
						Josh Reisner
						<small>9 hrs</small>
					</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</li>
				<li>
					<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
					<form>
						<h2>Josh Reisner</h2>
						{{ Form::textarea('reply', false, ['class'=>'form-control', 'placeholder'=>'Reply']) }}
					</form>
				</li>
			</ul>
		</article>

		<article>
			<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
			<h2>
				Josh Reisner <span>to</span> Writing Flash Fiction
				<small>10 hrs</small>
			</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<ul class="replies">
				<li>
					<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
					<h2>
						Josh Reisner
						<small>9 hrs</small>
					</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				</li>
				<li>
					<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
					<form>
						<h2>Josh Reisner</h2>
						{{ Form::textarea('reply', false, ['class'=>'form-control', 'placeholder'=>'Reply']) }}
					</form>
				</li>
			</ul>
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
		<!-- <span class="label">All About You</span> -->
		<p>Welcome back <span>Josh Reisner</span>.</p>
		<p>Your current membership will expire on April 13, 2015. <a href="">Renew now!</a></p>
		<p>
			{{ link_to_action('MyController@settings', 'Adjust your settings') }}<br>
			{{ link_to_action('MyController@logout', 'Log out') }}<br>
		</p>
	</div>

@endsection