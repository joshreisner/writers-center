<?php

return [
	'billable',
	'list_grouping' => 'Main Objects',
	'list' => ['name', 'last_login', 'updated_at'],
	'order_by' => 'name',
	'fields' => [
		'name' => 'string required',
		'email' => 'email required',
		'password' => 'password',
		'remember_token' => 'string hidden',
		'token' => 'string hidden',
		'last_login' => 'datetime hidden',
		'customer_id' => 'string hidden',
		'customer_test_id' => 'string hidden',
		'address' => 'string',
		'city' => 'string',
		'state' => [
			'type' => 'us_state',
			'length' => 2,
		],
		'zip' => [
			'type' => 'string',
			'length' => 5,
		],
		'phone' => 'string',
		'permissions', 
		'updated_at',
		'updated_by',
		'deleted_at',
	],
];