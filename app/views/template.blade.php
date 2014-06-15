<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>{{ $title or $default_title }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="//f.fontdeck.com/s/css/ApCX21svi87NZWDjljPZF9DNBA4/{{ $_SERVER['SERVER_NAME'] }}/45521.css">
		<link rel="stylesheet" href="/bower_components/dashicons/css/dashicons.css">
		@yield('style')
		<link rel="stylesheet" href="/assets/css/main.css">
	</head>
	<body class="{{ $class or '' }}">
		<div class="background"></div>
		<div class="container">
			<div class="row banner">
				<div class="col-md-4 col-xs-9">
					<a href="/" class="logo indent"><img src="/assets/img/logo-{{ $class or 'default' }}.png" width="290" height="112" class="img-responsive"></a>
				</div>
				<div class="col-md-8 hidden-xs">
					<nav id="utility">
						<!-- <a class="login">Log In</a> -->
						<a href="https://www.networkforgood.org/donation/ExpressDonation.aspx?ORGID2=133490748&amp;vlrStratCode=Eo7dz7SpHrnTsJ4CwRKKPORCH9aREJ%2fahCNeUqBvv6Q%2bATvddUaKcyEUsRyDmzz2">Support the Center</a>
						<a href="https://www.facebook.com/hvwriterscenter" class="dashicons dashicons-facebook"></a>
						<a href="https://twitter.com/HVWritersCenter" class="dashicons dashicons-twitter"></a>
					</nav>
				</div>
			</div>
			<div class="row nav">
				<div class="col-md-12">
					<ul>
					@foreach ($sections as $url=>$section)
						<li class="{{ Request::is($url . '*') ? 'active' : '' }}"><a href="/{{ $url }}" class="{{ $url }}">{{ $section }}</a></li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>

		@yield('page')

		<script src="/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		@yield('script')
		<script src="/assets/js/main.js"></script>
	</body>
</html>
