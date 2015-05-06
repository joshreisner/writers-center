@extends('page')

@section('content')
	
	<div class="indent">
		<h1>Settings</h1>

		{!! Form::open(['id'=>'settings', 'action'=>'MyController@saveSettings', 'method'=>'post']) !!}

			<div class="row form-group">
				<div class="col-sm-12"><h3>Contact Info:</h3></div>
			</div>
			
			<div class="row form-group">
				<div class="col-sm-6 @if ($errors->has('name')) has-error @endif">
					{!! Form::text('name', $user->name, ['class'=>'form-control required', 'placeholder'=>'Your Name', 'title'=>$errors->first('name')]) !!}
				</div>
				<div class="col-sm-6 @if ($errors->has('email')) has-error @endif">
					{!! Form::text('email', $user->email, ['class'=>'form-control required', 'placeholder'=>'Email Address', 'title'=>$errors->first('email')]) !!}
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-sm-6 @if ($errors->has('address')) has-error @endif">
					{!! Form::text('address', $user->address, ['class'=>'form-control required' . ($errors->has('address') ? ' error' : ''), 'placeholder'=>'Address', 'title'=>$errors->first('address')]) !!}
				</div>
				<div class="col-sm-6 @if ($errors->has('phone')) has-error @endif">
					{!! Form::text('phone', $user->phone, ['class'=>'form-control' . ($errors->has('phone') ? ' error' : ''), 'data-phone', 'placeholder'=>'Phone', 'title'=>$errors->first('phone')]) !!}
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-sm-6 @if ($errors->has('city')) has-error @endif">
					{!! Form::text('city', $user->city, ['class'=>'form-control required', 'placeholder'=>'City', 'title'=>$errors->first('city')]) !!}
				</div>
				<div class="col-sm-3 select @if ($errors->has('state')) has-error @endif">
					{!! Form::select('state', array(''=>'State') + $states, $user->state, ['class'=>'form-control required']) !!}
				</div>
				<div class="col-sm-3 @if ($errors->has('zip')) has-error @endif">
					{!! Form::text('zip', $user->zip, ['class'=>'form-control required', 'pattern'=>'\d*', 'data-numeric', 'maxlength'=>5, 'placeholder'=>'ZIP', 'zip'=>$errors->first('zip')]) !!}
				</div>
			</div>

			<!--
			<div class="row form-group">
				<div class="col-sm-12"><h3>Image:</h3></div>
			</div>
			
			<div class="row form-group">
				<div class="col-sm-12">
					{!! Form::hidden('image_id', $user->image_id) !!}
					<img src="/assets/img/avatar-josh.jpg" width="80" height="80">
				</div>
			</div>
			-->

			<div class="row form-group">
				<div class="col-sm-12"><h3>New Password (Optional):</h3></div>
			</div>
			
			<div class="row form-group">
				<div class="col-sm-6">
					{!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) !!}
				</div>
				<div class="col-sm-6">
					{!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Confirm']) !!}
				</div>
			</div>

			<!--
			<div class="row form-group">
				<div class="col-sm-12"><h3>Communications Preferences:</h3></div>
			</div>
			
			<div class="row form-group">
				<div class="col-sm-12">
					<div class="radio">
						<label>
							<input type="radio" name="communications" value="immediate" checked>
							Immediate updates
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="communications" value="immediate">
							No more than once per day
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="communications" value="immediate">
							No more than once per week
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="communications" value="immediate">
							Never
						</label>
					</div>
				</div>
			</div>
			-->

			<div class="row form-group">
				<div class="col-sm-12">
					{!! Form::submit('Save Changes', ['class'=>'btn btn-primary']) !!}
				</div>
			</div>

		{!! Form::close() !!}
	</div>

@endsection

@section('side')

	<div class="wallpaper">
		<span class="label">Your Profile</span>
		<h1>Membership</h1>
		@if (empty(Auth::user()->membership_expires))
		<p>Join us and receive special discounts on courses, events and publications! Read about the <a href="/about/membership">benefits of membership</a>.</p>
		<p><a class="btn btn-primary">Become a Member Today</a></p>
		@else
			@if ($user->membership_expires > new DateTime('now'))
			<p>Your membership will expire on {{ $user->membership_expires->format('M d, Y') }}.</p>
			@else
			<p>Your membership expired on {{ $user->membership_expires->format('M d, Y') }}.</p>
			@endif
			<p><a class="btn btn-primary">Renew Now</a></p>
		@endif
	</div>

@endsection