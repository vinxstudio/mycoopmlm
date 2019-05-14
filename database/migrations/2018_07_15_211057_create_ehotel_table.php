<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEhotelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ehotel', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('requester_id');
			$table->string('destination', 255);
            $table->dateTime('checkin');
            $table->dateTime('checkout');
            $table->integer('guest')->default(0);
            $table->integer('room')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->softDeletes();

            $table->foreign('requester_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ehotel');
	}

}
