<?php

return [
	'keep_clean',
	'list_grouping' => 'Store',
	'list' => ['section_id', 'user_id', 'created_at', 'amount'],
	'order_by' => ['created_at' => 'desc'],
	'fields' => [
		'user_id' => 'user required',
		'section_id' => [
			'type' => 'select',
			'source' => 'sections',
			'required',
		],
		'amount' => 'money required',
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
	],
];