<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSRPAndMEMBERSPRICEToProductPurchaseTable extends Migration
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
			$table->enum('product_type', ['SRP', 'Members Price'])->comment('{SRP} or {Members Price} of the product')->after('product_id')->default('SRP');
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
			$table->dropColumn('product_type');
		});
	}

}
