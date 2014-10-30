<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table){
			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->string('phone')->nullable();
			$table->string('state', 2)->nullable();
			$table->string('zip', 5)->nullable();
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table){
			$table->dropColumn('address');
			$table->dropColumn('city');
			$table->dropColumn('phone');
			$table->dropColumn('state');
			$table->dropColumn('zip');
		});
	}

}
