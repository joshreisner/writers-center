<?php

return [
	'keep_clean',
	'list_grouping' => 'Store',
	'list' => ['user_id', 'publication_id', 'created_at', 'amount'],
	'order_by' => ['created_at' => 'desc'],
	'fields' => [
		'user_id' => 'user required',
		'publication_id' => [
			'type' => 'select',
			'source' => 'publications',
			'required',
		],
		'amount' => 'money',
		'charge_id' => 'stripe_charge',
		'shipped_date' => 'date',
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
	],
];