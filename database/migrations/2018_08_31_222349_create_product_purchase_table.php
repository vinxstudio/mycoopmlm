<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPurchaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_purchase', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('teller_id');
			$table->integer('account_id');
			$table->char('or');
			$table->char('payors_name');
			$table->char('receipt');
			$table->char('type');
			$table->integer('quantity');
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
		Schema::drop('product_purchase');
	}

}
