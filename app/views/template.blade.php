<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>{{ $title or $app_title }}</title>
		<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="/assets/css/main.css">
	</head>
	<body class="home">
		<div class="container">
			<div class="row banner">
				<div class="col-md-12">
					<a href="/"><img src="/assets/img/logo.png" width="330" height="127"></a>

					<a href="#" class="login">
						<i class="glyphicon glyphicon-user"></i>
						Log In
					</a>
				</div>
			</div>
			<div class="row nav">
				@foreach ($sections as $url=>$section)
				<div class="col-md-2"><a href="/{{ $url }}" class="{{ Request::is($url) ? 'active' : '' }}">{{ $section }}</a></div>
				@endforeach
			</div>
		</div>
		@yield('content')
	</body>
</html>
