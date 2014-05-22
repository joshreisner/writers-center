<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>{{ $title or $default_title }}</title>
		<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="//f.fontdeck.com/s/css/uH5+KWQnibDTJRYggGJ9XZLTAgw/{{ $_SERVER['SERVER_NAME'] }}/45521.css">
		<link rel="stylesheet" href="/bower_components/dashicons/css/dashicons.css">
		<link rel="stylesheet" href="/assets/css/main.css">
	</head>
	<body class="{{ $class or $default_class }}">
		<div class="container">
			<div class="row banner">
				<div class="col-md-8">
					<a href="/" class="logo col-md-offset-1"><img src="/assets/img/logo.png" width="290" height="112" class="img-responsive"></a>
				</div>
				<div class="col-md-4">
					<nav id="utility">
						<a class="login">Log In</a>
						<a href="/support">Support the Center</a>
						<a href="https://www.facebook.com/hvwriterscenter" class="dashicons dashicons-facebook"></a>
						<a href="https://twitter.com/HVWritersCenter" class="dashicons dashicons-twitter"></a>
					</nav>
				</div>
			</div>
			<div class="row nav">
				@foreach ($sections as $url=>$section)
				<div class="col-md-2 {{ Request::is($url . '*') ? 'active' : '' }}"><a href="/{{ $url }}" class="{{ $url }}">{{ $section }}</a></div>
				@endforeach
			</div>
		</div>

		@yield('page')

		<script src="/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="/assets/js/main.js"></script>
	</body>
</html>
