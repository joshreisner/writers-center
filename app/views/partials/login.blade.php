{{-- login modal partial --}}
@if (Auth::guest())
<div class="modal fade" id="login">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal login">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
					<h1 class="modal-title">Please log in</h1>
				</div>
				<div class="modal-body">
					<!--<div class="alert alert-info">That email / password combination was not found, please try again.</div>-->
					<div class="form-group email">
						<label class="col-md-3 control-label" for="email">{{ trans('avalon::messages.users_email') }}</label>
						<div class="col-md-9">
							<input type="text" name="email" class="form-control required email">
						</div>
					</div>
					<div class="form-group password">
						<label class="col-md-3 control-label" for="password">{{ trans('avalon::messages.users_password') }}</label>
						<div class="col-md-9">
							<input type="password" name="password" class="form-control required">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#reset" class="btn btn-default">Reset Password</a>
					<input type="submit" class="btn btn-primary" value="Log In">
				</div>
			</form>
		</div>
	</div>
</div>
@endif