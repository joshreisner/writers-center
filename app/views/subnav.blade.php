<div class="col-md-3 subnav">
	<div class="well">
		@foreach ($pages as $url=>$page)
		<li class="{{ Request::is($url) ? 'active' : '' }}"><a href="/{{ $url }}">{{ $page }}</a></li>
		@endforeach
	</div>
</div>
