<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPointsEquivalentsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_points_equivalents', function (Blueprint $table) {
			$table->increments('id');
			$table->string('settings');
			$table->integer('points_value')->default(0)->nullable(false);
			$table->integer('points_equivalent')->default(0)->nullable(false);
			$table->timestamps();
		});

		DB::table('product_points_equivalents')->insert(
			array(
				'settings' => 'Redundant Binary Settings'
			)
		);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_points_equivalents');
	}

}
