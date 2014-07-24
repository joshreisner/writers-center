@if (Session::has('message'))
	<div class="alert alert-info">
		{{ Session::get('message') }}
	</div>
@elseif (Session::has('error'))
	<div class="alert alert-warning">
		{{ Session::get('error') }}
	</div>
@endif
