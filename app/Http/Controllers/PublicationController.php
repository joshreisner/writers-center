<?php namespace App\Http\Controllers;

use DB;
use Input;
use LeftRight\Center\Models\Publication;
use LeftRight\Center\Models\PublicationType;

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

		return view('publications.index', compact('title', 'publications', 'years', 'types'));		
	}

	/**
	 * show individual publication page
	 */
	function show($slug) {
		$publication = Publication::where('slug', $slug)->first();
		
		//404
		if (!$publication) return redirect()->action('PublicationController@index');

		return view('publications.publication', [
			'title' => strip_tags($publication->title),
			'type' => 'books.book',
			'types' => PublicationType::orderBy('title')->get(),
			'publication' => $publication,
			'related' => Publication::where('id', '<>', $publication->id)->orderBy('publish_date', 'desc')->take(5)->get(),
		]);
	}

	/**
	 * Get a URL to the show() method
	 */
	public static function url(Publication $publication) {
		return action('PublicationController@show', $publication->slug);
	}

	/**
	 * ajax
	 */
	function ajax() {

		# Construct chained Eloquent statement based on input
		$publications = Publication::orderBy('publish_date', 'desc');

		if (Input::has('search')) {
			$publications
				->where('title', 'like', '%' . Input::get('search') . '%')
				->orWhere('description', 'like', '%' . Input::get('search') . '%');
		}
		
		if (Input::has('year')) {
			$publications->where(DB::raw('YEAR(publish_date)'), Input::get('year'));
		}

		if (Input::has('type_id')) {
			$publications->where('type_id', Input::get('type_id'));
		}

		$publications = $publications->get();

		# Set publication URLs
		foreach ($publications as $publication) {
			$publication->url = self::url($publication);
		}

		# Return HTML view
		return view('publications.publications', array('publications'=>$publications));
	}

}