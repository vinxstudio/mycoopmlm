<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeneratedByToProductPurchaseCodes extends Migration
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
			$table->integer('generated_by')->nullable()->after('id')->index()->foreign()->references('id')->on('users')->onDelete('set null');
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
			$table->dropForeign(['generated_by']);
			$table->dropColumn('generated_by');

		});
	}

}
