<?php

return [
	'keep_clean',
	'list_grouping' => 'Main Objects',
	'url' => '/blog',
	'list' => ['title', 'publish_date', 'updated_at'],
	'order_by' => ['publish_date' => 'desc'],
	'fields' => [
		'title' => 'string required',
		'slug' => [
			'type' => 'slug',
			'source' => 'title',
		],
		'excerpt' => 'text',
		'image_id' => [
			'type' => 'image',
			'width' => 440,
		],
		'caption' => 'string',
		'content' => 'html',
		'publish_date' => 'date required',
		'tags' => 'checkboxes',
		'updated_at',
		'updated_by',
		'deleted_at',
	],
];