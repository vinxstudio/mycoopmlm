<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGcConvertTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gc_convert', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id');
			$table->integer('user_id');
			$table->integer('earnings_id');
			$table->integer('voucher_value');
			$table->enum('type',['CBU(Shared Capital)', 'Savings', 'Product Purchase']);
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
		Schema::drop('gc_convert');
	}

}
