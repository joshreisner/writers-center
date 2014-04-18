<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	$items = array(
		array(
			'type'=>'course',
			'title'=>'Write Flash Fiction!<br>with Peter Andrews',
			'description'=>'6 Mondays, January 6&ndash;February 24<br>1:30&ndash;3:30 P.M.',
			'link_text'=>'Learn More',
		),
		array(
			'type'=>'event',
			'title'=>'Write Flash Fiction!<br>with Peter Andrews',
			'description'=>'6 Mondays, January 6&ndash;February 24<br>1:30&ndash;3:30 P.M.',
			'link_text'=>'Learn More',
		),
		array(
			'type'=>'blog',
			'title'=>'Write Flash Fiction!<br>with Peter Andrews',
			'description'=>'6 Mondays, January 6&ndash;February 24<br>1:30&ndash;3:30 P.M.',
			'link_text'=>'Learn More',
		),
		array(
			'type'=>'publication',
			'title'=>'Write Flash Fiction!<br>with Peter Andrews',
			'description'=>'6 Mondays, January 6&ndash;February 24<br>1:30&ndash;3:30 P.M.',
			'link_text'=>'Learn More',
		),
		array(
			'type'=>'blog',
			'title'=>'Write Flash Fiction!<br>with Peter Andrews',
			'description'=>'6 Mondays, January 6&ndash;February 24<br>1:30&ndash;3:30 P.M.',
			'link_text'=>'Learn More',
		),
		array(
			'type'=>'course',
			'title'=>'Write Flash Fiction!<br>with Peter Andrews',
			'description'=>'6 Mondays, January 6&ndash;February 24<br>1:30&ndash;3:30 P.M.',
			'link_text'=>'Learn More',
		),
		array(
			'type'=>'event',
			'title'=>'Write Flash Fiction!<br>with Peter Andrews',
			'description'=>'6 Mondays, January 6&ndash;February 24<br>1:30&ndash;3:30 P.M.',
			'link_text'=>'Learn More',
		),
	);

	return View::make('home', array(
		'items'=>$items
	));
});

Route::get('/about', function()
{
	return View::make('about')->with('title', 'About');
});

Route::get('/courses', function()
{
	return View::make('courses')->with('title', 'Courses');
});

Route::get('/events', function()
{
	return View::make('events')->with('title', 'Events');
});

Route::get('/blog', function()
{
	return View::make('blog')->with('title', 'Blog');
});

Route::get('/publications', function()
{
	return View::make('publications')->with('title', 'Publications');
});

Route::get('/contact', function()
{
	return View::make('contact')->with('title', 'Contact');
});

View::composer('template', function($view)
{
    $view->with('sections', array(
    	'about'=>'About',
    	'courses'=>'Courses',
    	'events'=>'Events',
    	'blog'=>'Blog',
    	'publications'=>'Publications',
    	'contact'=>'Contact',
    ))
    ->with('app_title', 'Hudson Valley Writers Center');
});
