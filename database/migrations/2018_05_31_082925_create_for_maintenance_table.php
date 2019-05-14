<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForMaintenanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('for_maintenance', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('teller_id');
            $table->integer('account_id');
            $table->integer('cbu');
            $table->integer('my_c');
            $table->string('or');
            $table->string('payors_name');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('for_maintenance');
	}

}
