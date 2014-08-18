<h1>{{ $subject }}</h1>

<p>Please accept my gratitude for your generous gift of 
	${{ number_format($transaction->amount / 100) }} 
	to The Hudson Valley Writers Center.* You and our family of contributors enhance 
	the lives of young people of by supporting HVWC programs. These include after-school 
	outreach and summer camps that bring authorship opportunities to young people; 
	courses and workshops for adult writers in every genre; readings, festival, and 
	literary events for everyone; and Slapering Hol Press-sponsored celebrations 
	that build audiences for emerging poets. I encourage you to be in touch with your 
	ideas about shaping the Center’s future. With such input and support as you give to the 
	Writers Center, that future is bright indeed. 

<p>Jo Ann Clark, Executive Director</p>

<p>* As no goods or services were provided, your contribution is deductible for income tax purposes to the extent allowed by law.</p>

<p>Your payment confirmation is {{ $transaction->confirmation }}.</p>