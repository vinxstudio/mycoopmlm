<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWithdrawalsSummary extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('withdrawals_summary', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('withdrawals_id');
			$table->integer('weekly_payout_id');
			$table->float('amount_deducted', 8, 2);
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
		Schema::drop('withdrawasl_summary');
	}

}
