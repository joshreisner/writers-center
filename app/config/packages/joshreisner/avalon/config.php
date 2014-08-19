<?php

return array(
	
	//specify custom stylesheets
	'css'					=> array(
		'//f.fontdeck.com/s/css/ApCX21svi87NZWDjljPZF9DNBA4/' . getenv('SERVER_NAME') . '/45521.css',
		'/assets/css/avalon.min.css', 
	), 

	//prefix all table names
	'db_fields'				=> 'avalon_fields',
	'db_files'				=> 'avalon_files',
	'db_object_links'		=> 'avalon_object_links',
	'db_object_user'		=> 'avalon_object_user',
	'db_objects'			=> 'avalon_objects',
	'db_users'				=> 'users',

	//specify image display size in the instance.create and .edit views
	'image_default_width'	=> 220,
	'image_default_height'	=> 100,
	'image_max_width'		=> 701,
	'image_max_height'		=> 240,
	'image_max_area'		=> 60000, //701 * 240 = 168240

	//specifies the path to find the cms at, eg http://example.com/login
	'route_prefix'			=> 'login',

);