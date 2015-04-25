<?php namespace App\Http\Controllers;

use DB;	
use LeftRight\Center\Models\User;

class CenterController extends Controller {

	public static function groupUsers($rows) {
		$admins = array_unique(DB::table('permissions')->lists('user_id'));
		return $rows->addSelect(DB::raw('CASE WHEN id IN (' . implode(', ', $admins) . ') THEN "Admins" ELSE "No Permissions" END as `group`'))->orderBy('group');
	}

	public static function groupPurchases($rows) {
		return $rows->addSelect(DB::raw('CASE WHEN shipped_date IS NULL THEN "Open Orders" ELSE "Closed Orders" END as `group`'))->orderBy('group');
	}

}
