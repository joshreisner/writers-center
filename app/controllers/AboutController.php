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

	/**
	 * generate avalon link
	 */
	public static function editLink(Page $page) {
		if (!Auth::user()) return false;
		return link_to(URL::action('InstanceController@edit', array(13, $page->id)) . '?return_to=' . urlencode(Url::current()), '', array('class'=>'edit dashicons dashicons-welcome-write-blog'));
	}

}