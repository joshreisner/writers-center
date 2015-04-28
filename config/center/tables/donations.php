<?php

return [
	'keep_clean',
	'creatable' => true,
	'editable' => true,
	'deletable' => true,
	'list_grouping' => 'Store',
	'list' => ['user_id', 'notes', 'created_at', 'amount'],
	'order_by' => ['created_at' => 'desc'],
	'fields' => [
		'user_id' => 'user required',
		'amount' => 'money required',
		'charge_id' => 'stripe_charge',
		'notes' => 'string',
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
	],
	'filters' => ['user_id'],
];