<?php namespace App\Http\Controllers;

use DB;	
use LeftRight\Center\Models\User;

class CenterController extends Controller {

	public static function groupUsers($rows) {
		$admins = array_unique(DB::table('permissions')->lists('user_id'));
		return $rows->addSelect(DB::raw('CASE WHEN id IN (' . implode(', ', $admins) . ') THEN "Admins" ELSE "No Permissions" END as `group`'))->orderBy('group');
	}

}
