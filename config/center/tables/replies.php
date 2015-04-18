<?php

return [
	'hidden',
	'keep_clean',
	'list_grouping' => 'My HVWC',
	'order_by' => ['created_date', 'asc'],
	'group_by' => 'message_id',
	'fields' => [
		'content' => 'html',
		'message_id' => [
			'type' => 'select',
			'source' => 'messages',
		],
		'updated_at',
		'updated_by',
		'created_at',
		'created_by',
		'deleted_at',
		'deleted_by',
	],
];