<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>{{ $title or $app_title }}</title>
		<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="//f.fontdeck.com/s/css/uH5+KWQnibDTJRYggGJ9XZLTAgw/{{ $_SERVER['SERVER_NAME'] }}/45521.css">
		<link rel="stylesheet" href="/bower_components/dashicons/css/dashicons.css">
		<link rel="stylesheet" href="/assets/css/main.css">
	</head>
	<body class="@yield('body_class');">
		<div class="container">
			<div class="row banner">
				<div class="col-md-12">
					<a href="/"><img src="/assets/img/logo.png" width="330" height="127" class="img-responsive"></a>

					<nav id="utility">
						<a href="#">Log In</a>
						<a href="#">Support the Center</a>
						<a href="#" class="dashicons dashicons-facebook"></a>
						<a href="#" class="dashicons dashicons-twitter"></a>
					</nav>

				</div>
			</div>
			<div class="row nav">
				@foreach ($sections as $url=>$section)
				<div class="col-md-2 {{ Request::is($url . '*') ? 'active' : '' }}"><a href="/{{ $url }}" class="{{ $url }}">{{ $section }}</a></div>
				@endforeach
			</div>
		</div>

		@yield('content')

		<script src="/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	</body>
</html>
