<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Facade;

class CreatePurchaseCodesBoughtsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_codes_boughts', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('purchase_id')->nullable(false)->index()->foreign()->references('id')->on('purchases')->onDelete('cascade');
			$table->integer('product_id')->nullable()->index()->foreign()->references('id')->on('products')->onDelete('set null');
			$table->string('product_code')->nullable()->index()->foreign()->references('code')->on('product_purchase_codes')->onDelete('set null');

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
		Schema::drop('purchase_codes_boughts');
	}

}
