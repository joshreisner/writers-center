<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Billing extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table) {
			$table->string('customer_id')->nullable();
		});

		Schema::create('transactions', function($table)
		{
		    $table->increments('id');
		    $table->integer('user_id');
		    $table->integer('amount');
		    $table->string('charge_id');
		    $table->boolean('paid');
		    $table->string('confirmation', 6);
		    $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table) {
			$table->dropColumn('customer_id');
		});

		Schema::drop('transactions');
	}

}
