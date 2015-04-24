<?php

return [
	'keep_clean',
	'deletable' => false,
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
		'customer_id' => 'stripe_customer',
		'customer_test_id' => 'stripe_customer hidden',
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
		'membership_expires' => 'date',
		'permissions', 
		'updated_at',
		'updated_by',
	],
	'group_by' => '\App\Http\Controllers\CenterController::groupUsers',
	'search' => ['name', 'email'],
];