<?php

return [
	'keep_clean',
	'creatable' => true,
	'editable' => true,
	'deletable' => true,
	'list_grouping' => 'Store',
	'list' => ['user_id', 'created_at', 'amount'],
	'group_by' => 'event_id',
	'fields' => [
		'user_id' => 'user required',
		'event_id' => [
			'type' => 'select',
			'source' => 'events',
			'required',
		],
		'charge_id' => 'stripe_charge',
		'amount' => 'money',
		'created_at',
		'updated_at',
		'updated_by',
	],
];