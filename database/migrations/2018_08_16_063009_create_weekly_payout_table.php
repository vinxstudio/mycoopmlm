<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyPayoutTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weekly_payout', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('group_id');
			$table->integer('direct_referral');
			$table->integer('matching_bonus');
			$table->integer('gift_check');
			$table->integer('gross_income');
			$table->integer('net_income');
			$table->char('status');
			$table->dateTime('date_from');
			$table->dateTime('date_to');
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
		Schema::drop('weekly_payout');
	}

}
