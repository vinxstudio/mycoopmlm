<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUserDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_details', function(Blueprint $table)
		{
			$table->char('present_region', 250)->nullable($value = true)->after('present_province');
			$table->char('provincial_region', 250)->nullable($value = true)->after('provincial_province');
			$table->char('present_address_details', 250)->nullable($value = true)->after('present_street');
			$table->char('provincial_address_details', 250)->nullable($value = true)->after('provincial_city');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_details', function(Blueprint $table)
		{
			 $table->dropColumn(['present_region', 'provincial_region', 'present_address_details', 'provincial_address_details']);
		});
	}

}
