<?php

return [
	'keep_clean',
	'list_grouping' => 'Store',
	'list' => ['user_id', 'section_id', 'created_at'],
	'fields' => [
		'user_id' => [
			'type' => 'user',
			'required',
		],
		'section_id' => [
			'type' => 'select',
			'source' => 'sections',
			'required',
		],
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
	],
];