<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionIncentiveTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('product_incentive', function(Blueprint $table)
	    {
	        $table->increments('id');
	        $table->integer('account_id');
	        $table->integer('sponsor_id');
	        $table->integer('product_purchase_id');
	        $table->char('product_purchase_via');
	        $table->integer('level');
	        $table->integer('amount');
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
	    Schema::drop('product_incentive');
	}

}
