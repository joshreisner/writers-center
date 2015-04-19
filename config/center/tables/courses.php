<?php

return [
	'keep_clean',
	'list_grouping' => 'Main Objects',
	'url' => '/courses',
	'list' => ['title', 'course_instructor', 'updated_at'],
	'group_by' => 'genre_id',
	'order_by' => 'title',
	'fields' => [
		'title' => [
			'type' => 'string',
			'required',	
		],
		'genre_id' => [
			'type' => 'select',
			'source' => 'genres',
		],
		'description' => 'text',
		'tuition' => 'integer',
		'tutorial' => 'checkbox',
		'instructors' => 'checkboxes',
		'slug' => [
			'type' => 'slug',
			'source' => 'title',
		],
		'updated_at',
		'updated_by',
		'deleted_at',
	],
	'links' => [
		'sections' => 'course_id',	
	],
];