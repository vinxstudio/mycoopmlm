<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBarcodeC93ToProductPurchaseCodes extends Migration
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
			$table->string("barcode_c93");
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
			$table->dropColumn("barcode_c93");
		});
	}

}
