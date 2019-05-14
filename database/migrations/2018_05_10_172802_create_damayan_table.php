<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDamayanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('damayan', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('requester_id');
			$table->string('last_name', 255);
            $table->string('first_name', 255);
            $table->string('middle_name', 255);
            $table->dateTime('birthdate');
            $table->double('cost');
            $table->string('address', 255);
            $table->string('beneficiary', 255);
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
		Schema::drop('damayan');
	}

}
