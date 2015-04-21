<?php

return [
	'keep_clean',
	'hidden',
	'list' => ['title', 'updated_at'],
	'order_by' => 'precedence',
	'fields' => [
		'title' => 'string required',
		'updated_at',
		'updated_by',
		'precedence',
	],
];