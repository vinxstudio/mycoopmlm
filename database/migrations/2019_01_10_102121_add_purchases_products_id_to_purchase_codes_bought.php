<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchasesProductsIdToPurchaseCodesBought extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchase_codes_boughts', function (Blueprint $table) {
			//
			$table->removeColumn('product_id');
			$table->integer('purchases_products_id')->nullable()->after('purchase_id')->index()->foreign()->references('id')->on('purchases_products')->onDelete('SET NULL');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('purchase_codes_boughts', function (Blueprint $table) {
			//
			$table->integer('product_id')->nullable()->index()->foreign()->references('id')->on('products')->onDelete('SET NULL');
			$table->dropIndex(['purchases_products_id']);
			$table->dropColumn('purchases_products_id');
		});
	}

}
