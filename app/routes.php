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
	//set type slugs
	$carouselItems = CarouselItem::with('carousel_types')->take(7)->orderBy('precedence')->get();
	foreach ($carouselItems as &$item) $item->type = Str::slug($item->carousel_types->title);

	return View::make('home', array(
		'items'=>$carouselItems,
		'promos'=>Promo::take(3)->orderBy('precedence')->get(),
	));
});

Route::group(array('prefix' => 'about'), function()
{
	$subnav = array();
	$pages = Page::orderBy('precedence')->get();
	foreach ($pages as $page) {
		$subnav['about' . (empty($page->slug) ? '' : '/' . $page->slug)] = $page->title;

		Route::get($page->slug, function() use ($page)
		{
			return View::make('about', array(
				'title'=>$page->title,
				'content'=>$page->content,
			));
		});
	}

	View::composer('subnav', function($view) use ($subnav)
	{
	    $view->with('pages', $subnav)
	    ->with('app_title', 'Hudson Valley Writers Center');
	});
});

Route::get('/courses', function()
{
	return View::make('courses', array(
		'title'=>'Courses',
		'genres'=>Genre::with('courses')->get(),
		'days'=>Day::get(),
	));
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