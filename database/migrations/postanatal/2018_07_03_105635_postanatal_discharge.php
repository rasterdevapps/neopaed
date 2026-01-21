<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PostanatalDischarge extends Migration 
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('postnatal_discharge', function(Blueprint $table)
		{
			$table->bigIncrements('posdisid', true);
			$table->integer('BabyId')->nullable();
			$table->integer('MotherId')->nullable();
			$table->integer('AdmissionId')->nullable();
			$table->text('BMrNo')->nullable();
                  $table->text('discharge_status')->nullable();
                  $table->date('discharge_date')->nullable();
                  $table->integer('discharge_wt')->nullable();
                  $table->integer('discharge_dol')->nullable();
                  $table->decimal('discharge_ofc', 3, 2)->nullable();
                  $table->decimal('discharge_length', 3, 2)->nullable();
                  $table->text('discharge_immunization')->nullable();
                  $table->text('schedule')->nullable();
                  $table->jsonb('vaccine')->nullable();
                  $table->jsonb('cgd')->nullable();
                  $table->text('discharge_eyes')->nullable();
                  $table->text('discharge_femorals')->nullable();
                  $table->text('discharge_hips')->nullable();
                  $table->decimal('postductal_spo2', 2, 1)->nullable();
                  $table->text('discharge_gentila')->nullable();
                  $table->text('discharge_cardiac_murmur')->nullable();
                  $table->text('discharge_malinformation')->nullable();
                  $table->text('malinformation_details')->nullable();
                  $table->text('feeding_at_discharge')->nullable();
                  $table->text('neourological_status')->nullable();
                  $table->boolean('appoinment_status')->nullable();
                  $table->date('appoinment_date')->nullable();
                  $table->integer('appoinment_hrs')->nullable();
                  $table->integer('appoinment_min')->nullable();
                  $table->text('appoinment_session')->nullable();
                  $table->decimal('discharge_hb', 2, 1)->nullable();
                  $table->decimal('discharge_pcv', 2, 1)->nullable();
                  $table->text('discharge_dct')->nullable();
                  $table->decimal('discharge_tsb', 2, 1)->nullable();
                  $table->decimal('direct_bilirubin', 2, 2)->nullable();
                  $table->decimal('dischargeserum_ca', 2,1)->nullable();
                  $table->decimal('dischargeserum_po4', 2, 1)->nullable();
                  $table->integer('dischargeserum_alp')->nullable();
                  $table->integer('dischargeserum_na')->nullable();
                  $table->text('discharge_home_oxygen')->nullable();
                  $table->text('discharge_cuss')->nullable();
                  $table->text('discharge_new_born')->nullable();
                  $table->text('discharge_hearing_screen')->nullable();
                  $table->text('oae_left')->nullable();
                  $table->text('oae_right')->nullable();
                  $table->text('abr_left')->nullable();
                  $table->text('abr_right')->nullable();
                  $table->text('rop_screening_status')->nullable();
                  $table->text('left_rop_left')->nullable();
                  $table->text('left_rop_right')->nullable();
                  $table->text('rop_treatment')->nullable();
                  $table->jsonb('typeoftreatment_left')->nullable();
                  $table->jsonb('typeoftreatment_right')->nullable();
                  $table->text('rop_follow_up')->nullable();
                  $table->text('cranial_ultrasound')->nullable();
                  $table->text('echocardiography')->nullable();
                  $table->text('additional_information')->nullable();
                  $table->text('advice')->nullable();
                  $table->text('plan_follow_up')->nullable();
			$table->dateTime('DateAdded')->nullable();
			$table->dateTime('DateModified')->nullable();
			$table->integer('UserDeleted')->nullable()->default(0);
			$table->integer('UserModified')->nullable()->default(0);
			$table->integer('UserAdded')->nullable()->default(0);
			$table->integer('IsDeleted')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('postnatal_discharge');
	}

}
