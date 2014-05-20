<?php

class CourseController extends BaseController {

	/**
	 * show the course home page
	 */
	public function index() {
		return View::make('courses.index', array(
			'title'=>'Courses',
			'genres'=>Genre::with('courses', 'courses.instructors')->get(),
			'days'=>Day::get(),
		));		
	}

	/**
	 * show a single course
	 */
	public function show($slug) {
		$course = Course::with('instructors')->where('slug', $slug)->first();
		return View::make('courses.course', array(
			'title'=>$course->title,
			'genres'=>Genre::with('courses')->get(),
			'days'=>Day::get(),
			'course'=>$course,
		));
	}

	/**
	 * format a ordinal(?) list of instructors
	 */
	public static function formatInstructors(Course $course) {
		$instructors = array();
		foreach ($course->instructors as $instructor) {
			$instructors[] = $instructor->name;
		}
		if (count($instructors) > 2) {
			$last = array_pop($instructors);
			$instructors = implode(', ', $instructors) . ' and ' . $last;
		} else {
			$instructors = implode(' and ', $instructors);					
		}
		return $instructors;
	}


}