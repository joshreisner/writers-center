<?php

return [
	'keep_clean',
	'list' => ['image_id', 'title', 'publish_date', 'updated_at'],
	'list_grouping' => 'Main Objects',
	'order_by' => ['publish_date' => 'desc'],
	'fields' => [
		'image_id' => [
			'type' => 'image',
			'width' => 400,
		],
		'title' => [
			'type' => 'string',
			'required',
		],
		'author' => 'string',
		'publish_date' => 'date',
		'price' => 'integer',
		'type' => [
			'type' => 'select',
			'source' => 'publication_types',
		],
		'pages' => 'integer',
		'description' => 'html',
		'paypal_id' => 'string',
		'updated_at',
		'updated_by',
		'deleted_at',
	],
];