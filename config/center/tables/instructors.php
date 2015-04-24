<?php

return [
	'keep_clean',
	'list_grouping' => 'Main Objects',
	'list' => ['image_id', 'name', 'updated_at'],
	'order_by' => 'name',
	'fields' => [
		'image_id' => [
			'type' => 'image',
			'width' => 440,
		],		
		'name' => 'string required',
		'bio' => 'html',
		'updated_at',
		'updated_by',
		'deleted_at',
		'precedence',
	],
	'search' => ['name'],
];