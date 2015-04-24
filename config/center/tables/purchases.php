<?php

return [
	'keep_clean',
	'list_grouping' => 'Store',
	'list' => ['user_id', 'publication_id', 'amount', 'created_at'],
	'fields' => [
		'user_id' => 'user required',
		'publication_id' => [
			'type' => 'select',
			'source' => 'publications',
			'required',
		],
		'amount' => 'integer',
		'charge_id' => 'string',
		'shipped_date' => 'date',
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
	],
];