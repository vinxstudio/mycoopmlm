<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValidatedByIdToGcConvertTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gc_convert', function(Blueprint $table)
		{
			$table->integer('validated_by_id')->after('reason');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gc_convert', function(Blueprint $table)
		{
			$table->dropColumn('validated_by_id');
		});
	}

}
