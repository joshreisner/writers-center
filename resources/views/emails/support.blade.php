@extends('emails.template')

@section('content')
	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		Please accept our gratitude for your generous gift of 
		<strong>${{ number_format($transaction->amount / 100) }}</strong>
		to The Hudson Valley Writers' Center.* Your contribution is very meaningful 
		to the Center and will help us to continue and improve our programmatic implementation 
		of our core mission to encourage and teach the art and craft of creative writing, to 
		publish new and exciting poets and to bring interesting and important poets, fiction 
		writers, memoirists and creative non-fiction authors to the lower Hudson Valley. We 
		encourage you to be in touch with your ideas about shaping the Center’s future.
	</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		HVWC Staff and Board of Directors
	</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		* As no goods or services were provided, your contribution is deductible for income tax 
		purposes to the extent allowed by law.
	</p>

	<p style="color: {{ $light_green }}; margin: 0 0 30px 0; font-size: 14px;">
		Your payment confirmation is {{ $transaction->confirmation }}.
	</p>

@endsection
