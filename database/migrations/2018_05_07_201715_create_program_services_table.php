<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('slug', 255)->index();
            $table->string('image_banner_path', 255)->nullable();
            $table->string('image_icon_path', 255)->nullable();
            $table->string('form_path', 255)->nullable();
            $table->dateTime('publish_date');
            $table->tinyInteger('publish_status')->default(0)->index();
            $table->tinyInteger('type')->default(0)->index();
            $table->tinyInteger('order')->default(0);
            $table->string('cost', 255)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('program_services');
	}

}
