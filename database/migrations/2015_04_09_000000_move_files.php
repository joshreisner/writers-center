<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveFiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('files');
		Schema::rename('avalon_files', 'files');
		Schema::table('files', function(Blueprint $table)
		{
			$table->string('table');
			$table->string('field');
		});
		
		DB::table('files')
			->join('avalon_fields', 'files.field_id', '=', 'avalon_fields.id')
			->join('avalon_objects', 'avalon_fields.object_id', '=', 'avalon_objects.id')
			->update([
				'table' => DB::raw('avalon_objects.name'),
				'field' => DB::raw('avalon_fields.name'),
			]);
			
		DB::table('files')
			->update([
				'url'   => DB::raw('REPLACE(files.url, \'/packages/joshreisner/avalon/files\', \'/vendor/center/files\')'),
			]);

		Schema::table('files', function(Blueprint $table)
		{
			$table->renameColumn('instance_id', 'row_id');
			$table->dropColumn('field_id');
			$table->dropColumn('host');
			$table->dropColumn('path');
			$table->dropColumn('name');
			$table->dropColumn('extension');
			$table->dropColumn('writable');
			$table->renameColumn('updated_at', 'created_at');
			$table->renameColumn('updated_by', 'created_by');
		});

		//drop unnecessary tables
		Schema::dropIfExists('avalon_fields');
		Schema::dropIfExists('avalon_object_links');
		Schema::dropIfExists('avalon_object_user');
		Schema::dropIfExists('avalon_objects');

		Schema::table('transactions', function($table){
			$table->renameColumn('type', 'type_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}
