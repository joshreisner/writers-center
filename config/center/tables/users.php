<?php

return [
	'keep_clean',
	'list_grouping' => 'Main Objects',
	'list' => ['name', 'last_login', 'updated_at'],
	'order_by' => 'name',
	'fields' => [
		'name' => [
			'type' => 'string',
			'required',
		],
		'email' => [
			'type' => 'email',
			'required',
		],
		'password' => 'password',
		'remember_token' => [
			'type' => 'string',
			'hidden',
		],
		'last_login' => [
			'type' => 'datetime',
			'hidden',
		],
		'customer_id' => [
			'type' => 'string',
			'hidden',
		],
		'customer_test_id' => [
			'type' => 'string',
			'hidden',
		],
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