<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPuchaserAccountId extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::table('account_redudant_points_histories', function (Blueprint $table) {
            //
            $table->integer('purchase_account_id')->after('product_code_use')->nullable(false)->foreign()->references('id')->on('accounts')
                ->comment('The account_id of the one who purchase this product code');
        });
    }

    /**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
    public function down()
    {
        Schema::table('account_redudant_points_histories', function (Blueprint $table) {
            //
            $table->dropForeign(['purchase_account_id']);
            $table->dropColumn('purchase_account_id');
        });
    }
}
