<?php
	
return [
	'keep_clean',
	'hidden',
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