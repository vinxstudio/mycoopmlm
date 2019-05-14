<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function (Blueprint $table) {
                  $table->string('global_pool')->nullable()->change();
                  $table->string('slug');
                  $table->double('points_value')->default('0.00');
                  $table->text('description');
                  $table->string('image');
                  $table->tinyInteger('publish')->default('0')->index();
                  $table->tinyInteger('type')->default('0')->index();
                  $table->tinyInteger('category')->default('0')->index();
            });
	}

      public function down()
      {

      }

}
