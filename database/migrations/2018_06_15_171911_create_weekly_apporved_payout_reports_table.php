<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyApporvedPayoutReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weekly_approved_payout', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('approver_id');
			$table->integer('group_id');
			$table->integer('amount')->default(0);
			$table->string('status', 255)->nullable();
			$table->dateTime('date_from');
			$table->dateTime('date_to');
			$table->text('reason');
			$table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('weekly_approved_payout');
	}

}
