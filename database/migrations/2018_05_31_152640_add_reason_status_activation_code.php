<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\DB;
use Illuminate\Database\Migrations\Migration;

class AddReasonStatusActivationCode extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activation_codes', function(Blueprint $table)
		{
			$table->text('reason')->after('transferred_to');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activation_codes', function($table) {
	        $table->dropColumn('reason');
	    });
	}

}
