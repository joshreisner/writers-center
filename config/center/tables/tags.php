<?php

return [
	'keep_clean',
	'list_grouping' => 'Supporting Objects',
	'list' => ['title', 'updated_at'],
	'order_by' => 'title',
	'fields' => [
		'title' => [
			'type' => 'string',
			'required',
		],				
		'updated_at',
		'updated_by',
	],
];