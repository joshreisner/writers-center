<?php

return [
	'keep_clean',
	'list_grouping' => 'Main Objects',
	'list' => ['backing_id', 'title', 'updated_at'],
	'order_by' => 'precedence',
	'fields' => [
		'backing_id' => [
			'type' => 'image',
			'width' => 654,
			'height' => 400,
		],
		'title' => [
			'type' => 'text',
			'required',	
		],
		'course_id' => [
			'type' => 'select',
			'source' => 'courses'
		],
		'event_id' => [
			'type' => 'select',
			'source' => 'events'
		],
		'post_id' => [
			'type' => 'select',
			'source' => 'posts'
		],
		'publication_id' => [
			'type' => 'select',
			'source' => 'publications',	
		],
		'content' => 'text',
		'updated_at',
		'updated_by',
		'deleted_at',
		'precedence',
	],
];