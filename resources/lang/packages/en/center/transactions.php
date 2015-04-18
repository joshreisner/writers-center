<?php

return [	
	'title' => 'Transactions',
	'help' => [
		'index' => 'These transactions are charges must stay in sync with Stripe and are not to be edited.
		
				Amounts are in cents, per Stripe\'s convention. So 500 is $5.',
		'create' => '',
		'edit' => '',
	],
	'fields' => [
		'confirmation' => 'Confirmation',
		'user_id' => 'User',
		'paid' => 'Paid?',
		'charge_id' => 'Charge ID',
		'amount' => 'Amount',
		'type_id' => 'Type',
		'updated_at' => 'Updated',
		'created_at' => 'Created',
	],
];	