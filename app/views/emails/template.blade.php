<html>
	<head>
		<title>{{ $subject }}</title>
	</head>
	<body style="margin: 0;">
		<div style="background-color: white; border-top: 3px solid {{ $green }}; margin: 5px auto; max-width: 600px;">
			<div style="padding-top: 24px; padding-bottom: 24px; font-family: Arial, sans-serif; font-size: 16px; line-height: 22px">

				<h1 style="color: {{ $green }}; margin: 0 0 24px 0; font-size: 30px; line-height: 34px; font-weight: normal;">{{ $subject }}</h1>

				@yield('content')

				<p style="margin-top: 0; margin-bottom: 10px;"><img src="http://writerscenter.org/assets/img/logo-default.png" width="340" height="131" style="max-width: 100%; height: auto;"></p>
				
				<p style="margin: 0; color:#eeeeee;">Message sent on {{ date(DATE_ATOM) }}</p>
			</div>
		</div>
	</body>
</html>