@extends('page')

@section('content')

	<h1>{{ $title }}</h1>

	<div class="alert alert-warning">Already a member? Please <a class="login alert-link">log in</a>.</div>

	<form class="form-horizontal">
		<fieldset>
			<legend>Register</legend>
			<div class="form-group">
				<label for="first_name" class="col-sm-2 control-label">First Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="first_name" placeholder="First Name">
				</div>
			</div>
			<div class="form-group">
				<label for="last_name" class="col-sm-2 control-label">Last Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="last_name" placeholder="Last Name">
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="email" placeholder="Email">
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-sm-2 control-label">Address</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="address" placeholder="Address">
				</div>
			</div>
			<div class="form-group">
				<label for="city" class="col-sm-2 control-label"></label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="city" placeholder="City">
				</div>
				<div class="col-sm-3">
					{{ Form::dropdown('state', $states, 'NY') }}
				</div>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="zip" placeholder="ZIP">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" class="btn btn-primary" value="Register">
				</div>
			</div>
		</fieldset>
	</form>

@endsection

@section('side')
	<div class="wallpaper">
		<p>Perhaps information goes here about the donation, such as the Center's 501(c)(3) status or what the donation supports.</p>
	</div>
@endsection

@section('script')
	<script src="https://js.stripe.com/v2/"></script>
@endsection