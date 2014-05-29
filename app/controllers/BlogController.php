<?php

class BlogController extends BaseController {

	/**
	 * show blog home page
	 */
	function index() {
		return View::make('blog.index', array(
			'title'=>'Blog',
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
			'posts'=>Post::orderBy('publish_date', 'desc')->get(),
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
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
			'post'=>$post,
			'tags'=>Tag::orderBy('title')->get(),
			'class'=>'blog',
		));
	}

	/**
	 * generate avalon link
	 */
	public static function editLink(Post $post) {
		if (!Auth::user()) return false;
		return link_to(URL::action('InstanceController@edit', array(2, $post->id)) . '?return_to=' . urlencode(Url::current()), '', array('class'=>'edit dashicons dashicons-welcome-write-blog'));
	}

}