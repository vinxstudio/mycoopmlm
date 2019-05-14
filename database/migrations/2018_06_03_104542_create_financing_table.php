<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('financing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requester_id');

			$table->dateTime('application_date');
			$table->double('application_amount');
			$table->integer('type');
			$table->string('loan_type_others');
			$table->string('purpose');
			$table->string('loan_term');
			$table->integer('repayments');
			$table->string('payment_mode');
			$table->integer('class');
			$table->string('last_name');
			$table->string('first_name');
			$table->string('middle_name');
			$table->string('present_address');
			$table->string('present_address_no_stay');
			$table->string('present_address_contact');
			$table->string('provincial_address')->nullable();
			$table->string('provincial_address_contact')->nullable();
			$table->string('civil_status')->default('Single');
			$table->string('sex')->default('Female');
			$table->integer('no_of_dependents')->default(0);
			$table->integer('no_in_elementary')->default(0);
			$table->integer('no_in_highschool')->default(0);
			$table->integer('no_in_college')->default(0);
			$table->string('employer_name');
			$table->string('position');
			$table->string('employer_address');
			$table->string('employer_contact');
			$table->double('salary');
			$table->string('employment_status');
			$table->integer('no_of_yrs_company');
			$table->string('fathers_name');
			$table->string('fathers_address');
			$table->string('fathers_contact');
			$table->string('mothers_name');
			$table->string('mothers_address');
			$table->string('mothers_contact');
			$table->string('business_nature');
			$table->double('monthly_income');
			$table->string('business_address')->nullable();
			$table->double('yrs_in_business')->nullable();
			$table->string('spouse_name')->nullable();
			$table->string('spouse_employer')->nullable();
			$table->string('spouse_employer_contact')->nullable();

           	$table->timestamps();
            $table->softDeletes();
            $table->foreign('requester_id')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('financing');
	}

}
