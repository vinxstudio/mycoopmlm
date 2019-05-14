<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('announcement', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->char('announcement_title');
			$table->string('announcement_details','15000');
			$table->date('display_date');
			$table->char('announcement_from');
			$table->integer('status');
			$table->integer('delete');
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
		Schema::drop('announcement');
	}

}
