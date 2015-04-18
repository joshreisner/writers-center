<?php

return [
	'keep_clean',
	'list_grouping' => 'Supporting Objects',
	'list' => ['title', 'updated_at'],
	'order_by' => 'precedence',
	'fields' => [
		'title' => [
			'type' => 'string',
			'required',
		],
		'shp' => 'checkbox',
		'updated_at',
		'updated_by',
		'precedence',				
	]
];