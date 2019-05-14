<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonToWeeklyPayoutTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('weekly_payout', function (Blueprint $table) {
			//
			$table->string('reason')->default('')->after('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('weeklypayout', function (Blueprint $table) {
			//
			$table->dropColumn('reason');
		});
	}

}
