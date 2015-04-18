<?php

return [
	'keep_clean',
	'hidden',
	'list_grouping' => 'My HVWC',
	'order_by' => ['created_at' => 'desc'],
	'fields' => [
		'content' => 'html',
		'course_id' => [
			'type' => 'select',
			'source' => 'courses',
		],
		'updated_at',
		'updated_by',
		'created_at',
		'created_by',
		'deleted_at',
		'deleted_by',
	],
];