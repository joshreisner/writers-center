<?php

return [
	'list' => ['title', 'updated_at'],
	'list_grouping' => 'Supporting Objects',
	'order_by' => 'precedence',
	'fields'=> [
		'title' => 'string required',
		'updated_at',
		'updated_by',
		'precedence',
	],
];