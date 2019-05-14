<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('points_value', function(Blueprint $table)
		{
			$table->increments('id');
			$table->tinyInteger('account_id');
			$table->bigInteger('left_points_value');
			$table->bigInteger('right_points_value');
			$table->string('strong_leg');
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
		Schema::drop('points_value');
	}

}
