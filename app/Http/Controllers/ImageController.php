<?php namespace App\Http\Controllers;

class ImageController {

	private static $items = [];

	public static function wallpaper($slug='default') {

		//base directory for this type of image
		$directory = '/assets/img/wallpapers/' . $slug;

		//load and cache files if it hasn't been done already
		if (empty(self::$items[$slug])) {
			self::$items[$slug] = array_slice(scandir(public_path() . $directory), 2);
		}

		//return a random image and remove
		shuffle(self::$items[$slug]);
		return $directory . '/' . array_pop(self::$items[$slug]);

	}
}