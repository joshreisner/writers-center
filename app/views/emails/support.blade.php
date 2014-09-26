@extends('emails.template')

@section('content')
	<p style="color: {{ $green }}; margin: 0 0 20px 0;">Please accept my gratitude for your generous gift of 
		<strong>${{ number_format($transaction->amount / 100) }}</strong>
		to The Hudson Valley Writers Center.* You and our family of contributors enhance 
		the lives of young people of by supporting HVWC programs. These include after-school 
		outreach and summer camps that bring authorship opportunities to young people; 
		courses and workshops for adult writers in every genre; readings, festival, and 
		literary events for everyone; and Slapering Hol Press-sponsored celebrations 
		that build audiences for emerging poets. I encourage you to be in touch with your 
		ideas about shaping the Center’s future. With such input and support as you give to the 
		Writers Center, that future is bright indeed.</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">Jo Ann Clark<br><em>Executive Director</em></p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">* As no goods or services were provided, your contribution is deductible for income tax purposes to the extent allowed by law.</p>

	<p style="color: {{ $light_green }}; margin: 0 0 30px 0; font-size: 14px;">Your payment confirmation is {{ $transaction->confirmation }}.</p>

@endsection
