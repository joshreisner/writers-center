<?php

return [
	'keep_clean',
	'list_grouping' => 'Supporting Objects',
	'order_by' => ['start' => 'desc'],
	'list' => ['title', 'open', 'start', 'updated_at'],
	//'group_by' => 'course_id',
	'hidden',
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
		'start' => 'datetime required',
		'end' => 'datetime required',
		'notes' => 'string',
		'price' => 'integer',
		'register_url' => 'string',
		'open' => 'checkbox',
		'updated_at',
		'updated_by',
		'deleted_at',
	],
	'links' => [
		'enrollments' => 'section_id',
	],
];