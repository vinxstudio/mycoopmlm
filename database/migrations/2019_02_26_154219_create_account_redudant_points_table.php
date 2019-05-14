<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountRedudantPointsTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('account_redudant_points', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('account_id')->nullable(false)->foreign()->references('id')->on('accounts')->onDelete('set null')
                ->comment('foreign key for the account table');

            $table->integer('left_points_value')->default(0)->unsigned()
                ->comment('left points value of the account');

            $table->integer('right_points_value')->default(0)->unsigned()
                ->comment('right points value of the account');

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
        Schema::drop('account_redudant_points');
    }
}
