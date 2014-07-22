<h1>{{ $subject }}</h1>

<p>Thank you for your gift of ${{ number_format($transaction->amount / 100) }}.</p>

<p>Your payment confirmation is {{ $transaction->confirmation }}.</p>

<p>&ndash; Writers Center</p>