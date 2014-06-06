<?php

class AboutController extends BaseController {
	
	/**
	 * home about page
	 */
	public function index() {
		$page = Page::whereNull('slug')->first();
		return View::make('about', array(
			'title'=>$page->title,
			'page'=>$page,
			'pages'=>Page::orderBy('precedence')->get(),
			'class'=>'about',
		));
	}

	/**
	 * about inside page
	 */
	public function show($slug) {
		$page = Page::where('slug', $slug)->first();
		return View::make('about', array(
			'title'=>$page->title,
			'page'=>$page,
			'pages'=>Page::orderBy('precedence')->get(),
			'class'=>'about',
		));
	}

}