<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtoursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('etours', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('requester_id');
			$table->string('destination', 255);
            $table->dateTime('checkin');
            $table->dateTime('checkout');
            $table->integer('adults')->default(0);
            $table->integer('kids')->default(0);
            $table->integer('infants')->default(0);
            $table->tinyInteger('type')->default(1);
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
		Schema::drop('etours');
	}

}
