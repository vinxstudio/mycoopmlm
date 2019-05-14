<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchToProductPurchaseCodesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('product_purchase_codes', function (Blueprint $table) {
			//
			$table->integer('branch_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('product_purchase_codes', function (Blueprint $table) {
			//
			$table->dropColumn('branch_id');
		});
	}

}
