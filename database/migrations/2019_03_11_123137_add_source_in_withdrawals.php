<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourceInWithdrawals extends Migration
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
			$table->enum('source', ['earnings_income', 'redundat_binary_income'])->default('earnings_income')->after('status')
				->comment('where the withdrawals comes from, total available balance or from redundant binary');
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
			$table->removeColumn('source');
		});
	}
}
