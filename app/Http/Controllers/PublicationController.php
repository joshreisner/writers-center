<?php namespace App\Http\Controllers;

use DB;
use LeftRight\Center\Models\Publication;
use LeftRight\Center\Models\PublicationType;
use URL;
use View;

class PublicationController extends Controller {
	
	/**
	 * show home page
	 */
	function index() {
		# Set publication URLs
		$publications = Publication::orderBy('publish_date', 'desc')->get();
		foreach ($publications as $publication) {
			$publication->url = self::url($publication);
		}

		$title = 'Slapering Hol Press';
		$years = Publication::orderBy('publish_date', 'desc')->select(DB::raw('YEAR(publish_date) AS publish_date'))->distinct()->lists('publish_date', 'publish_date');
		$types = PublicationType::orderBy('title')->lists('title', 'id');

		return View::make('publications.index', compact('title', 'publications', 'years', 'types'));		
	}

	/**
	 * show individual publication page
	 */
	function show($slug) {
		$publication = Publication::where('slug', $slug)->first();
		
		//404
		if (!$publication) return Redirect::action('PublicationController@index');

		return View::make('publications.publication', [
			'title' => strip_tags($publication->title),
			'types' => PublicationType::orderBy('title')->get(),
			'publication' => $publication,
			'related' => Publication::where('id', '<>', $publication->id)->orderBy('publish_date', 'desc')->take(5)->get(),
		]);
	}

	/**
	 * Get a URL to the show() method
	 */
	public static function url(Publication $publication) {
		return URL::action('PublicationController@show', $publication->slug);
	}

	/**
	 * ajax
	 */
	function ajax() {

		# Construct chained Eloquent statement based on input
		$publications = Publication::orderBy('publish_date', 'desc');

		if (Request::has('search')) {
			$publications
				->where('title', 'like', '%' . Request::input('search') . '%')
				->orWhere('description', 'like', '%' . Request::input('search') . '%');
		}
		
		if (Request::has('year')) {
			$publications->where(DB::raw('YEAR(publish_date)'), Request::input('year'));
		}

		if (Request::has('type_id')) {
			$publications->where('type_id', Request::input('type_id'));
		}

		$publications = $publications->get();

		# Set publication URLs
		foreach ($publications as $publication) {
			$publication->url = self::url($publication);
		}

		# Return HTML view
		return View::make('publications.publications', array('publications'=>$publications));
	}

}