<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class NicuChanges extends Migration 
{
  /**
   * Run the migrations.
   *
   * @return void
   */
   public function up()
   {

      Schema::table('nicu_admission', function (Blueprint $table) {

            $table->text('additional_information')->nullable();
            $table->string('oae_left')->nullable();
            $table->string('oae_right')->nullable();
            $table->string('abr_left')->nullable();
            $table->string('abr_right')->nullable();
            $table->string('result_rop_left')->nullable();
            $table->string('result_rop_right')->nullable();
            $table->jsonb('typeoftreatment_left')->nullable();
            $table->jsonb('typeoftreatment_right')->nullable();
            $table->text('cranial_ultrasound')->nullable();
            $table->text('echocardiography')->nullable();
            $table->text('advice')->nullable();
            $table->text('plan_follow_up')->nullable();
            $table->string('Eyes')->nullable();
            $table->string('Hips')->nullable();
            $table->string('nicu_malformation')->nullable();
            $table->text('nicu_malformation_details')->nullable();

            $table->string('cardiacmurmur')->nullable();
            $table->string('PostductalSaturation')->nullable();
            $table->string('gentila')->nullable();
            $table->jsonb('procedures')->nullable();

      });
           
       Schema::table('nicu_admission_audit', function (Blueprint $table) {

            $table->text('additional_information')->nullable();
            $table->string('oae_left')->nullable();
            $table->string('oae_right')->nullable();
            $table->string('abr_left')->nullable();
            $table->string('abr_right')->nullable();
            $table->string('result_rop_left')->nullable();
            $table->string('result_rop_right')->nullable();
            $table->jsonb('typeoftreatment_left')->nullable();
            $table->jsonb('typeoftreatment_right')->nullable();
            $table->text('cranial_ultrasound')->nullable();
            $table->text('echocardiography')->nullable();
            $table->text('advice')->nullable();
            $table->text('plan_follow_up')->nullable();
            $table->string('Eyes')->nullable();
            $table->string('Hips')->nullable();
            $table->string('nicu_malformation')->nullable();
            $table->text('nicu_malformation_details')->nullable();
            $table->string('cardiacmurmur')->nullable();
            $table->string('PostductalSaturation')->nullable();
            $table->string('gentila')->nullable();
            $table->jsonb('procedures')->nullable();
      }); 		
   }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    	Schema::table('nicu_admission', function (Blueprint $table) {
        
            $table->dropColumn('additional_information')->nullable();
            $table->dropColumn('oae_left')->nullable();
            $table->dropColumn('oae_right')->nullable();
            $table->dropColumn('abr_left')->nullable();
            $table->dropColumn('abr_right')->nullable();
            $table->dropColumn('result_rop_left')->nullable();
            $table->dropColumn('result_rop_right')->nullable();
            $table->dropColumn('typeoftreatment_left')->nullable();
            $table->dropColumn('typeoftreatment_right')->nullable();
            $table->dropColumn('cranial_ultrasound')->nullable();
            $table->dropColumn('echocardiography')->nullable();
            $table->dropColumn('advice')->nullable();
            $table->dropColumn('plan_follow_up')->nullable();
            $table->dropColumn('Eyes')->nullable();
            $table->dropColumn('Hips')->nullable();
            $table->dropColumn('nicu_malformation')->nullable();
            $table->dropColumn('nicu_malformation_details')->nullable();
            $table->dropColumn('cardiacmurmur')->nullable();
            $table->dropColumn('PostductalSaturation')->nullable();
            $table->dropColumn('gentila')->nullable();
            $table->dropColumn('procedures')->nullable();

      });

      Schema::table('nicu_admission_audit', function (Blueprint $table) {
        
            $table->dropColumn('additional_information')->nullable();
            $table->dropColumn('oae_left')->nullable();
            $table->dropColumn('oae_right')->nullable();
            $table->dropColumn('abr_left')->nullable();
            $table->dropColumn('abr_right')->nullable();
            $table->dropColumn('result_rop_left')->nullable();
            $table->dropColumn('result_rop_right')->nullable();
            $table->dropColumn('typeoftreatment_left')->nullable();
            $table->dropColumn('typeoftreatment_right')->nullable();
            $table->dropColumn('cranial_ultrasound')->nullable();
            $table->dropColumn('echocardiography')->nullable();
            $table->dropColumn('advice')->nullable();
            $table->dropColumn('plan_follow_up')->nullable();
            $table->dropColumn('Eyes')->nullable();
            $table->dropColumn('Hips')->nullable();
            $table->dropColumn('nicu_malformation')->nullable();
            $table->dropColumn('nicu_malformation_details')->nullable();
            $table->dropColumn('cardiacmurmur')->nullable();
            $table->dropColumn('PostductalSaturation')->nullable();
            $table->dropColumn('gentila')->nullable();
            $table->dropColumn('procedures')->nullable();
      });
    }

}
