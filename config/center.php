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
		'carousel_items' => [
			'keep_clean',
			'list_grouping' => 'Main Objects',
			'list' => ['backing_id', 'title', 'updated_at'],
			'order_by' => 'precedence',
			'fields' => [
				'backing_id' => [
					'type' => 'image',
					'width' => 654,
					'height' => 400,
				],
				'title' => [
					'type' => 'text',
					'required',	
				],
				'course_id' => [
					'type' => 'select',
					'source' => 'courses'
				],
				'event_id' => [
					'type' => 'select',
					'source' => 'events'
				],
				'post_id' => [
					'type' => 'select',
					'source' => 'posts'
				],
				'publication_id' => [
					'type' => 'select',
					'source' => 'publications',	
				],
				'content' => 'text',
				'updated_at',
				'updated_by',
				'deleted_at',
				'precedence',
			],
		],
		'contexts' => [
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
		'events' => [
			'keep_clean',
			'list_grouping' => 'Main Objects',
			'list' => ['title', 'start', 'updated_at'],
			'url' => '/events',
			'order_by' => ['start'=>'desc'],
			'fields' => [
				'title' => [
					'type' => 'string',
					'required',
				],
				'start' => [
					'type' => 'datetime',
					'required',
				],
				'end' => [
					'type' => 'datetime',
					'required',
				],
				'excerpt' => 'text',
				'description' => 'html',
				'slug' => [
					'type' => 'slug',
					'source' => 'title',
				],
				'price' => 'integer',
				'register_url' => 'url',
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
		'policies' => [
			'keep_clean',
			'list_grouping' => 'Supporting Objects',
			'list' => ['title', 'context_policy', 'updated_at'],
			'order_by' => 'precedence',
			'fields' => [
				'title' => [
					'type' => 'string',
					'required',
				],
				'content' => 'html',
				'contexts' => 'checkboxes',
				'updated_at',
				'updated_by',
				'deleted_at',
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
		'publications' => [
			'keep_clean',
			'list' => ['image_id', 'title', 'publish_date', 'updated_at'],
			'list_grouping' => 'Main Objects',
			'order_by' => ['publish_date' => 'desc'],
			'fields' => [
				'image_id' => [
					'type' => 'image',
					'width' => 400,
				],
				'title' => [
					'type' => 'string',
					'required',
				],
				'author' => 'string',
				'publish_date' => 'date',
				'price' => 'integer',
				'type' => [
					'type' => 'select',
					'source' => 'publication_types',
				],
				'pages' => 'integer',
				'description' => 'html',
				'paypal_id' => 'string',
				'updated_at',
				'updated_by',
				'deleted_at',
			],
		],
		'publication_types' => [
			'list' => ['title', 'updated_at'],
			'list_grouping' => 'Supporting Objects',
			'order_by' => 'precedence',
			'fields'=> [
				'title' => [
					'type' => 'string',
					'required',
				],
				'updated_at',
				'updated_by',
				'precedence',
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