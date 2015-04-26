<?php namespace App\Http\Controllers;

use DB;
use LeftRight\Center\Models\Post;
use LeftRight\Center\Models\Tag;

class BlogController extends Controller {

	/**
	 * show blog home page
	 */
	function index() {
		
		# Set URLs
		$posts = Post::orderBy('publish_date', 'desc')->take(10)->get();
		foreach ($posts as $post) {
			$post->url = self::url($post);
		}
		
		$title = 'Blog';
		
		$years = Post::orderBy('publish_date', 'desc')->select(DB::raw('YEAR(publish_date) AS publish_date'))->distinct()->lists('publish_date', 'publish_date');

		$tags = Tag::orderBy('title')->get();
		
		return view('blog.index', compact('title', 'years', 'posts', 'tags'));
	}

	/**
	 * show blog post
	 */
	function show($slug) {
		$post = Post::where('slug', $slug)->first();

		//404
		if (!$post) return redirect()->action('BlogController@index');

		return view('blog.post', array(
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
		return action('BlogController@show', $post->slug);
	}

	/**
	 * ajax
	 */
	function ajax() {

		# Construct chained Eloquent statement based on input
		$posts = Post::orderBy('publish_date', 'desc');

		if (Request::has('search')) {
			$posts
				->where('title', 'like', '%' . Request::input('search') . '%')
				->orWhere('excerpt', 'like', '%' . Request::input('search') . '%')
				->orWhere('content', 'like', '%' . Request::input('search') . '%');
		}
		
		if (Request::has('year')) {
			$posts->where(DB::raw('YEAR(publish_date)'), Request::input('year'));
		}

		if (Request::has('tags')) {
		    $posts->whereHas('tags', function($query) {
				$query->whereIn('id', Request::input('tags'));
			});
		}

		$posts = $posts->take(10)->get();

		# Highlight search terms
		$posts = App\Http\Controllers\Controller::highlightResults($posts, array('title', 'excerpt'));

		# Set URLs
		foreach ($posts as $post) {
			$post->url = self::url($post);
		}

		# Return HTML view
		return view('blog.posts', array('posts'=>$posts));
	}

}