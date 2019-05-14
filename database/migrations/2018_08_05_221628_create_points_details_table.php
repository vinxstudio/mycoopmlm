<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('points_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_account_id');
			$table->integer('downline_account_id');
			$table->char('node', 25);
			$table->integer('left_points_value');
			$table->integer('right_points_value');
			$table->integer('flushout_points');
			$table->integer('retention_points');
			$table->char('paired_account', 100);
			$table->char('reason_for_flushout', 100);
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
		Schema::drop('points_details');
	}

}
