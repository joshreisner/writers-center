<?php

return [
	'keep_clean',
	'list_grouping' => 'Supporting Objects',
	'list' => ['title', 'context_policy', 'updated_at'],
	'order_by' => 'precedence',
	'fields' => [
		'title' => 'string required',
		'content' => 'html',
		'contexts' => 'checkboxes',
		'updated_at',
		'updated_by',
		'deleted_at',
		'precedence',
	],
];