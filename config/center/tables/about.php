<?php
	
return [
	'keep_clean',
	'list_grouping' => 'Main Objects',
	'list' => ['title', 'updated_at'],
	'order_by' => 'precedence',
	'url' => '/about',
	'model' => 'Page',
	'search' => ['title', 'content'],
	'fields' => [
		'title' => 'string required',
		'slug' => [
			'type' => 'slug',
			'source' => 'title',
		],
		'content' => 'html',
		'updated_at',
		'updated_by',
		'deleted_at',
		'precedence',
	],	
];