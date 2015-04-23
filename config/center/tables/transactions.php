<?php

return [
	'keep_clean',
	'creatable' => false,
	'editable' => false,
	'deletable' => false,
	'list_grouping' => 'Store',
	'list' => ['confirmation', 'type_id', 'amount', 'created_at'],
	'fields' => [
		'user_id' => [
			'type' => 'select',
			'source' => 'users',
			'required',
		],
		'confirmation' => 'string',
		'paid' => 'checkbox',
		'charge_id' => 'string',
		'type_id' => [
			'type' => 'select',
			'source' => 'transaction_types',
			'required',
		],
		'amount' => 'integer',
		'created_at',
		'updated_at',
		'updated_by',
	],
];