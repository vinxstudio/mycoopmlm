<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailTemplates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Schema::create('email_templates', function($table){
  //           $table->increments('id');
  //           $table->enum('type', [REGISTRATION_KEY, LOGIN_KEY, WITHDRAWAL_KEY])->default(REGISTRATION_KEY);
  //           $table->text('content')->nullable();
  //           $table->dateTime('created_at');
  //           $table->dateTime('updated_at')->nullable();
  //       });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
