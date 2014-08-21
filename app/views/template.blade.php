<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>{{ $title or $default_title }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="stripe_key" content="{{ Config::get('services.stripe.publishable_key') }}">
		<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
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
						<!-- <a class="login">Log In</a> -->
						<a href="https://www.networkforgood.org/donation/ExpressDonation.aspx?ORGID2=133490748&amp;vlrStratCode=Eo7dz7SpHrnTsJ4CwRKKPORCH9aREJ%2fahCNeUqBvv6Q%2bATvddUaKcyEUsRyDmzz2">Support the Center</a>
						<!-- <a href="/support">Support the Center</a> -->
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
