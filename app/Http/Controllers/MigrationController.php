<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Filesystem\Filesystem;

class MigrationController extends Controller 
{

	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		/*STEP = 1 => COPY TABLES AND DATA FROM INTERFACE*/
		$unused_table_array = ["interface_machine", "interface_machine_status", "lab_request","mas_collection_method","mas_collection_site","mas_investigation","nurse_glucose_intake","nurse_glucose_intake_discharged","nurse_iv_infusion","nurse_iv_infusion_discharged","nurse_oral_drugs","nurse_oral_drugs_discharged","nurse_other_iv_drugs","nurse_other_iv_drugs_discharged","nurse_other_iv_infusion","nurse_other_iv_infusion_discharged","photo_video_upload","prescribed_drugs","prescribed_drugs_discharged","op_search", "pd_published", "mas_daycareproblems"];

		$tables = \DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
		$live_tables = collect(\DB::connection('live_db')->select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'"))->pluck('table_name')->toArray();

		$newly_added_tables = array();

		foreach ($tables as $table_key => $table) {
			if (!in_array($table->table_name, $unused_table_array)) {
				/*WHEN LIVE DB NOT HAVE TABLE*/
				if (!in_array($table->table_name, $live_tables)) {
					if (Schema::connection('live_db')->hasTable($table->table_name)) {
						continue;
					}
					else
					{

						if ($table->table_name == 'emr_lab_values' || $table->table_name == 'emr_lab_values_discharged' || $table->table_name == 'emr_log_dtl' || $table->table_name == 'emr_ventilator_values' || $table->table_name == 'emr_ventilator_values_discharged' || $table->table_name == 'emr_moniter_values' || $table->table_name == 'emr_moniter_values_discharged' || $table->table_name == 'emr_nurse_manual_values') {
							if (!Schema::connection('live_db')->hasTable("emr_log_hdr")) {
								$this->createTable('emr_log_hdr');
								$this->copyTableRecords('emr_log_hdr');
								array_push($newly_added_tables, 'emr_log_hdr');
							}
						}

						if ($table->table_name == 'loinc_local_code_map_part') {

							if (!Schema::connection('live_db')->hasTable("local_code_group")) {
								$this->createTable('local_code_group');

								\DB::table('loinc_local_code_map_part')->where('id', 12)->where('ref_loc_master_id', 233)->update('id', 283);
								\DB::table('loinc_local_code_map_part')->where('id', 13)->where('ref_loc_master_id', 273)->update('id', 284);
								\DB::table('loinc_local_code_map_part')->where('id', 234)->where('ref_loc_master_id', 232)->update('id', 285);

								$this->copyTableRecords('local_code_group');
								array_push($newly_added_tables, 'local_code_group');
							}
						}

						if ($table->table_name == 'emr_config_value') {

							if (!Schema::connection('live_db')->hasTable("emr_config_group")) {
								$this->createTable('emr_config_group');
								$this->copyTableRecords('emr_config_group');
								array_push($newly_added_tables, 'emr_config_group');
							}
						}

						if ($table->table_name == 'prescription_dtl' || $table->table_name == 'prescription_dtl_discharged') {

							if (!Schema::connection('live_db')->hasTable("prescription_hdr")) {
								$this->createTable('prescription_hdr');
								$this->copyTableRecords('prescription_hdr');
								array_push($newly_added_tables, 'prescription_hdr');
							}
						}

						if ($table->table_name == 'neuro_eligibility' || $table->table_name == 'neuro_formal_developmental_assessment' || $table->table_name == 'neuro_muscle_tone_norms' || $table->table_name == 'neuro_over_all_assessment' || $table->table_name == 'neuro_screening' || $table->table_name == 'op_nuerodevelopment_report_mon_yr') {

							if (!Schema::connection('live_db')->hasTable("op_details")) {
								$this->createTable('op_details');
								$this->copyTableRecords('op_details');
								array_push($newly_added_tables, 'op_details');
							}
						}

						$this->createTable($table->table_name);
						if ($table->table_name != 'concept_f' && $table->table_name != 'description_f' && $table->table_name != 'stated_relationship_f') {

							$this->copyTableRecords($table->table_name);
							array_push($newly_added_tables, $table->table_name);
						}
						
					}

				}
				/*WHEN LIVE DB HAVE TABLE*/
				else
				{

					$table_comment_query = "SELECT c.column_name, c.data_type, c.character_maximum_length,pgd.description
											FROM pg_catalog.pg_statio_all_tables as st
											inner join pg_catalog.pg_description pgd on (pgd.objoid=st.relid)
											inner join information_schema.columns c on (pgd.objsubid=c.ordinal_position
											and  c.table_schema=st.schemaname and c.table_name=st.relname) where pgd.description IS 
											NOT NULL and c.table_name = '".$table->table_name."'";
					
					$structure_query = "SELECT column_name,data_type,character_maximum_length,column_default from INFORMATION_SCHEMA.COLUMNS where table_name ='".$table->table_name."'";

					$live_table_structure = \DB::connection('live_db')->select($structure_query);
					
					$interface_table_structure = \DB::select($structure_query);
					if (count($live_table_structure) != count($interface_table_structure)) {
						
						$live_table_columns = collect($live_table_structure)->pluck('column_name')->toArray();
						$interface_table_columns = collect($interface_table_structure)->pluck('column_name')->toArray();
						$missed_columns = array_diff($interface_table_columns, $live_table_columns);
						
						if (count($missed_columns) > 0) {
							foreach ($missed_columns as $col_key => $col_value) {
								$missed_col_details = collect($interface_table_structure)->where('column_name', $col_value)->first();
								$this->updateTableSchema($table->table_name, $missed_col_details, $col_value);
							}
						}

					}
				}
			}
		}
		
		/*STEP=3 COPY BABY AND THEIR ADMISSION DETAILS WHICH ARE NOT IN LIVE TABLE AND MERGE IT TO INTERFACE RECORDS*/
		$recent_interface_babies = \DB::table('baby')->orderby('BabyId', 'desc')->limit(40)->get();
		
		foreach ($recent_interface_babies as $interface_baby_key => $interface_baby_value) {
			$check_live_baby_exist = \DB::connection('live_db')->table('baby')->where('BMrNo', $interface_baby_value->BMrNo)->first();
			if (!isset($check_live_baby_exist->BabyId)) {
				$interface_baby_name = $interface_baby_value->BabyName;
				if(preg_match("/twin/", $interface_baby_name)) {
					$split_baby_name = explode(' ', $interface_baby_name);
					$sibling_name = $split_baby_name[0].' '.$split_baby_name[1];
					
				    $get_twin_siblings_from_live = \DB::connection('live_db')->table('baby')->where('BabyName', 'like', '%'.$sibling_name.'%')->where('DOB', $interface_baby_value->DOB)->first();
				    if (isset($get_twin_siblings_from_live->MotherId) && !empty($get_twin_siblings_from_live->MotherId)) {
				    	
				    	$new_baby = (array)$interface_baby_value;
				    	$new_baby['MotherId'] = $live_mother_id = $get_twin_siblings_from_live->MotherId;
				    	$new_baby['MultiplePregnancyType'] = "Twins";
				    	$new_baby['MultiplePregnancy'] = "Yes";
				    	unset($new_baby['BabyId']);
				    	$live_baby_id = \DB::connection('live_db')->table('baby')->insertGetId($new_baby, 'BabyId');
				    }
				    else
				    {
				    	$get_interface_mother = \DB::table('mother')->where('MotherId', $interface_baby_value->MotherId)->first();
				    	$new_mother = (array) $get_interface_mother;
				    	unset($new_mother['MotherId']);
				    	echo "<pre>"; print_r($new_mother);
				    	$live_mother_id = \DB::connection('live_db')->table('mother')->insertGetId($new_mother, 'MotherId');
				    	$new_baby = (array)$interface_baby_value;
				    	$new_baby['MotherId'] = $live_mother_id;
				    	$new_baby['MultiplePregnancyType'] = "Twins";
				    	$new_baby['MultiplePregnancy'] = "Yes";
				    	unset($new_baby['BabyId']);
				    	$live_baby_id = \DB::connection('live_db')->table('baby')->insertGetId($new_baby, 'BabyId');
				    }

				}
				else
				{
					$get_interface_mother = \DB::table('mother')->where('MotherId', $interface_baby_value->MotherId)->first();
			    	$new_mother = (array) $get_interface_mother;
			    	unset($new_mother['MotherId']);
			    	echo "<pre>"; print_r($new_mother);
			    	
			    	$live_mother_id = \DB::connection('live_db')->table('mother')->insertGetId($new_mother, 'MotherId');
			    	$new_baby = (array)$interface_baby_value;
			    	$new_baby['MotherId'] = $live_mother_id;
			    	unset($new_baby['BabyId']);
				    $live_baby_id = \DB::connection('live_db')->table('baby')->insertGetId($new_baby, 'BabyId');
				}

				$interface_baby_admission = \DB::table('baby_admission')->where('BabyId', $interface_baby_value->BabyId)->orderBy('AdmissionId', 'desc')->first();
				
				$new_baby_admission = (array) $interface_baby_admission;
				unset($new_baby_admission['AdmissionId']);
				$new_baby_admission['BabyId'] = $live_baby_id;
				$new_baby_admission['MotherId'] = $live_mother_id;
				$new_baby_admission['BMrNo'] = $interface_baby_value->BMrNo;
				$new_baby_admission['AdmissionDate'] = $interface_baby_admission->AdmissionDate;
				$live_admission_id = \DB::connection('live_db')->table('baby_admission')->insertGetId($new_baby_admission, 'AdmissionId');


				$interface_nicu_admission = \DB::table('nicu_admission')->where('BabyId', $interface_baby_value->BabyId)->where('AdmissionId', $interface_baby_admission->AdmissionId)->first();
				
				$new_nicu_admission = (array) $interface_nicu_admission;
				unset($new_nicu_admission['NicuId']);
				$new_nicu_admission['BabyId'] = $live_baby_id;
				$new_nicu_admission['MotherId'] = $live_mother_id;
				$new_nicu_admission['AdmissionId'] = $live_admission_id;
				$live_nicu_id = \DB::connection('live_db')->table('nicu_admission')->insertGetId($new_nicu_admission, 'NicuId');


				$interface_ip_number = \DB::table('ip_numbers')->where('baby_id', $interface_baby_value->BabyId)->where('AdmissionId', $interface_baby_admission->AdmissionId)->first();
				$new_ip_number = (array) $interface_ip_number;
				unset($new_ip_number['id']);
				$new_ip_number['baby_id'] = $live_baby_id;
				$new_ip_number['AdmissionId'] = $live_admission_id;
				$live_ip_id = \DB::connection('live_db')->table('ip_numbers')->insertGetId($new_ip_number);

				\DB::connection('live_db')->table('emr_log_hdr')->where('admission_id', $interface_baby_admission->AdmissionId)->update(['baby_id'=>$live_baby_id, 'admission_id'=>$live_admission_id, 'mother_id'=>$live_mother_id]);
				
				\DB::connection('live_db')->table('patient_bed_log')->where('admission_id', $interface_baby_admission->AdmissionId)->update(['baby_id'=>$live_baby_id, 'admission_id'=>$live_admission_id]);
				
				\DB::connection('live_db')->table('nurse_main_sheet')->where('admission_id', $interface_baby_admission->AdmissionId)->update(['baby_id'=>$live_baby_id, 'admission_id'=>$live_admission_id]);

			}

		}

		// /*STEP = 3 => CHANGE ADMISSION ID AND BABY ID IN INTERFACE DATA BASED ON NICU ADMISSION IN LIVE RECORD*/
		$live_results = \DB::connection('live_db')->table('nicu_admission')->where('IsDeleted', '0')
							->orderby('AdmissionId', 'desc')
							->get();

		$interface_results = \DB::table('baby_admission')->orderby('AdmissionId', 'desc')->get();

		$i= $j = $p =0;

		foreach ($interface_results as $key => $value) {
			
			$get_interface_baby = $live_results->where('AdmissionDate', $value->AdmissionDate)->where('BMrNo',$value->BMrNo)->first();
			if (count($get_interface_baby) > 0) {
				
				\DB::connection('live_db')->table('emr_log_hdr')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_interface_baby->BabyId, 'admission_id'=>$get_interface_baby->AdmissionId, 'mother_id'=>$get_interface_baby->MotherId]);
				
				\DB::connection('live_db')->table('nurse_main_sheet')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_interface_baby->BabyId, 'admission_id'=>$get_interface_baby->AdmissionId]);
				
				\DB::connection('live_db')->table('prescription_hdr')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_interface_baby->BabyId, 'admission_id'=>$get_interface_baby->AdmissionId, 'mother_id'=>$get_interface_baby->MotherId]);
				
				\DB::connection('live_db')->table('patient_bed_log')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_interface_baby->BabyId, 'admission_id'=>$get_interface_baby->AdmissionId]);

				$get_baby_ip_number = \DB::table('ip_numbers')->select('ip_number')->where('AdmissionId', $value->AdmissionId)->first();
 
				if (isset($get_baby_ip_number->ip_number) && !empty($get_baby_ip_number->ip_number)) {

					$ip_numbers = \DB::connection('live_db')->table('ip_numbers')->select('ip_number')->where("AdmissionId", $get_interface_baby->AdmissionId)->first();

					\DB::connection('live_db')->table('ip_numbers')->where("AdmissionId", $get_interface_baby->AdmissionId)->update(['ip_number'=>$get_baby_ip_number->ip_number]);
				}
					
				// $i++;
			}
			else
			{
				// echo "<pre>"; print_r('mrn not found========================'.$value->BMrNo);
				// echo "<pre>"; print_r('mrn not found========================'.$value->AdmissionDate);
				$plus_one_day = [date('Y-m-d', strtotime($value->AdmissionDate.' -1 day')), date('Y-m-d', strtotime($value->AdmissionDate.' +1 day'))];
				$get_live_baby_admission_after_day = $live_results->whereIn('AdmissionDate', date('Y-m-d', strtotime($value->AdmissionDate.' +1 day')))->where('BMrNo',$value->BMrNo)->first();
				
				if (isset($get_live_baby_admission_after_day->AdmissionId)) {
					\DB::connection('live_db')->table('emr_log_hdr')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_live_baby_admission_after_day->BabyId, 'admission_id'=>$get_live_baby_admission_after_day->AdmissionId, 'mother_id'=>$get_live_baby_admission_after_day->MotherId]);

					\DB::connection('live_db')->table('nurse_main_sheet')->where("admission_id", $value->AdmissionId)->where('sheet_date', $value->AdmissionDate)->delete();
				
					\DB::connection('live_db')->table('nurse_main_sheet')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_live_baby_admission_after_day->BabyId, 'admission_id'=>$get_live_baby_admission_after_day->AdmissionId]);
					
					\DB::connection('live_db')->table('prescription_hdr')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_live_baby_admission_after_day->BabyId, 'admission_id'=>$get_live_baby_admission_after_day->AdmissionId, 'mother_id'=>$get_live_baby_admission_after_day->MotherId]);
					
					\DB::connection('live_db')->table('patient_bed_log')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_live_baby_admission_after_day->BabyId, 'admission_id'=>$get_live_baby_admission_after_day->AdmissionId]);

					$get_baby_ip_number = \DB::table('ip_numbers')->select('ip_number')->where('AdmissionId', $value->AdmissionId)->first();
	 
					if (isset($get_baby_ip_number->ip_number) && !empty($get_baby_ip_number->ip_number)) {

						$ip_numbers = \DB::connection('live_db')->table('ip_numbers')->select('ip_number')->where("AdmissionId", $get_live_baby_admission_after_day->AdmissionId)->first();

						\DB::connection('live_db')->table('ip_numbers')->where("AdmissionId", $get_live_baby_admission_after_day->AdmissionId)->update(['ip_number'=>$get_baby_ip_number->ip_number]);
					}
				}
				else{

					$get_live_baby_admission_before_day = $live_results->whereIn('AdmissionDate', date('Y-m-d', strtotime($value->AdmissionDate.' -1 day')))->where('BMrNo',$value->BMrNo)->first();
		
					if (isset($get_live_baby_admission_before_day->AdmissionId)) {
						\DB::connection('live_db')->table('emr_log_hdr')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_live_baby_admission_before_day->BabyId, 'admission_id'=>$get_live_baby_admission_before_day->AdmissionId, 'mother_id'=>$get_live_baby_admission_before_day->MotherId]);
					
						\DB::connection('live_db')->table('nurse_main_sheet')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_live_baby_admission_before_day->BabyId, 'admission_id'=>$get_live_baby_admission_before_day->AdmissionId]);

						$max_id = \DB::connection('live_db')->select("SELECT MAX(id)+1 as next_value FROM nurse_main_sheet");
						$insert_nurse_sheet_main = array(
							'id' => $max_id[0]->next_value,
							'day_name' => 'Day',
							'sheet_date' => date('Y-m-d', strtotime($value->AdmissionDate.' -1 day')),
							'baby_id' => $get_live_baby_admission_before_day->BabyId,
							'admission_id' => $get_live_baby_admission_before_day->AdmissionId,

						);
						
						\DB::connection('live_db')->table('nurse_main_sheet')->insert($insert_nurse_sheet_main);


						\DB::connection('live_db')->table('prescription_hdr')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_live_baby_admission_before_day->BabyId, 'admission_id'=>$get_live_baby_admission_before_day->AdmissionId, 'mother_id'=>$get_live_baby_admission_before_day->MotherId]);
						
						\DB::connection('live_db')->table('patient_bed_log')->where("admission_id", $value->AdmissionId)->update(['baby_id'=>$get_live_baby_admission_before_day->BabyId, 'admission_id'=>$get_live_baby_admission_before_day->AdmissionId]);

						$get_baby_ip_number = \DB::table('ip_numbers')->select('ip_number')->where('AdmissionId', $value->AdmissionId)->first();
		 
						if (isset($get_baby_ip_number->ip_number) && !empty($get_baby_ip_number->ip_number)) {

							$ip_numbers = \DB::connection('live_db')->table('ip_numbers')->select('ip_number')->where("AdmissionId", $get_live_baby_admission_before_day->AdmissionId)->first();

							\DB::connection('live_db')->table('ip_numbers')->where("AdmissionId", $get_live_baby_admission_before_day->AdmissionId)->update(['ip_number'=>$get_baby_ip_number->ip_number]);
						}
					}
				}
			}
		}

		$live_db_users = \DB::connection('live_db')->table('users')->get();
		
		$interface_users = \DB::table('users')->orderBy('id')->get();
				
		\DB::connection('live_db')->statement("ALTER TABLE prescription_dtl
			ADD is_created_user_updated boolean NOT NULL DEFAULT 'false',
			ADD is_started_user_updated boolean NOT NULL DEFAULT 'false',
			ADD is_stopped_user_updated boolean NOT NULL DEFAULT 'false',
			ADD is_cancelled_user_updated boolean NOT NULL DEFAULT 'false',
			ADD is_modified_started_user_updated boolean NOT NULL DEFAULT 'false',
			ADD is_modified_stopped_user_updated boolean NOT NULL DEFAULT 'false',
			ADD is_modified_cancelled_user_updated boolean NOT NULL DEFAULT 'false',
			ADD is_modified_user_updated boolean NOT NULL DEFAULT 'false';");

		\DB::connection('live_db')->statement("ALTER TABLE prescription_hdr
			ADD is_created_user_updated boolean NOT NULL DEFAULT 'false',
			ADD is_prescribed_by_updated boolean NOT NULL DEFAULT 'false',
			ADD is_modified_user_updated boolean NOT NULL DEFAULT 'false';");
		
		foreach ($interface_users as $user_key => $user_value) {
			
			$check_live_user = $live_db_users->where('email', $user_value->email)->first();
			if (isset($check_live_user->id)) {
				

				\DB::connection('live_db')->table('users')->where('id', $check_live_user->id)->update(['signature'=>$user_value->signature, 'initial'=>$user_value->initial]);

				\DB::connection('live_db')->table('prescription_dtl')->where('created_user', $user_value->id)->where('is_created_user_updated', false)->update(['created_user'=>$check_live_user->id, 'is_created_user_updated'=>true]);
				
				\DB::connection('live_db')->table('prescription_dtl')->where('modified_user', $user_value->id)->where('is_modified_user_updated', false)->update(['modified_user'=>$check_live_user->id, 'is_modified_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_dtl')->where('started_user', $user_value->id)->where('is_started_user_updated', false)->update(['started_user'=>$check_live_user->id, 'is_started_user_updated'=>true]);
				
				\DB::connection('live_db')->table('prescription_dtl')->where('stopped_user', $user_value->id)->where('is_stopped_user_updated', false)->update(['stopped_user'=>$check_live_user->id, 'is_stopped_user_updated'=>true]);
				
				\DB::connection('live_db')->table('prescription_dtl')->where('cancelled_user', $user_value->id)->where('is_cancelled_user_updated', false)->update(['cancelled_user'=>$check_live_user->id, 'is_cancelled_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_dtl')->where('modified_started_user', $user_value->id)->where('is_modified_started_user_updated', false)->update(['modified_started_user'=>$check_live_user->id, 'is_modified_started_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_dtl')->where('modified_stopped_user', $user_value->id)->where('is_modified_stopped_user_updated', false)->update(['modified_stopped_user'=>$check_live_user->id, 'is_modified_stopped_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_dtl')->where('modified_cancelled_user', $user_value->id)->where('is_modified_cancelled_user_updated', false)->update(['modified_cancelled_user'=>$check_live_user->id, 'is_modified_cancelled_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_hdr')->where('created_user', $user_value->id)->where('is_created_user_updated', false)->update(['created_user'=>$check_live_user->id, 'is_created_user_updated'=>true]);
				
				\DB::connection('live_db')->table('prescription_hdr')->where('modified_user', $user_value->id)->where('is_modified_user_updated', false)->update(['modified_user'=>$check_live_user->id, 'is_modified_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_hdr')->where('prescribed_by', $user_value->id)->where('is_prescribed_by_updated', false)->update(['prescribed_by'=>$check_live_user->id, 'is_prescribed_by_updated'=>true]);

			}
			else
			{
				$user_value = (array) $user_value;
				$interface_user_id = $user_value['id'];
				unset($user_value['id']);
				$live_user_id = \DB::connection('live_db')->table('users')->insertGetId($user_value);

				\DB::connection('live_db')->table('prescription_dtl')->where('created_user', $interface_user_id)->where('is_created_user_updated', false)->update(['created_user'=>$live_user_id, 'is_created_user_updated'=>true]);
				
				\DB::connection('live_db')->table('prescription_dtl')->where('modified_user', $interface_user_id)->where('is_modified_user_updated', false)->update(['modified_user'=>$live_user_id, 'is_modified_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_dtl')->where('started_user', $interface_user_id)->where('is_started_user_updated', false)->update(['started_user'=>$live_user_id, 'is_started_user_updated'=>true]);
				
				\DB::connection('live_db')->table('prescription_dtl')->where('stopped_user', $interface_user_id)->where('is_stopped_user_updated', false)->update(['stopped_user'=>$live_user_id, 'is_stopped_user_updated'=>true]);
				
				\DB::connection('live_db')->table('prescription_dtl')->where('cancelled_user', $interface_user_id)->where('is_cancelled_user_updated', false)->update(['cancelled_user'=>$live_user_id, 'is_cancelled_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_dtl')->where('modified_started_user', $interface_user_id)->where('is_modified_started_user_updated', false)->update(['modified_started_user'=>$live_user_id, 'is_modified_started_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_dtl')->where('modified_stopped_user', $interface_user_id)->where('is_modified_stopped_user_updated', false)->update(['modified_stopped_user'=>$live_user_id, 'is_modified_stopped_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_dtl')->where('modified_cancelled_user', $interface_user_id)->where('is_modified_cancelled_user_updated', false)->update(['modified_cancelled_user'=>$live_user_id, 'is_modified_cancelled_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_hdr')->where('created_user', $interface_user_id)->where('is_created_user_updated', false)->update(['created_user'=>$live_user_id, 'is_created_user_updated'=>true]);
				
				\DB::connection('live_db')->table('prescription_hdr')->where('modified_user', $interface_user_id)->where('is_modified_user_updated', false)->update(['modified_user'=>$live_user_id, 'is_modified_user_updated'=>true]);

				\DB::connection('live_db')->table('prescription_hdr')->where('prescribed_by', $interface_user_id)->where('is_prescribed_by_updated', false)->update(['prescribed_by'=>$live_user_id, 'is_prescribed_by_updated'=>true]);

			}
		}
		\DB::connection('live_db')->statement("ALTER TABLE prescription_dtl
			DROP is_created_user_updated,
			DROP is_started_user_updated,
			DROP is_stopped_user_updated,
			DROP is_cancelled_user_updated,
			DROP is_modified_started_user_updated,
			DROP is_modified_stopped_user_updated,
			DROP is_modified_cancelled_user_updated,
			DROP is_modified_user_updated;");

		\DB::connection('live_db')->statement("ALTER TABLE prescription_hdr
			DROP is_created_user_updated,
			DROP is_prescribed_by_updated,
			DROP is_modified_user_updated;");

		/*STEP - 4 => ADD OR UPDATE COLUMS AND ROWS IN LIVE TABLE FROM INTERFACING RECORDS*/
		array_push($newly_added_tables, 'mas_problems');
		array_push($newly_added_tables, 'mas_nures');
		array_push($newly_added_tables, 'mas_procedures');
		array_push($newly_added_tables, 'mas_admissionmode');
		array_push($newly_added_tables, 'mas_complication');
		array_push($newly_added_tables, 'mas_indication');
		array_push($newly_added_tables, 'mas_medical_problems');
		array_push($newly_added_tables, 'mas_vaccine');

		// \DB::connection('live_db')->statement('UPDATE loinc_local_code_map_part
		// SET id = 283
		// WHERE id = 12 AND ref_loc_master_id = 233');

		// \DB::connection('live_db')->statement('UPDATE loinc_local_code_map_part
		// SET id = 284
		// WHERE id = 13 AND ref_loc_master_id = 273');

		// \DB::connection('live_db')->statement('UPDATE loinc_local_code_map_part
		// SET id = 285
		// WHERE id = 234 AND ref_loc_master_id = 232');

		$this->alterSequences($newly_added_tables);

		$this->copyTableRecords('mas_nures');
		$this->copyTableRecords('mas_problems');
		$this->copyTableRecords('mas_procedures');
		
		$this->copyTableRecordsWithCheckOld('mas_admissionmode', 'Mode_name', 'Id');
		$this->copyTableRecordsWithCheckOld('mas_complication', 'Name', 'Id');
		$this->copyTableRecordsWithCheckOld('mas_indication', 'indication_name', 'Id');
		$this->copyTableRecordsWithCheckOld('mas_medical_problems', 'Name', 'Id');
		$this->copyTableRecordsWithCheckOld('mas_vaccine', 'Name', 'Id');

		$live_drug_list = \DB::connection('live_db')->table('mas_drugs')->get();
		foreach ($live_drug_list as $drug_key => $drug_value) {
			
			$check_interface_drug = \DB::table('mas_drugivfluid')->where('brand_name', trim($drug_value->Name))->first();

			if (isset($check_interface_drug->id) && count($check_interface_drug) > 0) {
				if ($check_interface_drug->id != $drug_value->Id) {
					
					\DB::connection('live_db')->table('mas_drugivfluid')->where('id', $check_interface_drug->id)->update(['id'=>$drug_value->Id]);
					
					\DB::connection('live_db')->table('prescription_hdr')->where('brand_name', $check_interface_drug->id)->update(['brand_name'=>$drug_value->Id, 'pharmacological_name'=>$drug_value->Id]);
					
				}
				// echo "<pre>"; print_r("DRUG FOUND IN INTERFACE TABLE");
			}
			else
			{
				$new_drug = array(
					"brand_name" => $drug_value->Name,
					"generic_pharmacological_name" => $drug_value->generic_name,
					"value" => $drug_value->Value,
					"status" => true,
					"date_added" => $drug_value->DateAdded,
					"date_modified" => $drug_value->DateModified,
					"user_added" => '6',
					"user_modified" => '6',
					"is_deleted" => false,
					"anti_status" => false,
					"type" => "ORAL",
					"id" => $drug_value->Id,
				);
				\DB::connection('live_db')->table('mas_drugivfluid')->insert($new_drug);
				echo "<pre>"; print_r($new_drug);

			}
		}

		$interfacing_babies_with_allergies = \DB::table('baby')->select('BMrNo', 'allegries')->whereNotNull('allegries')->get();
		if (count($interfacing_babies_with_allergies) > 0) {
			foreach ($interfacing_babies_with_allergies as $baby_key => $baby_value) {
				\DB::connection('live_db')->table('baby')->where('BMrNo', $baby_value->BMrNo)->update(['allegries'=> $baby_value->allegries]);
			}
		}

		$interface_config_settings = \DB::table('config_settings')->orderBy('slug_code')->get();
		$live_config_settings = \DB::connection('live_db')->table('config_settings')->orderBy('slug_code')->pluck('code_values', 'slug_code')->toArray();
		
		if (count($interface_config_settings) > 0) {
			$config_table_insert = array();
			foreach ($interface_config_settings as $config_key => $config_value) {
				if (!isset($live_config_settings[$config_value->slug_code])) {
					$new_config_array = array(
						'slug_code' => $config_value->slug_code,
						'code_values' => $config_value->code_values,
						'status' => $config_value->status,
					);
					$config_table_insert[] = $new_config_array;
				}
			}
			\DB::connection('live_db')->table('config_settings')->insert($config_table_insert);
		}
		
		$interface_sitesetting = \DB::table('site_settings')->select('api_key','api_user_name','api_password','period', 'custom_toastr', 'neonatal_highlight', 'nicu_highlight', 'nicu_daycare_highlight', 'daycare_summary_highlight', 'prblm_summary_highlight', 'post_adm_highlight', 'post_daycare_adm_highlight', 'post_summary_highlight', 'op_highlight', 'daycare_dates_for_chart')->first();

		\DB::connection('live_db')->table('site_settings')->update((array) $interface_sitesetting);
		
		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_antibiotic"."Name" IS \'text\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_antibiotic"."Status" IS \'{ "type": "select", "values": { "Active": "Active", "Inactive": "Inactive"} } \'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_complication"."Name" IS \'text\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_complication"."Status" IS \'{ "type": "select", "values": { "Active": "Active", "Inactive": "Inactive"} } \'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_doctors"."Name" IS \'text\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_doctors"."status" IS \'{ "type": "select",   "values": { "1": "Active", "2": "Inactive"} }\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_doctors"."type" IS \'{ "type": "select",   "values": { "1": "Doctors", "2": "Surgeons"} }\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_doctors"."Qualification" IS \'text\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_doctors"."job_title" IS \'text\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_indication"."indication_name" IS \'text\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_indication"."indication_status" IS \'{ "type": "select", "values": { "1": "Active", "0": "Inactive"} } \'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_medical_problems"."Name" IS \'text\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_medical_problems"."Status" IS \'{ "type": "select", "values": { "Active": "Active", "Inactive": "Inactive"} } \'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_nures"."name" IS \'text\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_nures"."status" IS \'{ "type": "select", "values": { "Active": "Active", "Inactive": "Inactive"} } \'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_vaccine"."Name" IS \'text\'');

		\DB::connection('live_db')->statement('COMMENT ON COLUMN "public"."mas_vaccine"."Status" IS \'{ "type": "select", "values": { "Active": "Active", "Inactive": "Inactive"} } \'');

		\DB::connection('live_db')->statement('UPDATE user_role
			SET "Permissions" = \'a:3:{s:16:"write_permission";a:46:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:9:"NICU_FORM";s:2:"on";s:8:"NICU_DAY";s:2:"on";s:16:"NICU_PROBLEM_DAY";s:2:"on";s:14:"NICU_DISCHARGE";s:2:"on";s:22:"NICU_PROBLEM_DISCHARGE";s:2:"on";s:14:"NICU_NURSE_DAY";s:2:"on";s:17:"NICU_MODULE_SHEET";s:2:"on";s:9:"POST_FORM";s:2:"on";s:8:"POST_DAY";s:2:"on";s:19:"POST_PROBLEM_SYSTEM";s:2:"on";s:14:"POST_DISCHARGE";s:2:"on";s:6:"OP_REG";s:2:"on";s:9:"TEST_ECHO";s:2:"on";s:10:"TEST_ULTRA";s:2:"on";s:12:"TEST_CULTURE";s:2:"on";s:18:"QUALITY_INDICATORS";s:2:"on";s:15:"WARD_MANAGEMENT";s:2:"on";s:10:"LABREQUEST";s:2:"on";s:12:"PRESCRIPTION";s:2:"on";s:10:"CALCULATOR";s:2:"on";s:13:"DELETE_ACCESS";s:2:"on";s:15:"MAS_ANTIBIOTICS";s:2:"on";s:17:"MAS_COMPLICATIONS";s:2:"on";s:13:"MAS_M_PROBLEM";s:2:"on";s:16:"MAS_B_PROCEDUURE";s:2:"on";s:13:"MAS_B_PROBLEM";s:2:"on";s:11:"MAS_VACCINE";s:2:"on";s:14:"MAS_INDICATION";s:2:"on";s:11:"MAS_DOCTORS";s:2:"on";s:17:"MAS_ADMISSIONMODE";s:2:"on";s:25:"MAS_RESPIRATORYINDICATION";s:2:"on";s:13:"BOOKING_PLACE";s:2:"on";s:14:"MAS_NURSE_LIST";s:2:"on";s:18:"MAS_REFERRALDOCTOR";s:2:"on";s:8:"MAS_WARD";s:2:"on";s:7:"MAS_BED";s:2:"on";s:13:"MAS_FREQUENCY";s:2:"on";s:16:"MAS_DRUG_IVFLUID";s:2:"on";s:21:"MAS_PRESCRIPTION_TYPE";s:2:"on";s:11:"USER_GROUPS";s:2:"on";s:5:"USERS";s:2:"on";s:11:"SITESETTING";s:2:"on";s:19:"MAS_PROBLEM_SETTING";s:2:"on";}s:15:"read_permission";a:59:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:9:"NICU_FORM";s:2:"on";s:8:"NICU_DAY";s:2:"on";s:16:"NICU_PROBLEM_DAY";s:2:"on";s:14:"NICU_DISCHARGE";s:2:"on";s:22:"NICU_PROBLEM_DISCHARGE";s:2:"on";s:14:"NICU_NURSE_DAY";s:2:"on";s:17:"NICU_MODULE_SHEET";s:2:"on";s:9:"POST_FORM";s:2:"on";s:8:"POST_DAY";s:2:"on";s:19:"POST_PROBLEM_SYSTEM";s:2:"on";s:14:"POST_DISCHARGE";s:2:"on";s:6:"OP_REG";s:2:"on";s:16:"REPORT_INPATIENT";s:2:"on";s:11:"REPORT_NICU";s:2:"on";s:9:"REPORT_OP";s:2:"on";s:11:"REPORT_PEDI";s:2:"on";s:14:"REPORT_NEWBORN";s:2:"on";s:12:"REPORT_BIRTH";s:2:"on";s:11:"REPORT_BABY";s:2:"on";s:11:"REPORT_ECHO";s:2:"on";s:14:"REPORT_CRANIAL";s:2:"on";s:14:"REPORT_CULTURE";s:2:"on";s:18:"REPORT_OP_ACTIVITY";s:2:"on";s:13:"REPORT_ANNUAL";s:2:"on";s:9:"TEST_ECHO";s:2:"on";s:10:"TEST_ULTRA";s:2:"on";s:12:"TEST_CULTURE";s:2:"on";s:12:"GROWTH_CHART";s:2:"on";s:18:"QUALITY_INDICATORS";s:2:"on";s:15:"WARD_MANAGEMENT";s:2:"on";s:10:"LABREQUEST";s:2:"on";s:12:"PRESCRIPTION";s:2:"on";s:10:"CALCULATOR";s:2:"on";s:13:"DELETE_ACCESS";s:2:"on";s:15:"MAS_ANTIBIOTICS";s:2:"on";s:17:"MAS_COMPLICATIONS";s:2:"on";s:13:"MAS_M_PROBLEM";s:2:"on";s:16:"MAS_B_PROCEDUURE";s:2:"on";s:13:"MAS_B_PROBLEM";s:2:"on";s:11:"MAS_VACCINE";s:2:"on";s:14:"MAS_INDICATION";s:2:"on";s:11:"MAS_DOCTORS";s:2:"on";s:17:"MAS_ADMISSIONMODE";s:2:"on";s:25:"MAS_RESPIRATORYINDICATION";s:2:"on";s:13:"BOOKING_PLACE";s:2:"on";s:14:"MAS_NURSE_LIST";s:2:"on";s:18:"MAS_REFERRALDOCTOR";s:2:"on";s:8:"MAS_WARD";s:2:"on";s:7:"MAS_BED";s:2:"on";s:13:"MAS_FREQUENCY";s:2:"on";s:16:"MAS_DRUG_IVFLUID";s:2:"on";s:21:"MAS_PRESCRIPTION_TYPE";s:2:"on";s:11:"USER_GROUPS";s:2:"on";s:5:"USERS";s:2:"on";s:11:"SITESETTING";s:2:"on";s:19:"MAS_PROBLEM_SETTING";s:2:"on";}s:17:"delete_permission";a:37:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:9:"NICU_FORM";s:2:"on";s:8:"NICU_DAY";s:2:"on";s:16:"NICU_PROBLEM_DAY";s:2:"on";s:14:"NICU_NURSE_DAY";s:2:"on";s:17:"NICU_MODULE_SHEET";s:2:"on";s:9:"POST_FORM";s:2:"on";s:8:"POST_DAY";s:2:"on";s:19:"POST_PROBLEM_SYSTEM";s:2:"on";s:6:"OP_REG";s:2:"on";s:9:"TEST_ECHO";s:2:"on";s:10:"TEST_ULTRA";s:2:"on";s:12:"TEST_CULTURE";s:2:"on";s:18:"QUALITY_INDICATORS";s:2:"on";s:10:"CALCULATOR";s:2:"on";s:15:"MAS_ANTIBIOTICS";s:2:"on";s:17:"MAS_COMPLICATIONS";s:2:"on";s:13:"MAS_M_PROBLEM";s:2:"on";s:16:"MAS_B_PROCEDUURE";s:2:"on";s:13:"MAS_B_PROBLEM";s:2:"on";s:11:"MAS_VACCINE";s:2:"on";s:14:"MAS_INDICATION";s:2:"on";s:11:"MAS_DOCTORS";s:2:"on";s:17:"MAS_ADMISSIONMODE";s:2:"on";s:25:"MAS_RESPIRATORYINDICATION";s:2:"on";s:13:"BOOKING_PLACE";s:2:"on";s:14:"MAS_NURSE_LIST";s:2:"on";s:18:"MAS_REFERRALDOCTOR";s:2:"on";s:8:"MAS_WARD";s:2:"on";s:7:"MAS_BED";s:2:"on";s:13:"MAS_FREQUENCY";s:2:"on";s:16:"MAS_DRUG_IVFLUID";s:2:"on";s:21:"MAS_PRESCRIPTION_TYPE";s:2:"on";s:11:"USER_GROUPS";s:2:"on";s:19:"MAS_PROBLEM_SETTING";s:2:"on";}}\'
			WHERE "RoleId" = 1');

		\DB::connection('live_db')->statement('UPDATE user_role
			SET "Permissions" = \'a:3:{s:16:"write_permission";a:42:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:9:"NICU_FORM";s:2:"on";s:8:"NICU_DAY";s:2:"on";s:16:"NICU_PROBLEM_DAY";s:2:"on";s:14:"NICU_DISCHARGE";s:2:"on";s:22:"NICU_PROBLEM_DISCHARGE";s:2:"on";s:14:"NICU_NURSE_DAY";s:2:"on";s:17:"NICU_MODULE_SHEET";s:2:"on";s:9:"POST_FORM";s:2:"on";s:8:"POST_DAY";s:2:"on";s:19:"POST_PROBLEM_SYSTEM";s:2:"on";s:14:"POST_DISCHARGE";s:2:"on";s:6:"OP_REG";s:2:"on";s:9:"TEST_ECHO";s:2:"on";s:10:"TEST_ULTRA";s:2:"on";s:12:"TEST_CULTURE";s:2:"on";s:18:"QUALITY_INDICATORS";s:2:"on";s:15:"WARD_MANAGEMENT";s:2:"on";s:12:"PRESCRIPTION";s:2:"on";s:10:"CALCULATOR";s:2:"on";s:15:"MAS_ANTIBIOTICS";s:2:"on";s:17:"MAS_COMPLICATIONS";s:2:"on";s:13:"MAS_M_PROBLEM";s:2:"on";s:16:"MAS_B_PROCEDUURE";s:2:"on";s:13:"MAS_B_PROBLEM";s:2:"on";s:11:"MAS_VACCINE";s:2:"on";s:14:"MAS_INDICATION";s:2:"on";s:11:"MAS_DOCTORS";s:2:"on";s:17:"MAS_ADMISSIONMODE";s:2:"on";s:25:"MAS_RESPIRATORYINDICATION";s:2:"on";s:13:"BOOKING_PLACE";s:2:"on";s:14:"MAS_NURSE_LIST";s:2:"on";s:18:"MAS_REFERRALDOCTOR";s:2:"on";s:13:"MAS_FREQUENCY";s:2:"on";s:16:"MAS_DRUG_IVFLUID";s:2:"on";s:21:"MAS_PRESCRIPTION_TYPE";s:2:"on";s:11:"USER_GROUPS";s:2:"on";s:5:"USERS";s:2:"on";s:11:"SITESETTING";s:2:"on";s:19:"MAS_PROBLEM_SETTING";s:2:"on";}s:15:"read_permission";a:55:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:9:"NICU_FORM";s:2:"on";s:8:"NICU_DAY";s:2:"on";s:16:"NICU_PROBLEM_DAY";s:2:"on";s:14:"NICU_DISCHARGE";s:2:"on";s:22:"NICU_PROBLEM_DISCHARGE";s:2:"on";s:14:"NICU_NURSE_DAY";s:2:"on";s:17:"NICU_MODULE_SHEET";s:2:"on";s:9:"POST_FORM";s:2:"on";s:8:"POST_DAY";s:2:"on";s:19:"POST_PROBLEM_SYSTEM";s:2:"on";s:14:"POST_DISCHARGE";s:2:"on";s:6:"OP_REG";s:2:"on";s:16:"REPORT_INPATIENT";s:2:"on";s:11:"REPORT_NICU";s:2:"on";s:9:"REPORT_OP";s:2:"on";s:11:"REPORT_PEDI";s:2:"on";s:14:"REPORT_NEWBORN";s:2:"on";s:12:"REPORT_BIRTH";s:2:"on";s:11:"REPORT_BABY";s:2:"on";s:11:"REPORT_ECHO";s:2:"on";s:14:"REPORT_CRANIAL";s:2:"on";s:14:"REPORT_CULTURE";s:2:"on";s:18:"REPORT_OP_ACTIVITY";s:2:"on";s:13:"REPORT_ANNUAL";s:2:"on";s:9:"TEST_ECHO";s:2:"on";s:10:"TEST_ULTRA";s:2:"on";s:12:"TEST_CULTURE";s:2:"on";s:12:"GROWTH_CHART";s:2:"on";s:18:"QUALITY_INDICATORS";s:2:"on";s:15:"WARD_MANAGEMENT";s:2:"on";s:12:"PRESCRIPTION";s:2:"on";s:10:"CALCULATOR";s:2:"on";s:15:"MAS_ANTIBIOTICS";s:2:"on";s:17:"MAS_COMPLICATIONS";s:2:"on";s:13:"MAS_M_PROBLEM";s:2:"on";s:16:"MAS_B_PROCEDUURE";s:2:"on";s:13:"MAS_B_PROBLEM";s:2:"on";s:11:"MAS_VACCINE";s:2:"on";s:14:"MAS_INDICATION";s:2:"on";s:11:"MAS_DOCTORS";s:2:"on";s:17:"MAS_ADMISSIONMODE";s:2:"on";s:25:"MAS_RESPIRATORYINDICATION";s:2:"on";s:13:"BOOKING_PLACE";s:2:"on";s:14:"MAS_NURSE_LIST";s:2:"on";s:18:"MAS_REFERRALDOCTOR";s:2:"on";s:13:"MAS_FREQUENCY";s:2:"on";s:16:"MAS_DRUG_IVFLUID";s:2:"on";s:21:"MAS_PRESCRIPTION_TYPE";s:2:"on";s:11:"USER_GROUPS";s:2:"on";s:5:"USERS";s:2:"on";s:11:"SITESETTING";s:2:"on";s:19:"MAS_PROBLEM_SETTING";s:2:"on";}s:17:"delete_permission";a:0:{}}\'
			WHERE "RoleId" = 20');

		\DB::connection('live_db')->statement('UPDATE user_role
			SET "Permissions" = \'a:3:{s:16:"write_permission";a:7:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:14:"NICU_NURSE_DAY";s:2:"on";s:17:"NICU_MODULE_SHEET";s:2:"on";s:15:"WARD_MANAGEMENT";s:2:"on";s:12:"PRESCRIPTION";s:2:"on";}s:15:"read_permission";a:7:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:14:"NICU_NURSE_DAY";s:2:"on";s:17:"NICU_MODULE_SHEET";s:2:"on";s:15:"WARD_MANAGEMENT";s:2:"on";s:12:"PRESCRIPTION";s:2:"on";}s:17:"delete_permission";a:0:{}}\'
			WHERE "RoleId" = 3');

		\DB::connection('live_db')->statement('UPDATE users
			SET "RoleId" = 2
			WHERE "RoleId" = 13');

		\DB::connection('live_db')->statement('UPDATE users
			SET "RoleId" = 3
			WHERE "RoleId" = 11');

		\DB::connection('live_db')->statement('UPDATE users
			SET "RoleId" = 5
			WHERE "RoleId" = 6');

		\DB::connection('live_db')->statement('UPDATE mas_doctors
			SET "userId" = 6
			WHERE id = 7');

		\DB::connection('live_db')->statement('UPDATE mas_doctors
			SET "userId" = 23 
			WHERE id = 8');

		\DB::connection('live_db')->statement('UPDATE mas_doctors
			SET "userId" = 17
			WHERE id = 19');

		\DB::connection('live_db')->statement('UPDATE mas_doctors
			SET "userId" = 18
			WHERE id = 21');

		\DB::connection('live_db')->statement('UPDATE mas_doctors
			SET "userId" = 19
			WHERE id = 22');

		\DB::connection('live_db')->statement('UPDATE mas_doctors
			SET "userId" = 21
			WHERE id = 25');

		\DB::connection('live_db')->statement('UPDATE mas_doctors
			SET "userId" = 22
			WHERE id = 27');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 7
			WHERE id = 6');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 8
			WHERE id = 23');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 19
			WHERE id = 17');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 21
			WHERE id = 18');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 22
			WHERE id = 19');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 23
			WHERE id = 20');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 25
			WHERE id = 21');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 27
			WHERE id = 22');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 1
			WHERE id = 32');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 3
			WHERE id = 33');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 4
			WHERE id = 34');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 5
			WHERE id = 35');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 6
			WHERE id = 38');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 7
			WHERE id = 39');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 9
			WHERE id = 41');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 10
			WHERE id = 42');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 11
			WHERE id = 43');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 12
			WHERE id = 44');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 13
			WHERE id = 45');

		\DB::connection('live_db')->statement('UPDATE users
			SET mas_id = 15
			WHERE id = 51');

		\DB::connection('live_db')->statement('UPDATE mas_doctors
			SET "userId" = 20
			WHERE id = 23');

		\DB::connection('live_db')->statement('ALTER TABLE mas_nures 
			ADD COLUMN IF NOT EXISTS user_id integer');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 32
			WHERE id = 1');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 33
			WHERE id = 3');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 34
			WHERE id = 4');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 35
			WHERE id = 5');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 38
			WHERE id = 6');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 39
			WHERE id = 7');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 23
			WHERE id = 8');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 41
			WHERE id = 9');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 42
			WHERE id = 10');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 43
			WHERE id = 11');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 44
			WHERE id = 12');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 45
			WHERE id = 13');

		\DB::connection('live_db')->statement('UPDATE mas_nures
			SET user_id = 51
			WHERE id = 15');

		\DB::connection('live_db')->statement('ALTER TABLE users 
			ADD COLUMN IF NOT EXISTS created_user integer');

		\DB::connection('live_db')->statement('ALTER TABLE users 
			ADD COLUMN IF NOT EXISTS modified_user integer');

		\DB::connection('live_db')->statement('ALTER TABLE users 
			ADD COLUMN IF NOT EXISTS status boolean');

		\DB::connection('live_db')->statement('UPDATE users
			SET status = true');

		\DB::connection('live_db')->statement('ALTER TABLE users DROP COLUMN masters_id');

		\DB::connection('live_db')->statement('update nicu_admission t1
			set discharge_femoral_pulses = t2.nicu_femoral_pulses
			from nicu_admission t2
			where t2."NicuId" = t1."NicuId"');		

		$daycare_antibiotic_list = \DB::connection('live_db')
		->table('antibiotics')
		->select('Antibiotic', 'Name', 'Value', 'DateAdded', 'DateModified')
		->leftjoin('mas_antibiotic', \DB::raw('CAST("antibiotics"."Antibiotic" AS INTEGER)'), "mas_antibiotic.Id")
		->whereNotNull('Antibiotic')
		->whereNotNull('Name')
		->where('Antibiotic', '<>', '')
		->where('Name', '<>', '')
		->get()
		->unique(['Antibiotic']);

		\DB::connection('live_db')->statement("ALTER TABLE antibiotics
			ADD COLUMN IF NOT EXISTS is_updated boolean NOT NULL DEFAULT 'false'");

		foreach ($daycare_antibiotic_list as $key => $value) {

			$antibiotics_drug = \DB::connection('live_db')
			->table('mas_drugivfluid')
			->where('generic_pharmacological_name', $value->Name)
			->where('value', $value->Value)
			->where('anti_status', 1)
			->where('is_deleted', 0)
			->first();

			if (count($antibiotics_drug) > 0) {
				unset($daycare_antibiotic_list[$key]);

				\DB::connection('live_db')
				->table('antibiotics')
				->where('Antibiotic', $value->Antibiotic)
				->where('is_updated', false)
				->update(['Antibiotic'=>$antibiotics_drug->id, 'is_updated'=>true]);
			} else {

				$max_id = \DB::connection('live_db')->select("SELECT MAX(id)+1 as next_value FROM mas_drugivfluid");

				$insert_mas_drug_iv_fluid = array(
					"id"=>$max_id[0]->next_value,
					"generic_pharmacological_name" => $value->Name,
					"value" => $value->Value,
					"status" => true,
					"date_added" => $value->DateAdded,
					"date_modified" => $value->DateModified,
					"user_added" => '6',
					"user_modified" => '6',
					"is_deleted" => false,
					"anti_status" => true
				);

				\DB::connection('live_db')->table('mas_drugivfluid')->insert($insert_mas_drug_iv_fluid);

				\DB::connection('live_db')
				->table('antibiotics')
				->where('Antibiotic', $value->Antibiotic)
				->where('is_updated', false)
				->update(['Antibiotic'=>$max_id[0]->next_value, 'is_updated'=>true]);
			}
		}

		\DB::connection('live_db')->statement("ALTER TABLE antibiotics
			DROP is_updated");

		$medication_list = \DB::connection('live_db')
		->table('discharge_medications')
		->select('discharge_medications.Medication','Name', 'Value', 'generic_name', 'formulation', 'DateAdded', 'DateModified')
		->leftjoin('mas_drugs', "discharge_medications.Medication", "mas_drugs.Id")
		->where('Medication', '<>', 0)->get()->unique('Name');

		\DB::connection('live_db')->statement("ALTER TABLE discharge_medications ADD COLUMN IF NOT EXISTS is_updated boolean NOT NULL DEFAULT 'false'");

		foreach ($medication_list as $key => $value) {

			$mas_drug_data = \DB::connection('live_db')->table('mas_drugivfluid')->where('generic_pharmacological_name', $value->generic_name)
			->where('brand_name', $value->Name)->where('value', $value->Value)->where('type', 'ORAL')->first();

			if (isset($mas_drug_data->id) && $mas_drug_data->id == $value->Medication) {
				echo "---------------";
			} else if (isset($mas_drug_data->id) && $mas_drug_data->id != $value->Medication) {
				echo "!!!!!!!!!!!!";				

				if ($value->formulation == $value->Medication) {
					\DB::connection('live_db')
					->table('discharge_medications')
					->where('Medication', $value->Medication)
					->where('is_updated', false)
					->update(['Medication'=>$mas_drug_data->id, 'formulation'=>$mas_drug_data->id, 'is_updated'=>true]);
				} else {							
					\DB::connection('live_db')
					->table('discharge_medications')
					->where('Medication', $value->Medication)
					->where('is_updated', false)
					->update(['Medication'=>$mas_drug_data->id, 'is_updated'=>true]);	
				}

			} else if (!isset($mas_drug_data->id)) {
				echo "xxxxxxxxxxxxxxx";	

				$max_id = \DB::connection('live_db')->select("SELECT MAX(id)+1 as next_value FROM mas_drugivfluid");

				$insert_mas_drug_iv_fluid = array(
					"id"=>$max_id[0]->next_value,
					"brand_name" => $value->Name,
					"generic_pharmacological_name" => $value->generic_name,
					"value" => $value->Value,
					"status" => true,
					"date_added" => $value->DateAdded,
					"date_modified" => $value->DateModified,
					"user_added" => '6',
					"user_modified" => '6',
					"is_deleted" => false,
					"anti_status" => false,
					"type"=>"ORAL"
				);

				\DB::connection('live_db')->table('mas_drugivfluid')->insert($insert_mas_drug_iv_fluid);

				if ($value->formulation == $value->Medication) {
					\DB::connection('live_db')
					->table('discharge_medications')
					->where('Medication', $value->Medication)
					->where('is_updated', false)
					->update(['Medication'=>$max_id[0]->next_value, 'formulation'=>$max_id[0]->next_value, 'is_updated'=>true]);
				} else {							
					\DB::connection('live_db')
					->table('discharge_medications')
					->where('Medication', $value->Medication)
					->where('is_updated', false)
					->update(['Medication'=>$max_id[0]->next_value, 'is_updated'=>true]);	
				}

			}  

		}

		\DB::connection('live_db')->statement("ALTER TABLE discharge_medications
			DROP is_updated");

		$file = new Filesystem;
		$file->cleanDirectory('storage/framework/sessions');

		exit;
		// echo "<pre>"; print_r('TOTAL FOUND+++++++++++++++++++++++++++++++++++'.$i);
		// echo "<pre>"; print_r('ALTERNATE TOTAL FOUND+++++++++++++++++++++++++++++++++++'.$p);
		// echo "<pre>"; print_r('TOTAL NOT FOUND+++++++++++++++++++++++++++++++++++'.$j); exit;



	}
	public function updateTableSchema($table_name, $missed_col_details, $col_value, $type = '')
	{
		if ($type != '') {
			

		}
		else
		{	
			Schema::connection('live_db')->table($table_name, function($table) use($missed_col_details, $col_value) {
		        if ($missed_col_details->data_type == 'text') {
		        	if (!empty($missed_col_details->column_default)) {
		        		$missed_col_details->column_default = str_replace("'0'::text", '0', $missed_col_details->column_default);
		        		
		        		$table->text($col_value)->default($missed_col_details->column_default)->nullable();
		        	}
		        	else
		        	{
		        		$table->text($col_value)->nullable();
		        	}
		        }
		        elseif ($missed_col_details->data_type == 'character varying') {
		        	if (!empty($missed_col_details->column_default)) {

		        		$missed_col_details->column_default = str_replace("'0'::character varying", '0', $missed_col_details->column_default);
		        		if (!empty($missed_col_details->character_maximum_length)) {

		        			$table->string($col_value, $missed_col_details->character_maximum_length)->default($missed_col_details->column_default);
		        		}
		        		else
		        		{
		        			$table->string($col_value)->default($missed_col_details->column_default);
		        		}
		        	}
		        	else
		        	{
		        		if (!empty($missed_col_details->character_maximum_length)) {

		        			$table->string($col_value, $missed_col_details->character_maximum_length)->nullable();
		        		}
		        		else
		        		{
		        			$table->string($col_value)->nullable();
		        		}
		        	}

		        }
		        elseif ($missed_col_details->data_type == 'integer') {
		        	if (!empty($missed_col_details->column_default)) {

		        		$table->integer($col_value)->default($missed_col_details->column_default);
		        	}
		        	else
		        	{
		        		$table->integer($col_value)->nullable();
		        	}
		        }
		        elseif ($missed_col_details->data_type == 'boolean') {
		        	if (!empty($missed_col_details->column_default)) {
		        		$table->boolean($col_value)->default($missed_col_details->column_default);
		        	}
		        	else
		        	{
		        		$table->boolean($col_value)->nullable();
		        	}
		        }
		        elseif ($missed_col_details->data_type == 'bigint') {
		        	if (!empty($missed_col_details->column_default)) {

		        		$table->bigInteger($col_value)->default($missed_col_details->column_default);
		        	}
		        	else
		        	{
		        		$table->bigInteger($col_value)->nullable();
		        	}
		        }
		        elseif ($missed_col_details->data_type == 'date') {
		        	if (!empty($missed_col_details->column_default)) {

		        		$table->date($col_value)->default($missed_col_details->column_default);
		        	}
		        	else
		        	{
		        		$table->date($col_value)->nullable();
		        	}
		        }
		        elseif ($missed_col_details->data_type == 'double precision') {
		        	if (!empty($missed_col_details->column_default)) {

		        		$table->double($col_value)->default($missed_col_details->column_default);
		        	}
		        	else
		        	{
		        		$table->double($col_value)->nullable();
		        	}
		        }
		        elseif ($missed_col_details->data_type == 'timestamp without time zone') {

		        	$table->timestamp($col_value)->nullable();
		        }
		        elseif ($missed_col_details->data_type == 'time without time zone') {

		        	$table->time($col_value)->nullable();
		        }
		        elseif ($missed_col_details->data_type == 'json') {
		        	
		        	$table->json($col_value)->nullable();
		        }
		        elseif ($missed_col_details->data_type == 'jsonb') {
		        	
		        	$table->jsonb($col_value)->nullable();
		        }
		        // elseif ($missed_col_details->data_type == 'double precision') {
		        	
		        // 	$table->json($col_value)->nullable();
		        // }
		    });
		}
	}

	 /**
     * Split backup record to insert table
     *
     * @param  $data type array
     * @param  $table_name type string
     * return true
     */
    public function backupData($data = array(), $table_name)
    {
    	$initialCount = count((array) $data[0]);
    	$insertCount = round(65000 / $initialCount);
    	$totalCount = count($data);
    	if ($totalCount < $insertCount) {
    		$this->insertRecord($data, $table_name);
    		return true;
    	}
    	else
    	{
    		$completedCount = 0;
    		while ($completedCount <= $totalCount) {
    			$insertArray = array_slice($data, $completedCount, $insertCount);
    			$this->insertRecord($insertArray, $table_name);
    			$completedCount += $insertCount;
    		}
    		return true;
    	}
    }

    /**
     * Insert backup record into table
     *
     * @param  $insertArray type array
     * @param  $table_name type string
     * return true
     */
    public function insertRecord($insertArray = array(), $table_name)
    {
    	if (count($insertArray) > 0) {
    		$insertArray = \SiteHelpers::convert_obj_to_array($insertArray);
    		$res = \DB::connection('live_db')->table($table_name)->insert($insertArray);
    		// echo "<pre>"; print_r($insertArray); exit;
            return true;

    	}
    }

    /**
     * get create table query from table structure
     *
     * @param  $table_name type string
     * return string
     */
    public function getTableCreateStatement($table_name)
    {
		$create_table_query = "SELECT 'CREATE TABLE ' || pn.nspname || '.' || pc.relname || E'(\n' ||
		string_agg(pa.attname || ' ' || pg_catalog.format_type(pa.atttypid, pa.atttypmod) || coalesce(' DEFAULT ' || (
		SELECT pg_catalog.pg_get_expr(d.adbin, d.adrelid) FROM pg_catalog.pg_attrdef d WHERE d.adrelid = pa.attrelid AND d.adnum = pa.attnum AND pa.atthasdef), '') || ' ' || CASE pa.attnotnull WHEN TRUE THEN 'NOT NULL' ELSE 'NULL' END, E',\n') || coalesce((SELECT E',\n' || string_agg('CONSTRAINT ' || pc1.conname || ' ' || pg_get_constraintdef(pc1.oid), E',\n' ORDER BY pc1.conindid) FROM pg_constraint pc1 WHERE pc1.conrelid = pa.attrelid), '') || E');' as create_statement FROM pg_catalog.pg_attribute pa JOIN pg_catalog.pg_class pc ON pc.oid = pa.attrelid AND pc.relname = '".$table_name."' JOIN pg_catalog.pg_namespace pn ON pn.oid = pc.relnamespace AND pn.nspname = 'public' WHERE pa.attnum > 0 AND NOT pa.attisdropped
		GROUP BY pn.nspname, pc.relname, pa.attrelid;";
		return $create_table_query;
    }

    /**
     * create table in live db from interface tale structure
     *
     * @param  $table_name type string
     * return string
     */
    public function createTable($table_name)
    {
		if (!Schema::connection('live_db')->hasTable($table_name)) {
			$create_table_query = $this->getTableCreateStatement($table_name);
			$create_statement = \DB::select($create_table_query);
			$create_query = $create_statement[0]->create_statement;
			$create_table_query = $this->getFormattedQuery($create_query);
			\DB::connection('live_db')->statement($create_table_query);
		}
		return true;
    }

    /**
     * copy table data to live db from interface table
     *
     * @param  $table_name type string
     * return string
     */
    public function copyTableRecords($table_name, $primary_key = '')
    {
		$results = \DB::table($table_name)->get()->toArray();
		if ($primary_key != '') {

		}
		if (count($results) > 0) {
			$this->backupData($results, $table_name);
			// foreach ($results as $key => $value) {

			// 	\DB::connection('live_db')->table($table_name)->insert((array) $value);
			// }
		}
		return true;
    }
    /**
     * copy table data to live db from interface table with check old records in live DB table
     *
     * @param  $table_name type string
     * 
     * @param  $verify_field type string
     * 
     * @param  $primary_id type string
     * return string
     */
    public function copyTableRecordsWithCheckOld($table_name, $verify_field, $primary_id)
    {
		$interface_results = \DB::table($table_name)->get()->toArray();
		foreach ($interface_results as $key => $value) {
			$current_value = (array) $value;
			$value_to_verify = $current_value[$verify_field];
				
			$check_with_live_table = \DB::connection('live_db')->table($table_name)->where($verify_field, $value_to_verify)->first();
			$live_table_record = (array) $check_with_live_table;
			if (!isset($live_table_record[$verify_field])) {

				unset($current_value[$primary_id]);
				
				// \DB::connection('live_db')->table($table_name)->insert($current_value);

			}
		}
		return true;
    }

    /**
     * Format Query to excutable and fixing query error
     *
     * @param  $create_query type string
     * return string
     */
    public function getFormattedQuery($create_query)
    {
		$create_query_array = explode(',', $create_query);
		$log_hdr_id_occurance = false;
		foreach ($create_query_array as $query_key => $query_value) {
			$trigger_occurance = false;
			
			$query_array = explode(' ', $query_value);
			if (count($query_array) > 0) {
				foreach ($query_array as $qury_key => $qury_value) {
					// echo "<pre>"; print_r($qury_value);
					$qury_value=trim(preg_replace('/\s\s+/', ' ', $qury_value));

					if (($qury_key == 2 || $qury_key == 0) && $qury_value != 'NULL' && $qury_value != 'NULL);' && $qury_value != 'DEFAULT' && $qury_value != 'PRIMARY' && $qury_value != 'CREATE' && $qury_value != 'CONSTRAINT' && $qury_value != 'NOT' && $qury_value != 'FOREIGN' && $qury_value != 'CHECK' && $qury_value != 'UNIQUE') {
						if(preg_match('/[A-Z]/', $qury_value) || $qury_value == 'default'){
							if (preg_match('/(public)/', $qury_value)) {
								$upper_case_array = explode('(', $qury_value);
								if (isset($upper_case_array[1])) {
									$upper_case_array[1] = '"'.trim(preg_replace('/\s\s+/', ' ', $upper_case_array[1])).'"';
								}
								$query_array[$qury_key] = implode('(', $upper_case_array);
							}
							else
							{
								$query_array[$qury_key] = '"'.$qury_value.'"';
							}
							
						}
					}

					if (preg_match('/(log_hdr_id)/', $qury_value)) {
						if (!$log_hdr_id_occurance) {
							
							if (isset($query_array[$qury_key+1])) {

								$query_array[$qury_key+1] = 'integer';
							}
							$log_hdr_id_occurance = true;
						}
					}
					if (preg_match('/(config_group_id)/', $qury_value)) {
						if (!$log_hdr_id_occurance) {
							
							if (isset($query_array[$qury_key+1])) {

								$query_array[$qury_key+1] = 'integer';
							}
							$log_hdr_id_occurance = true;
						}
					}
					if (preg_match('/(ref_loc_master_id)/', $qury_value)) {
						if (!$log_hdr_id_occurance) {
							
							if (isset($query_array[$qury_key+1])) {

								$query_array[$qury_key+1] = 'integer';
							}
							$log_hdr_id_occurance = true;
						}
					}
					if (preg_match('/(nextval)/', $qury_value)) {

						$query_array[$qury_key] = 'SERIAL';
						if (isset($query_array[$qury_key-1])) {
							unset($query_array[$qury_key-1]);
						}
						if (isset($query_array[$qury_key-2])) {
							unset($query_array[$qury_key-2]);
						}
						if (isset($query_array[$qury_key+1])) {
							unset($query_array[$qury_key+1]);
						}
						if (isset($query_array[$qury_key+2])) {
							unset($query_array[$qury_key+2]);
						}
					}								
				}
				$sub_query = implode(' ', $query_array);

				if (!preg_match('/(TRIGGER)/', $sub_query)) {

					$create_query_array[$query_key] = $sub_query; 
				}
				else
				{
					unset($create_query_array[$query_key]);
				}
				
			}
		}
		
		$create_query = implode(',', $create_query_array);
		if ((substr($create_query, -1) != ')' && substr($create_query, -2) != ');') || substr($create_query, -2) == '))') {
			$create_query .= ')';
		}

		return $create_query;
    }
    public function alterSequences($tables)
    {
    	if (count($tables) > 0) {
    		foreach ($tables as $table_key => $table) {
    			$sequence_info = \DB::connection('live_db')->select("SELECT table_name, column_name, column_default from information_schema.columns where table_name='".$table."' and column_default ilike '%nextval%';");
    			if (isset($sequence_info[0]->table_name) && isset($sequence_info[0]->column_name) && !empty($sequence_info[0]->table_name) && !empty($sequence_info[0]->column_name)) {
    				if ($table == 'mas_admissionmode') {
    					$seq_name = "mas_admissionmode_id_seq";
	    				
	    				$sequence_info = \DB::connection('live_db')->select("SELECT setval('public.mas_admissionmode_id_seq', COALESCE((SELECT MAX(\"Id\")+1 FROM mas_admissionmode), 1), false);");
    				}
    				else
    				{
	    				$seq_name = $sequence_info[0]->table_name.'_'.$sequence_info[0]->column_name."_seq";
	    				if (preg_match('/[A-Z]/', $seq_name)) {
	    					
	    					$sequence_info = \DB::connection('live_db')->select("SELECT setval('public.\"".$seq_name."\"', COALESCE((SELECT MAX(\"".$sequence_info[0]->column_name."\")+1 FROM ".$sequence_info[0]->table_name."), 1), false);");
	    					// $next_seq = \DB::connection('live_db')->select("select nextval('".$seq_name."')");
	    				}
	    				else
	    				{

	    					$sequence_info = \DB::connection('live_db')->select("SELECT setval('".$seq_name."', COALESCE((SELECT MAX(".$sequence_info[0]->column_name.")+1 FROM ".$sequence_info[0]->table_name."), 1), false);");
	    					// $next_seq = \DB::connection('live_db')->select("select nextval('".$seq_name."')");
	    				}
    				}

    			}
    			
    		}
    	}
    }
}

