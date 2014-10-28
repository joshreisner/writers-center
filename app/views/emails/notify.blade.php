@extends('emails.template')

@section('content')

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		Amount: 
		<strong>${{ number_format($transaction->amount / 100) }}</strong>
		</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		Type:
		<strong>{{ $type }}</strong>
	</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		User:
		<strong>{{ $user_name }}</strong>
	</p>

	<p style="color: {{ $green }}; margin: 0 0 20px 0;">
		Confirmation:
		<strong>{{ $transaction->confirmation }}</strong>
	</p>

@endsection
