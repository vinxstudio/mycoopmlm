<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConvertedVoucherValueToGcConvertedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gc_convert', function(Blueprint $table)
		{
			$table->integer('converted_voucher_value')->after('voucher_value');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gc_convert', function(Blueprint $table)
		{
			// $table->dropColumn('converted_voucher_value');
		});
	}

}
