@extends('template')

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-8 page">
			<div class="inner">
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
								{{ Form::select('state', $states, 'NY', array('class'=>'form-control')) }}
							</div>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="zip" placeholder="ZIP">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Register</button>
							</div>
						</div>
					</fieldset>
  				</form>
			</div>
		</div>
		<div class="col-md-4 side">
			<div class="inner">
				Perhaps information goes here about the donation, such as 501(c)(3) status, what the donation supports.
			</div>
		</div>
	</div>
</div>

@endsection