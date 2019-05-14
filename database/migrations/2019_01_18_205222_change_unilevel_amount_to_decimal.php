<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUnilevelAmountToDecimal extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_incentive', function (Blueprint $table) {
			//
			$table->decimal('amount', 10, 2)->default(0)->nullable(false)->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_incentive', function (Blueprint $table) {
			//
			$table->integer('amount');
		});
	}

}
