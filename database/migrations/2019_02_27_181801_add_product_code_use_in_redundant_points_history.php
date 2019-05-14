<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductCodeUseInRedundantPointsHistory extends Migration
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
            $table->string('product_code_use')->nullable(true)->after('amount')
                ->comment('the product code that is use');
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
            $table->dropForeign(['product_code_use']);
            $table->dropColumn('product_code_use');
        });
    }
}
