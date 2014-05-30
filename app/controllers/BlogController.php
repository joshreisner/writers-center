<?php

class BlogController extends BaseController {

	/**
	 * show blog home page
	 */
	function index() {
		return View::make('blog.index', array(
			'title'=>'Blog',
			'years'=>Post::orderBy('publish_date', 'desc')->distinct()->lists(DB::raw('YEAR(publish_date)'), DB::raw('YEAR(publish_date)')),
			'posts'=>Post::orderBy('publish_date', 'desc')->take(10)->get(),
			'tags'=>Tag::orderBy('title')->get(),
			'class'=>'blog',
		));
	}

	/**
	 * show blog post
	 */
	function show($slug) {
		$post = Post::where('slug', $slug)->first();
		return View::make('blog.post', array(
			'title'=>$post->title,
			'post'=>$post,
			'related'=>Post::where('id', '<>', $post->id)->orderBy('publish_date', 'desc')->take(5)->get(),
			'tags'=>Tag::orderBy('title')->get(),
			'class'=>'blog',
		));
	}

	/**
	 * ajax
	 */
	function ajax() {
		$posts = Post::orderBy('publish_date', 'desc');

		if (Input::has('search')) {
			$posts
				->where('title', 'like', '%' . Input::get('search') . '%')
				->orWhere('content', 'like', '%' . Input::get('search') . '%');
		}
		
		if (Input::has('year')) $posts->where(DB::raw('YEAR(publish_date)'), Input::get('year'));

		return View::make('blog.posts', array('posts'=>$posts->take(10)->get()));
	}

	/**
	 * generate avalon link
	 */
	public static function editLink(Post $post) {
		if (!Auth::user()) return false;
		return link_to(URL::action('InstanceController@edit', array(2, $post->id)) . '?return_to=' . urlencode(Url::current()), '', array('class'=>'edit dashicons dashicons-welcome-write-blog'));
	}

}