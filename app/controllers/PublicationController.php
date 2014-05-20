<?php

class PublicationController extends BaseController {
	
	/**
	 * show home page
	 */
	function index() {
		return View::make('publications.index', array(
			'title'=>'Publications',
			'publications'=>Publication::orderBy('precedence')->get(),
			'types'=>PublicationType::orderBy('title')->get(),
		));		
	}

	/**
	 * show individual publication page
	 */
	function show($slug) {
		$publication = Publication::where('slug', $slug)->first();
		return View::make('publications.publication', array(
			'title'=>$publication->title,
			'publications'=>Publication::orderBy('precedence')->get(),
			'types'=>PublicationType::orderBy('title')->get(),
			'publication'=>$publication,
		));
	}
}