<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpToLevelToPointsValueEquivalent extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_points_equivalents', function (Blueprint $table) {
			//
			$table->integer('up_to_level')->default(0)->nullable(false)->after('points_equivalent');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_points_equivalents', function (Blueprint $table) {
			//
			$table->dropColumn('up_to_level');
		});
	}

}
