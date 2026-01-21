<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PostanatalAdmission extends Migration 
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('postnatal_admission', function(Blueprint $table)
		{
			$table->bigIncrements('pid', true);
			$table->integer('BabyId')->nullable();
			$table->integer('MotherId')->nullable();
			$table->integer('AdmissionId')->nullable();
			$table->text('BMrNo')->nullable();
			$table->text('referredby')->nullable();
			$table->text('referralreason')->nullable();
			$table->jsonb('admission_cg')->nullable();
			$table->integer('admission_time_hour')->nullable();
                  $table->integer('admission_time_mins')->nullable();
                  $table->text('admission_time_session')->nullable();
                  $table->date('admission_date')->nullable();
                  $table->text('typeofcare')->nullable();
                  $table->text('ip_number')->nullable();
                  $table->integer('admission_wt')->nullable();
                  $table->integer('ageonadmissionindays')->nullable();
                  $table->integer('surgeon')->nullable();
                  $table->integer('seenby')->nullable();
                  $table->text('admitted_from')->nullable();
                  $table->text('major_complaints')->nullable();
                  $table->boolean('ventilation')->nullable()->default(0);  
                  $table->integer('mode')->nullable();
                  $table->integer('pip')->nullable();
                  $table->integer('peep')->nullable();
                  $table->integer('amplitude')->nullable();
                  $table->integer('mean_airway_pressure')->nullable();
                  $table->integer('rate')->nullable();
                  $table->string('it')->nullable();
                  $table->integer('fio2')->nullable();
                  $table->string('flow')->nullable();
                  $table->integer('rr')->nullable();
                  $table->text('nicu_retractions')->nullable();
                  $table->text('nicu_airentry')->nullable();
                  $table->text('chest_movement')->nullable();
                  $table->integer('hr')->nullable();
                  $table->integer('systolic_bp')->nullable();
                  $table->integer('diastolic_bp')->nullable();
                  $table->integer('mean_bp')->nullable();
                  $table->text('nicu_central_pulses')->nullable();
                  $table->text('nicu_peripheral_pulses')->nullable();
                  $table->text('nicu_femoral_pulses')->nullable();
                  $table->text('s1s2')->nullable();
                  $table->text('nicu_murmur')->nullable();
                  $table->text('cft')->nullable();
                  $table->text('nicu_color')->nullable();
                  $table->string('temperature')->nullable();
                  $table->text('nicu_abdomen')->nullable();
                  $table->text('nicu_bowel_sounds')->nullable();
                  $table->text('nicu_umbilicus')->nullable();
                  $table->text('nicu_hepatomegaly')->nullable();
                  $table->text('nicu_splenomegaly')->nullable();
                  $table->text('nicu_herina')->nullable();
                  $table->text('genitalia')->nullable();
                  $table->text('nicu_pupils')->nullable();
                  $table->text('nicu_anteriorfontanelle')->nullable();
                  $table->text('nicu_activity')->nullable();
                  $table->text('tone')->nullable();
                  $table->text('nicu_cry')->nullable();
                  $table->text('nicu_seizures')->nullable();
                  $table->text('nicu_neonatalreflexes')->nullable();
                  $table->text('skin')->nullable();
                  $table->text('abnormalities')->nullable();
                  $table->text('initialbloodgas')->nullable();
                  $table->text('agetaken')->nullable();
                  $table->integer('spo2')->nullable();
                  $table->string('ph')->nullable();
                  $table->integer('pao2')->nullable();
                  $table->integer('paco2')->nullable();
                  $table->string('hco3')->nullable();
                  $table->text('be')->nullable();
                  $table->integer('rbs')->nullable();
                  $table->integer('hct')->nullable();
                  $table->text('initialxray')->nullable();
                  $table->text('xrayfindings')->nullable();
                  $table->text('ageofcxr')->nullable();
                  $table->boolean('uac_status')->nullable()->default(0);
                  $table->text('uac_position')->nullable();
                  $table->boolean('uvc_status')->nullable();
                  $table->text('uvc_position')->nullable();
                  $table->text('sepsisscreen')->nullable();
                  $table->text('indications')->nullable();
                  $table->jsonb('ivantibiotic')->nullable();
                  $table->text('investigations')->nullable();
                  $table->integer('fluids')->nullable();
                  $table->text('enteral_feeding')->nullable();
                  $table->jsonb('differentialdiagnosis')->nullable();
                  $table->jsonb('additional_diagnosis')->nullable();
                  $table->text('plan')->nullable();
                  $table->boolean('parents_spoken')->nullable();
                  $table->integer('pdiscussion_hrs')->nullable();
                  $table->integer('pdiscussion_min')->nullable();
                  $table->string('pdiscussion_session')->nullable();
                  $table->integer('matters_discussed')->nullable();
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
		Schema::drop('postnatal_admission');
	}

}
