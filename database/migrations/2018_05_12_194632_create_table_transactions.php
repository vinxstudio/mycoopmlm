<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requester_id');
            $table->integer('account_id');
            $table->unsignedInteger('details_id')->nullable();
            $table->string('details_type')->nullable();
            $table->integer('approver_id')->nullable();
            $table->double('amount')->default(0.00);
            $table->double('cost')->default(0.00);
            $table->tinyInteger('status')->default('1')->index();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();

            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('approver_id')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transactions');
	}

}
