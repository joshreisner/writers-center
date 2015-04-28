<?php

return [	
	'title' => 'Donations',
	'create' => 'Create Donation',
	'edit' => 'Edit Donation',
	'help' => [
		'index' => '',
		'create' => '',
		'edit' => 'Don\'t make changes to donations unless you keep them in sync with Stripe. 
		
		For example, if you first reverse the charge in Stripe, then it\'s ok to delete this record of the transaction.',
	],
	'fields' => [
		'user_id' => 'User',
		'amount' => 'Amount',
		'notes' => 'Notes',
		'created_at' => 'Created',
		'charge_id' => 'Charge',
	],
];	