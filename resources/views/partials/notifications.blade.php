<!--[if lt IE 9]>
    <div class="alert alert-warning">You are using an outdated browser! Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</div>
<![endif]-->

@if (Session::has('message'))
	<div class="alert alert-info">
		{{ Session::get('message') }}
	</div>
@elseif (Session::has('error'))
	<div class="alert alert-warning">
		{{ Session::get('error') }}
	</div>
@endif
