<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountRedudantPointsHistoriesTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('account_redudant_points_histories', function (Blueprint $table) {

            $table->integer('account_redundant_points_id')->nullable(false)->foreign()->references('id')->on('account_redundant_points')->onDelete('set null')
                ->comment('foreign key for the redudandant points id');

            $table->enum('type', ['add_points', 'deduct_points'])->default('add_points')
                ->comment('add or deduct a points to the redundant points');

            $table->enum('points_node', ['left', 'right', 'both'])->default('left')
                ->comment('where the points is stored either left, right, or both');

            $table->integer('amount')->unsigned()->default(0)
                ->comment('amount of the points stored or deducted');

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
        Schema::drop('account_redudant_points_histories');
    }
}
