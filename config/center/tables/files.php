<?php

return [
	'keep_clean',
	'hidden',
	'fields' => [
		'row_id' => 'integer',
		'table' => 'string required',
		'field' => 'string required',
		'url' => 'string required',
		'width' => 'integer',
		'height' => 'integer',
		'size' => 'integer required',
		'created_at',
		'created_by',
		'precedence'=>'integer',
	],
];