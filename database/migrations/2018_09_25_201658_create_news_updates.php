<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsUpdates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    	Schema::create('news_update', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->char('news_title');
            $table->string('news_details','15000');
            $table->date('display_date');
            $table->char('news_from');
            $table->string('news_img','1500');
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
	    Schema::drop('news_update');
	}

}
