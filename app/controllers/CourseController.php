<?php

class CourseController extends BaseController {

	/**
	 * show the course home page
	 */
	public function index() {

		return View::make('courses.index', array(
			'title'				=>'Courses',
			'genres'			=>self::searchCoursesByGenre(),
			'genre_select'		=>self::getGenreList(),
			'instructor_select'	=>self::getInstructorList(),
			'duration_select'	=>self::getDurationList(),
			'day_select'		=>self::getDayList(),
			'class'				=>'courses',
			'years'				=>array(2014=>2014),
		));		
	}

	/**
	 * show a single course
	 */
	public function show($slug) {
		$course = Course::with(array('instructors', 'sections'=>function($query){
			$query->where('start', '>', new DateTime());
			$query->orderBy('start', 'desc');
		}))->where('slug', $slug)->first();
		
		//404
		if (!$course) return Redirect::action('CourseController@index');

		//also get a related course
		$related = Course::where('genre_id', $course->genre_id)
				->where('id', '<>', $course->id)
				->whereHas('sections', function($query){
					$query->where('start', '>', new DateTime());
					$query->orWhere(function($query){
						$query->whereNotNull('id');
						$query->whereNull('start');
					});
				})
				->orderBy(DB::raw('RAND()'))
				->first();

		return View::make('courses.course', array(
			'title'=>$course->title,
			'course'=>$course,
			'class'=>'courses',
			'related'=>$related,
		));
	}

	/**
	 * Get a URL to the show() method
	 */
	public static function url(Course $course) {
		return URL::action('CourseController@show', $course->slug);
	}

	/**
	 * provide json for the AJAX switchboard
	 */
	public function ajax() {

		# Return
		return View::make('courses.genres', array('genres'=>self::searchCoursesByGenre()));
	}

	/**
	 * generic select for index() and ajax()
	 */
	private static function searchCoursesByGenre() {

		$genres = Genre::with(array(
			'courses'=>function($query){
				if (Input::has('day')) {
					$query->whereHas('sections', function($query){
						$query->where('day_id', Input::get('day'));
					});
				}

				if (Input::has('duration')) {
					$query->whereHas('sections', function($query) {
						if (Input::get('duration') == 'intensive') {
						    $query->where('classes', 1);
						} else {
						    $query->where('classes', '>', 1);
						}
					});
				}

				if (Input::has('instructor')) {
					$query->whereHas('instructors', function($query) {
					    $query->where('id', Input::get('instructor'));
					});
				}

				if (Input::has('search')) {
					$query->where('title', 'like', '%' . Input::get('search') . '%');
				}

				if (Input::has('year')) {
					$query->whereHas('sections', function($query){
						$query->where(DB::raw('YEAR(start)'), '=', Input::get('year'));
					});
				} else {
					$query->whereHas('sections', function($query){
						$query->where('start', '>', new DateTime());
					})->orWhere('tutorial_available', 1);
				}
			}, 
			'courses.instructors'=>function($query){

			})
		);

		if (Input::has('genre')) {
			$genres->where('id', Input::get('genre'));
		}
		$genres->whereHas('courses', function($query){
				if (Input::has('day')) {
					$query->whereHas('sections', function($query){
						$query->where('day_id', Input::get('day'));
					});
				}

				if (Input::has('duration')) {
					$query->whereHas('sections', function($query) {
						if (Input::get('duration') == 'intensive') {
						    $query->where('classes', 1);
						} else {
						    $query->where('classes', '>', 1);
						}
					});
				}

				if (Input::has('instructor')) {
					$query->whereHas('instructors', function($query) {
					    $query->where('id', Input::get('instructor'));
					});
				}

				if (Input::has('search')) {
					$query->where('title', 'like', '%' . Input::get('search') . '%');
				}

				if (Input::has('year')) {
					$query->whereHas('sections', function($query){
						$query->where(DB::raw('YEAR(start)'), '=', Input::get('year'));
					});
				} else {
					$query->whereHas('sections', function($query){
						$query->where('start', '>', new DateTime());
					})->orWhere('tutorial_available', 1);
				}
			
		});

		$genres = $genres->orderBy('precedence')->get();

		foreach ($genres as &$genre) {
			if (count($genre->courses)) {
				$genre->courses = BaseController::highlightResults($genre->courses, array('title'));

				foreach ($genre->courses as $course) {
					$course->url = self::url($course);
				}			
			} else {
				unset($genre);
			}
		}

		//dd(DB::getQueryLog());

		return $genres;
	}

	/**
	 * populate instructor select on course.index or home
	 */
	public static function getInstructorList() {
		return Instructor::orderBy('name')->lists('name', 'id');
	}

	/**
	 * populate genre select on course.index or home
	 */
	public static function getGenreList() {
		return Genre::orderBy('precedence')->lists('title', 'id');
	}

	/**
	 * populate day select on course.index or home
	 */
	public static function getDayList() {
		return Day::orderBy('precedence')->lists('title', 'id');
	}

	/**
	 * populate duration select on course.index or home
	 */
	public static function getDurationList() {
		return array('intensive'=>'1-day Intensive', 'course'=>'Multi-week Course');
	}

	/**
	 * format a serial string of instructors
	 */
	public static function formatInstructors(Course $course) {

		//make a flat array of instructors (ok if empty)
		$instructors = array();
		foreach ($course->instructors as $instructor) {
			$instructors[] = $instructor->name;
		}

		//return string
		if (count($instructors) > 2) {
			$last = array_pop($instructors);
			return implode(', ', $instructors) . ' and ' . $last;
		} else {
			return implode(' and ', $instructors);					
		}
	}

}