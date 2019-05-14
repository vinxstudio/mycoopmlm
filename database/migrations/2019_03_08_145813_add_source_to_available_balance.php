<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourceToAvailableBalance extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('available_balance', function (Blueprint $table) {
			//
			$table->enum('source', ['available_balance', 'redundant_binary_income'])->after('available_balance')->default('available_balance')
				->comment('where the source is from, ex. Shared Capital, Redundant Binary');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('available_balance', function (Blueprint $table) {
			//
			$table->removeColumn('source');
		});
	}
}
