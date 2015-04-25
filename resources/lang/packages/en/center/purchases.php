<?php

return [	
	'title' => 'Book Purchases',
	'create' => 'Create Purchase Record',
	'edit' => 'Edit Purchase Record',
	'help' => [
		'index' => 'Open Orders have no ship date.',
		'create' => 'Adding a ship date closes the order. Purchases made in person should be considered shipped.',
		'edit' => 'Adding a ship date closes the order. Purchases made in person should be considered shipped.',
	],
	'fields' => [
		'publication_id' => 'Book',
		'user_id' => 'User',
		'charge_id' => 'Charge',
		'shipped_date' => 'Shipped',
		'amount' => 'Amount',
		'created_at' => 'Created',
	],
];	