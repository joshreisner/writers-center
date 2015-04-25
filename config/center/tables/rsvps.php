<?php

return [
	'keep_clean',
	'list_grouping' => 'Store',
	'creatable' => true,
	'editable' => true,
	'deletable' => true,
	'order_by' => ['created_at' => 'desc'],
	'list' => ['event_id', 'user_id', 'created_at', 'amount'],
	'fields' => [
		'user_id' => 'user required',
		'event_id' => [
			'type' => 'select',
			'source' => 'events',
			'required',
		],
		'charge_id' => 'stripe_charge',
		'amount' => 'money required',
		'created_at',
		'updated_at',
		'updated_by',
	],
];