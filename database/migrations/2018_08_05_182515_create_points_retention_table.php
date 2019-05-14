<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsRetentionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('points_retention', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id');
			$table->integer('user_id');
			$table->integer('left_account_id');
			$table->integer('right_account_id');
			$table->integer('remaining_left_points');
			$table->integer('remaining_right_points');
			$table->integer('points_generated');
			$table->char('strong_leg', 50);
			$table->integer('mb_amount');
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
		Schema::drop('points_retention');
	}

}
