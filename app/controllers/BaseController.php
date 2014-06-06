<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * highlight search results
	 */
	public static function highlightResults($results, $keys)
	{

		if (!Input::has('search')) return $results;

		foreach ($results as &$result) {
			foreach ($keys as $key) {
				$result->{$key} = preg_replace(
					'/(?<=^|[> ])(' . Input::get('search') . ')(?=$|[^a-z])/is', 
					'<mark>\\0</mark>', 
					$result->{$key});
			}
		}

		return $results;
	}

	/**
	 * generate avalon link
	 */
	public static function editLink($instance) {
		if (!Auth::user()) return false;
		return link_to(URL::action('InstanceController@edit', array($instance->object_id, $instance->id)) . '?return_to=' . urlencode(Url::current()), '', array('class'=>'edit dashicons dashicons-welcome-write-blog'));
	}

}
