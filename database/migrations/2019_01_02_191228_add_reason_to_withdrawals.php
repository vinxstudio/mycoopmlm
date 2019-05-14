<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonToWithdrawals extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('withdrawals', function (Blueprint $table) {
			//
			$table->string('reason')->nullable()->after('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('withdrawals', function (Blueprint $table) {
			//
			$table->dropColumn('reason');
		});
	}

}
