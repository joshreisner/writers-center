<?php

return [
	'keep_clean',
	'list_grouping' => 'Main Objects',
	'list' => ['title', 'start', 'updated_at'],
	'url' => '/events',
	'order_by' => ['start'=>'desc'],
	'fields' => [
		'title' => 'string required',
		'start' => 'datetime required',
		'end' => 'datetime required',
		'excerpt' => 'text',
		'description' => 'html',
		'slug' => [
			'type' => 'slug',
			'source' => 'title',
		],
		'price' => 'integer',
		'register_url' => 'url',
		'tags' => 'checkboxes',
		'updated_at',
		'updated_by',
		'deleted_at',
	],
	'links' => [
		'rsvps' => 'event_id',
	],
];