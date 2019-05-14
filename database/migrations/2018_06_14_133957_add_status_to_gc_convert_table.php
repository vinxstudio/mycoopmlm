<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToGcConvertTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gc_convert', function(Blueprint $table)
		{
			$table->char('status', 50)->default('pending')->after('converted_voucher_value');
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
			$table->dropColumn('status');
		});
	}

}
