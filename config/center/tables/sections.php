<?php

return [
	'keep_clean',
	'list_grouping' => 'Supporting Objects',
	'order_by' => ['start' => 'desc'],
	'list' => ['title', 'start', 'updated_at'],
	'group_by' => 'course_id',
	'fields' => [
		'title' => [
			'type' => 'string',
			'required',
		],
		'course_id' => [
			'type' => 'select',
			'source' => 'courses',
			'required',	
		],
		'classes' => 'integer',
		'day_id' => [
			'type' => 'select',
			'source' => 'days',
		],
		'start' => [
			'type' => 'datetime',
			'required',
		],
		'end' => [
			'type' => 'datetime',
			'required',
		],
		'notes' => 'string',
		'price' => 'integer',
		'register_url' => 'string',
		'updated_at',
		'updated_by',
		'deleted_at',
	],
];