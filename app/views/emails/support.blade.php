<html>
	<head>
		<title>{{ $subject }}</title>
	</head>
	<body style="background-color: {{ $lighter_green }}">
		<div style="background-color: white; border: 1px solid {{ $light_green }}; width: 600px; margin: 0 auto;">
			<div style="color: {{ $green }}; padding: 40px; font-family: Arial, sans-serif; font-size: 16px; line-height: 22px">
<h1 style="margin: 0 0 20px 0;">{{ $subject }}</h1>

<p style="margin: 0 0 20px 0;">Please accept my gratitude for your generous gift of 
	<strong>${{ number_format($transaction->amount / 100) }}</strong>
	to The Hudson Valley Writers Center.* You and our family of contributors enhance 
	the lives of young people of by supporting HVWC programs. These include after-school 
	outreach and summer camps that bring authorship opportunities to young people; 
	courses and workshops for adult writers in every genre; readings, festival, and 
	literary events for everyone; and Slapering Hol Press-sponsored celebrations 
	that build audiences for emerging poets. I encourage you to be in touch with your 
	ideas about shaping the Center’s future. With such input and support as you give to the 
	Writers Center, that future is bright indeed. 

<p style="margin: 0 0 20px 0;">Jo Ann Clark, Executive Director</p>

<p style="margin: 0 0 20px 0;">* As no goods or services were provided, your contribution is deductible for income tax purposes to the extent allowed by law.</p>

<p style="color: {{ $light_green }}; margin: 0; font-size: 14px;">Your payment confirmation is {{ $transaction->confirmation }}.</p>
			</div>
		</div>
	</body>
</html>