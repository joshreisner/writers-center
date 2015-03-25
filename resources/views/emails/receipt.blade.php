@extends('emails.template')

@section('content')

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">Enjoy your purchase! In making it, you foster the entire Hudson Valley Writers’ Center 
	community and the emerging poets of HVWC’s imprint, Slapering Hol Press. Thank you 
	for your support.</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">Jo Ann Clark<br><em>Executive Director</em></p>

	<p style="color: {{ $light_green }}; margin: 0 0 30px 0; font-size: 14px;">Your payment confirmation is {{ $transaction->confirmation }}.</p>

@endsection
