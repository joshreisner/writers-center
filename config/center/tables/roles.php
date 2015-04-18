<?php

return [
	'list' => ['name', 'role', 'updated_at'],
	'list_grouping' => 'Main Objects',
	'order_by' => 'precedence',
	'group_by' => 'group_id',
	'fields'=> [
		'group_id' => [
			'type' => 'select',
			'source' => 'groups',
			'required',	
		],
		'name' => [
			'type' => 'string',
			'required',
		],
		'role' => 'string',
		'bio' => 'html',
		'updated_at',
		'updated_by',
		'deleted_at',
		'precedence',
	],
];