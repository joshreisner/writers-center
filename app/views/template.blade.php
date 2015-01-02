<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>{{ $title or $default_title }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	    <link rel="icon" href="/assets/img/icons/favicon.ico" type="image/x-icon">
	    <link rel="icon" sizes="128x128" href="/assets/img/icons/favicon-128.png" type="image/png">
	    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/assets/img/icons/favicon-57.png" type="image/png">
	    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/img/icons/favicon-114.png" type="image/png">
	    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/img/icons/favicon-72.png" type="image/png">
	    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/img/icons/favicon-144.png" type="image/png">
		<link rel="stylesheet" href="//f.fontdeck.com/s/css/ApCX21svi87NZWDjljPZF9DNBA4/{{ $_SERVER['SERVER_NAME'] }}/45521.css">
		<link rel="stylesheet" href="/assets/css/main.min.css">
	</head>
	<body class="{{ $class or '' }}">
		<div class="background"></div>
		<div class="container">
			<div class="row banner">
				<div class="col-sm-4 col-xs-9">
					<a href="/" id="logo" class="indent"></a>
				</div>
				<div class="col-sm-8 hidden-xs">
					<nav id="utility">
						@if (!App::environment('production'))
							@if (Auth::guest())
								<a href="#login">Log In</a>
							@else
								<div class="dropdown">
									<a href="#" data-toggle="dropdown"><span class="name">Josh Reisner</span><span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#">News Feed</a></li>
										<li><a href="#">Subscriptions</a></li>
										<li><a href="#">Support</a></li>
										<li><a href="#">Settings</a></li>
										<li class="divider"></li>
										<li><a href="/logout">Log out</a></li>
									</ul>
								</div>
							@endif
						@endif
						<a href="/support">Support the Center</a>
						<a href="https://www.facebook.com/hvwriterscenter" class="fa fa-facebook"></a>
						<a href="https://twitter.com/HVWritersCenter" class="fa fa-twitter"></a>
						<a href="http://instagram.com/hudson_valley_writers_center" class="fa fa-instagram"></a>
						<a href="https://www.youtube.com/channel/UCMyCsXkxuNPK-A0mT8MA8LQ" class="fa fa-youtube"></a>
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
		@include('partials.login')
		<script src="/assets/js/main.min.js"></script>
		@yield('script')
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-53995398-1', 'auto');
			ga('send', 'pageview');
		</script>
	</body>
</html>
