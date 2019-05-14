<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncashmentSummaryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('encashment_summary', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('group_id');
			$table->integer('user_id');
			$table->char('particular');
			$table->integer('gross_income');
			$table->integer('admin_fee');
			$table->integer('cd_account_fee');
			$table->integer('net_income');
			$table->integer('amount_withdrawn');
			$table->integer('adjustment');
			$table->integer('balance');
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
		Schema::drop('encashment_summary');
	}

}
