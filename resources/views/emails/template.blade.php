<html>
	<head>
		<title>{{ $subject }}</title>
	</head>
	<body style="margin: 0;">
		<div style="background-color: white; border-top: 3px solid {{ $green }}; margin: 20px auto; max-width: 600px;">
			<div style="padding-top: 24px; padding-bottom: 24px; font-family: Arial, sans-serif; font-size: 16px; line-height: 22px; color: {{ $green }};">

				<h1 style="color: {{ $green }}; margin: 0 0 24px 0; font-size: 30px; line-height: 30px; font-weight: bold;">{{ $subject }}</h1>

				@yield('content')

				<p style="margin: 0;"><img src="http://writerscenter.org/assets/img/logo-default.png" width="340" height="131" alt="{{ date(DATE_ATOM) }}" style="max-width: 100%; height: auto;"></p>

			</div>
		</div>
	</body>
</html>