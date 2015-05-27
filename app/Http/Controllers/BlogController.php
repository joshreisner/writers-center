<?php namespace App\Http\Controllers;

use DB;
use Request;
use LeftRight\Center\Models\Post;
use LeftRight\Center\Models\Tag;

class BlogController extends Controller {

	/**
	 * show blog home page
	 */
	function index() {
		
		$limit = 10;
		
		# Set URLs
		$posts = Post::orderBy('publish_date', 'desc')->take($limit)->get();
		foreach ($posts as $post) {
			$post->url = self::url($post);
		}
		
		if (Post::count() >= $limit) $more = true;
		
		$title = 'Blog';
		
		$years = Post::orderBy('publish_date', 'desc')->select(DB::raw('YEAR(publish_date) AS publish_date'))->distinct()->lists('publish_date', 'publish_date');

		$tags = Tag::orderBy('title')->get();
		
		return view('blog.index', compact('title', 'years', 'posts', 'tags', 'more'));
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
			'type' => 'article',
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
				->where('title', 'like', '%' . Request::get('search') . '%')
				->orWhere('excerpt', 'like', '%' . Request::get('search') . '%')
				->orWhere('content', 'like', '%' . Request::get('search') . '%');
		}
		
		if (Request::has('year')) {
			$posts->where(DB::raw('YEAR(publish_date)'), Request::get('year'));
		}

		if (Request::has('tags')) {
		    $posts->whereHas('tags', function($query) {
				$query->whereIn('id', Request::get('tags'));
			});
		}
		
		$limit = Request::get('limit', 10);
		
		$more = ($limit <= $posts->count());

		$posts = $posts->take($limit)->get();

		# Highlight search terms
		$posts = self::highlightResults($posts, ['title', 'excerpt']);

		# Set URLs
		foreach ($posts as $post) {
			$post->url = self::url($post);
		}

		# Return HTML view
		return view('blog.posts', compact('posts', 'more'));
	}

}