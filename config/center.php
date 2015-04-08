<?php

return [

	'css' => [
		'//f.fontdeck.com/s/css/ApCX21svi87NZWDjljPZF9DNBA4/' . env('SERVER_NAME') . '/45521.css',
		'/vendor/center/css/main.min.css',
		'/assets/css/center.css',
	],
	
	'prefix' => 'login',

	//your tables
	'tables' => [
		'about' => [
			'keep_clean',
			'list_grouping' => 'Main Objects',
			'list' => ['title', 'updated_at'],
			'order_by' => 'precedence',
			'url' => '/about',
			'model' => 'Page',
			'fields' => [
				'title' => [
					'type' => 'string',
					'required',
				],
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
		],
		'courses' => [
			'keep_clean',
			'list_grouping' => 'Main Objects',
			'url' => '/courses',
			'list' => ['title', 'course_instructor', 'updated_at'],
			'fields' => [
				'title' => [
					'type' => 'string',
					'required',	
				],
				'genre_id' => [
					'type' => 'select',
					'source' => 'genres',
				],
				'description' => 'text',
				'tuition' => 'integer',
				'tutorial' => 'checkbox',
				'instructors' => 'checkboxes',
				'slug' => [
					'type' => 'slug',
					'source' => 'title',
				],
				'updated_at',
				'updated_by',
				'deleted_at',
					
			],
		],
		'genres' => [
			'keep_clean',
			'list_grouping' => 'Supporting Objects',
			'list' => ['title', 'updated_at'],
			'order_by' => 'precedence',
			'fields' => [
				'title' => [
					'type' => 'string',
					'required',
				],				
				'updated_at',
				'updated_by',
				'precedence',
			],
		],
		'instructors' => [
			'keep_clean',
			'list_grouping' => 'Main Objects',
			'list' => ['image_id', 'name', 'updated_at'],
			'order_by' => 'name',
			'fields' => [
				'image_id' => [
					'type' => 'image',
					'width' => 440,
				],		
				'name' => [
					'type' => 'string',
					'required',
				],
				'bio' => 'html',
				'updated_at',
				'updated_by',
				'precedence',
			],
		],
		'posts' => [
			'keep_clean',
			'list_grouping' => 'Main Objects',
			'url' => '/blog',
			'list' => ['title', 'publish_date', 'updated_at'],
			'order_by' => ['publish_date' => 'desc'],
			'fields' => [
				'title' => [
					'type' => 'string',
					'required',
				],
				'slug' => [
					'type' => 'slug',
					'source' => 'title',
				],
				'excerpt' => 'text',
				'image_id' => [
					'type' => 'image',
					'width' => 440,
				],
				'caption' => 'string',
				'content' => 'html',
				'publish_date' => [
					'type' => 'date',
					'required',	
				],
				'tags' => 'checkboxes',
				'updated_at',
				'updated_by',
				'deleted_at',
			],
		],
		'tags' => [
			'keep_clean',
			'list_grouping' => 'Supporting Objects',
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
		],
		'users' => [
			'keep_clean',
			'list_grouping' => 'Main Objects',
			'list' => ['name', 'last_login', 'updated_at'],
			'order_by' => 'name',
			'fields' => [
				'name' => [
					'type' => 'string',
					'required',
				],
				'email' => [
					'type' => 'email',
					'required',
				],
				'password' => 'password',
				'remember_token' => [
					'type' => 'string',
					'hidden',
				],
				'last_login' => [
					'type' => 'datetime',
					'hidden',
				],
				'customer_id' => [
					'type' => 'string',
					'hidden',
				],
				'customer_test_id' => [
					'type' => 'string',
					'hidden',
				],
				'address' => 'string',
				'city' => 'string',
				'state' => [
					'type' => 'us_state',
					'length' => 2,
				],
				'zip' => [
					'type' => 'string',
					'length' => 5,
				],
				'phone' => 'string',
				'permissions', 
				'updated_at',
				'updated_by',
				'deleted_at',
			],
		],
	],
];