<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PurchaseCodesNewField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Schema::table('product_purchase_codes', function($table){
  //           $table->integer('owner_id')->default(0)->after('status');
  //           $table->integer('purchase_value')->default(0)->after('owner_id');
  //       });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
