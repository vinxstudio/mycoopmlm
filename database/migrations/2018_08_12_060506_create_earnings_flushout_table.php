<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarningsFlushoutTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('earnings_flushout', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id');
			$table->integer('user_id');
			$table->char('source', 50);
			$table->integer('amount');
			$table->integer('left_account_id');
			$table->integer('right_account_id');
			$table->dateTime('earned_date');
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
		Schema::drop('earnings_flushout');
	}

}
