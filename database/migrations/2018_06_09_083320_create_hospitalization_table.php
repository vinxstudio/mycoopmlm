<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalizationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hospitalization', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('requester_id');

			$table->dateTime('application_date');
	        $table->string('mccrc_control_no');
	        $table->string('cooperative_name');
	        $table->string('cooperative_address');
	        $table->string('last_name');
	        $table->string('first_name');
	        $table->string('middle_name');
	        $table->string('present_address');
	        $table->string('present_address_zip_code');
	        $table->string('provincial_address');
	        $table->string('provincial_address_zip_code');
	        $table->string('civil_status');
	        $table->string('sex');
	        $table->string('contact_number');
	        $table->string('email_address');
	        $table->string('facebook_account');
	        $table->string('occupation');
	        $table->string('employer_name');
	        $table->string('yrs_in_company');
	        $table->dateTime('date_hired');
	        $table->string('employer_address');
	        $table->string('family_immediate_last_name_1');
	        $table->string('family_immediate_first_name_1');
	        $table->string('family_immediate_middle_name_1');
	        $table->string('family_immediate_relationship_1');
	        $table->string('family_immediate_birthdate_1');
	        $table->string('family_immediate_gender_1');
	        $table->string('family_immediate_civil_status_1');
	        $table->string('family_immediate_last_name_2');
	        $table->string('family_immediate_first_name_2');
	        $table->string('family_immediate_middle_name_2');
	        $table->string('family_immediate_relationship_2');
	        $table->string('family_immediate_birthdate_2');
	        $table->string('family_immediate_gender_2');
	        $table->string('family_immediate_civil_status_2');
	        $table->string('family_immediate_last_name_3');
	        $table->string('family_immediate_first_name_3');
	        $table->string('family_immediate_middle_name_3');
	        $table->string('family_immediate_relationship_3');
	        $table->string('family_immediate_birthdate_3');
	        $table->string('family_immediate_gender_3');
	        $table->string('family_immediate_civil_status_3');

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
		Schema::drop('hospitalization');
	}

}
