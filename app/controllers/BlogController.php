<?php

class BlogController extends BaseController {

	/**
	 * show blog home page
	 */
	function index() {
		
		# Set URLs
		$posts = Post::orderBy('publish_date', 'desc')->take(10)->get();
		foreach ($posts as $post) {
			$post->url = self::url($post);
		}

		return View::make('blog.index', array(
			'title'=>'Blog',
			'years'=>Post::orderBy('publish_date', 'desc')->select(DB::raw('YEAR(publish_date) AS publish_date'))->distinct()->lists('publish_date', 'publish_date'),
			'posts'=>$posts,
			'tags'=>Tag::orderBy('title')->get(),
		));
	}

	/**
	 * show blog post
	 */
	function show($slug) {
		$post = Post::where('slug', $slug)->first();

		//404
		if (!$post) return Redirect::action('BlogController@index');

		return View::make('blog.post', array(
			'title'=>strip_tags($post->title),
			'post'=>$post,
			'related'=>Post::where('id', '<>', $post->id)->orderBy('publish_date', 'desc')->take(5)->get(),
			'tags'=>Tag::orderBy('title')->get(),
		));
	}

	/**
	 * Get a URL to the show() method
	 */
	public static function url(Post $post) {
		return URL::action('BlogController@show', $post->slug);
	}

	/**
	 * ajax
	 */
	function ajax() {

		# Construct chained Eloquent statement based on input
		$posts = Post::orderBy('publish_date', 'desc');

		if (Input::has('search')) {
			$posts
				->where('title', 'like', '%' . Input::get('search') . '%')
				->orWhere('excerpt', 'like', '%' . Input::get('search') . '%')
				->orWhere('content', 'like', '%' . Input::get('search') . '%');
		}
		
		if (Input::has('year')) {
			$posts->where(DB::raw('YEAR(publish_date)'), Input::get('year'));
		}

		if (Input::has('tags')) {
		    $posts->whereHas('tags', function($query) {
				$query->whereIn('id', Input::get('tags'));
			});
		}

		$posts = $posts->take(10)->get();

		# Highlight search terms
		$posts = BaseController::highlightResults($posts, array('title', 'excerpt'));

		# Set URLs
		foreach ($posts as $post) {
			$post->url = self::url($post);
		}

		# Return HTML view
		return View::make('blog.posts', array('posts'=>$posts));
	}

}