$(document).ready(function() { 

	var add_more_type_1 = [];
	var add_more_type_2 = [];
	var add_more_type_3 = [];

	// Mother Registration
	if ($('form').hasClass('mother_registration_form')) {
		var mother_registration_option_type_1 = ['.mother_registration_form select[name="MotherTitle"]', '.mother_registration_form select[name="PartnerTitle"]'];

		var mother_registration_option_type_2 = ['.mother_registration_form select[name="education_status"]', '.mother_registration_form select[name="occupation_status"]', '.mother_registration_form select[name="partner_education_status"]', '.mother_registration_form select[name="partner_occupation_status"]'];

		select_value_type1(mother_registration_option_type_1);

		select_value_type1(mother_registration_option_type_2);
	}

	// Baby Registration
	if ($('form').is('#baby_reg_form')) {
		var baby_registration_option_type_1 = ['#baby_reg_form select[name="MultiplePregnancyType"]', '#baby_reg_form select[name="BirthOrder"]', '#baby_reg_form select[name="Sex"]', '#baby_reg_form select[name^="neonatal_consultant["]', '#baby_reg_form select[name="obstetric_consultant"]', '#baby_reg_form select[name="paediatric_surgeon"]'];

		var baby_registration_option_type_3 = ['#baby_reg_form select[name="TOB_TIME"]', '#baby_reg_form select[name="TOB_MINS"]', '#baby_reg_form select[name="TOB_AM"]', '#baby_reg_form select[name="BabyBloodGroup"]', '#baby_reg_form select[name="MotherBloodGroup"]'];

		add_more_type_1 = ['#baby_reg_form select[name^="neonatal_consultant["]'];

		select_value_type1(baby_registration_option_type_1);

		select_value_type3(baby_registration_option_type_3);
	}

	// Neonatal Proforma
	if ($('form').is('#neonatalPerforma-form')) {
		var proforma_registration_option_type_1 = ['#neonatalPerforma-form select[name="transfer_status"]', '#neonatalPerforma-form select[name="MotherTitle"]', '#neonatalPerforma-form select[name="PartnerTitle"]', '#neonatalPerforma-form select[name^="Delivery["]', '#neonatalPerforma-form select[name^="Gender["]', '#neonatalPerforma-form select[name^="Health["]', '#neonatalPerforma-form select[name="Conception"]', '#neonatalPerforma-form select[name="SteroidCourse"]', '#neonatalPerforma-form select[name="CommentOnLiquor"]', '#neonatalPerforma-form select[name="DurationOfROM"]', '#neonatalPerforma-form select[name="TimeofLastDose"]', '#neonatalPerforma-form select[name="ModeOfDelivery"]', '#neonatalPerforma-form select[name^="resusciatation_drugs["]', '#neonatalPerforma-form select[name="CentralPulses"]', '#neonatalPerforma-form select[name="PeripheralPulses"]', '#neonatalPerforma-form select[name="CentralPulses"]', '#neonatalPerforma-form select[name^="Scalp["]', '#neonatalPerforma-form select[name="Eyes"]', '#neonatalPerforma-form select[name="Ears"]', '#neonatalPerforma-form select[name="Nostrils"]', '#neonatalPerforma-form select[name="Umbilicus"]', '#neonatalPerforma-form select[name="HernialOrifices"]', '#neonatalPerforma-form select[name="FemoralPulses"]', '#neonatalPerforma-form select[name="Genitalia"]', '#neonatalPerforma-form select[name="RtUL"]', '#neonatalPerforma-form select[name="RtLL"]', '#neonatalPerforma-form select[name="LtUL"]', '#neonatalPerforma-form select[name="LtLL"]', '#neonatalPerforma-form select[name="Skin"]', '#neonatalPerforma-form select[name="BoundingPulses"]', '#neonatalPerforma-form select[name="LevelOfConsciousness"]', '#neonatalPerforma-form select[name="Booking"]', '#neonatalPerforma-form select[name="PlaceofSupervision"]'];

		var proforma_registration_option_type_2 = ['#neonatalPerforma-form select[name="education_status"]', '#neonatalPerforma-form select[name="occupation_status"]', '#neonatalPerforma-form select[name="partner_education_status"]', '#neonatalPerforma-form select[name="partner_occupation_status"]', '#neonatalPerforma-form select[name^="duration_unit["]'];

		var proforma_registration_option_type_3 = ['#neonatalPerforma-form select[name="TOB_TIME"]', '#neonatalPerforma-form select[name="TOB_MINS"]', '#neonatalPerforma-form select[name="TOB_AM"]', '#neonatalPerforma-form select[name="TEST_TIME"]', '#neonatalPerforma-form select[name="TEST_MINS"]', '#neonatalPerforma-form select[name="TEST_AM"]', '#neonatalPerforma-form select[name="BabyBloodGroup"]', '#neonatalPerforma-form select[name="Sex"]', '#neonatalPerforma-form select[name^="Problems["]', '#neonatalPerforma-form select[name="TypeofART"]', '#neonatalPerforma-form select[name="EmbryoTransfer"]', '#neonatalPerforma-form select[name="MotherBloodGroup"]', '#neonatalPerforma-form select[name="Colour1"]', '#neonatalPerforma-form select[name="Colour5"]', '#neonatalPerforma-form select[name="Colour10"]', '#neonatalPerforma-form select[name="Colour15"]', '#neonatalPerforma-form select[name="Colour20"]', '#neonatalPerforma-form select[name="HR1"]', '#neonatalPerforma-form select[name="HR5"]', '#neonatalPerforma-form select[name="HR10"]', '#neonatalPerforma-form select[name="HR15"]', '#neonatalPerforma-form select[name="HR20"]', '#neonatalPerforma-form select[name="Reflex1"]', '#neonatalPerforma-form select[name="Reflex5"]', '#neonatalPerforma-form select[name="Reflex10"]', '#neonatalPerforma-form select[name="Reflex15"]', '#neonatalPerforma-form select[name="Reflex20"]', '#neonatalPerforma-form select[name="Tone1"]', '#neonatalPerforma-form select[name="Tone5"]', '#neonatalPerforma-form select[name="Tone10"]', '#neonatalPerforma-form select[name="Tone15"]', '#neonatalPerforma-form select[name="Tone20"]', '#neonatalPerforma-form select[name="Respiration1"]', '#neonatalPerforma-form select[name="Respiration5"]', '#neonatalPerforma-form select[name="Respiration10"]', '#neonatalPerforma-form select[name="Respiration15"]', '#neonatalPerforma-form select[name="Respiration20"]', '#neonatalPerforma-form select[name="Presentation"]', '#neonatalPerforma-form select[name="FoetalDistress"]', '#neonatalPerforma-form select[name="CordBloodGas"]', '#neonatalPerforma-form select[name="GastricAspirate"]', '#neonatalPerforma-form select[name="SiteofMurmur"]'];

		add_more_type_1 = ['#neonatalPerforma-form select[name^="Delivery["]', '#neonatalPerforma-form select[name^="Gender["]', '#neonatalPerforma-form select[name^="Health["]', '#neonatalPerforma-form select[name^="duration_unit["]', '#neonatalPerforma-form select[name^="resusciatation_drugs["]', '#neonatalPerforma-form select[name^="Scalp["]'];

		add_more_type_3 = ['#neonatalPerforma-form select[name^="Problems["]'];

		select_value_type1(proforma_registration_option_type_1);

		select_value_type2(proforma_registration_option_type_2);

		select_value_type3(proforma_registration_option_type_3);
	}

	// Nurse Daily Entry Form
	if ($('form').is('#nurse-daycare')) {
		var nurse_daily_entry_option_type_1 = ['#nurse-daycare select[name="Size"]', '#nurse-daycare select[name^="F_Product["]', '#nurse-daycare select[name="PiccSite"]', '#nurse-daycare select[name="PacSite"]'];

		var nurse_daily_entry_option_type_3 = ['#nurse-daycare select[name="DayTime"]', '#nurse-daycare select[name="DayTime_MINS"]', '#nurse-daycare select[name="DayTime_AM"]'];

		add_more_type_1 = ['#nurse-daycare select[name^="F_Product["]'];

		select_value_type1(nurse_daily_entry_option_type_1);

		select_value_type3(nurse_daily_entry_option_type_3);
	}

	// Create Nurse Sheets
	if ($('div').hasClass('nurse-sheet-hour-wise-sheet')) {
		var nurse_sheet_option_type_1 = ['#nurse-form select[name="dcp"]', '#nurse-form select[name="hemolysis"]', '.nurse-sheet-hour-wise-sheet select[name^="F_Product["]', '.nurse-sheet-hour-wise-sheet select[name="gastric_aspirate"]', '.nurse-sheet-hour-wise-sheet select[name="stools_nature"]', '.nurse-sheet-hour-wise-sheet select[name="blood_gas_type"]', '.nurse-sheet-date-time select[name="time_hour"]', '.nurse-sheet-date-time select[name="time_min"]', '.nurse-sheet-date-time select[name="time_session"]'];

		var nurse_sheet_option_type_3 = ['.nurse-sheet-hour-wise-sheet select[name="time_hour"]', '.nurse-sheet-hour-wise-sheet select[name="time_min"]', '.nurse-sheet-hour-wise-sheet select[name="time_session"]'];

		add_more_type_1 = ['.nurse-sheet-hour-wise-sheet select[name^="F_Product["]'];

		select_value_type1(nurse_sheet_option_type_1);

		select_value_type3(nurse_sheet_option_type_3);
	}

	// Edit Nurse Sheets
	if ($('div').hasClass('nurse-sheet-edit')) {
		var nurse_sheet_option_type_1 = ['#nurse-form select[name="dcp"]', '#nurse-form select[name="hemolysis"]', '.nurse-sheet-edit select[name^="bp_method["]', '.nurse-sheet-edit select[name^="color["]', '.nurse-sheet-edit select[name^="phototherapy_eyes["]', '.nurse-sheet-edit select[name^="added_nurse["]', '.nurse-sheet-edit select[name^="mode_of_ventilation["]', '.nurse-sheet-edit select[name^="mode_of_ventilation_invasive["]', '.nurse-sheet-edit select[name^="cpap_interface_change["]', '.nurse-sheet-edit select[name^="air_entry_right["]', '.nurse-sheet-edit select[name^="air_entry_left["]', '.nurse-sheet-edit select[name^="type_of_feeds["]', '.nurse-sheet-edit select[name^="route_of_feeds["]', '.nurse-sheet-edit select[name^="gastric_aspirate["]', '.nurse-sheet-edit select[name^="stools_nature["]', '.nurse-sheet-edit select[name^="Transfusion["]', '.nurse-sheet-edit select[name^="F_Product["]', '.nurse-sheet-edit select[name^="blood_gas_type["]'];

		var nurse_sheet_option_type_3 = ['.nurse-sheet-edit select[name^="type_of_care["]', '.nurse-sheet-edit select[name^="activity["]', '.nurse-sheet-edit select[name^="position["]', '.nurse-sheet-edit select[name^="work_of_breathing["]'];

		add_more_type_1 = ['.nurse-sheet-edit select[name^="F_Product["]'];

		select_value_type1(nurse_sheet_option_type_1);

		select_value_type3(nurse_sheet_option_type_3);
	}

	// OP Registration
	if ($('form').is('#op-form')) {

		var op_option_type_1 = ['#op-form select[name="MotherTitle"]', '#op-form select[name="education_status"]', '#op-form select[name="occupation_status"]', '#op-form select[name="PartnerTitle"]', '#op-form select[name="partner_education_status"]', '#op-form select[name="partner_occupation_status"]', '#op-form select[name="AppointmentType"]', '#op-form select[name="Outcome"]', '#op-form select[name="SeenBy"]', '#op-form select[name^="M_Dose["]', '#op-form select[name^="M_Frequency["]', '#op-form select[name^="M_Duration["]', '#op-form select[name="Immunization"]', '#op-form select[name="Schedule"]', '#op-form select[name^="Vaccine["]', '#op-form select[name="BirthOrder"]', '#op-form select[name="Sex"]'];

		var op_option_type_3 = ['#op-form select[name="OpTime"]', '#op-form select[name="OpTime_MINS"]', '#op-form select[name="OpTime_AM"]', '#op-form select[name="TOB_TIME"]', '#op-form select[name="TOB_MINS"]', '#op-form select[name="TOB_AM"]', '#op-form select[name="BabyBloodGroup"]', '#op-form select[name="mother_blood_group"]', '#op-form select[name="hospital_name"]', '#op-form select[name="review_time"]', '#op-form select[name="review_min"]', '#op-form select[name="review_session"]'];
		
		add_more_type_1 = ['#op-form select[name^="M_Dose["]', '#op-form select[name^="vaccine_brand_name"]', '#op-form select[name^="M_Frequency["]', '#op-form select[name^="M_Duration["]', '#op-form select[name^="Vaccine["]'];

		var op_option_type_2 = ['#op-form select[name^="vaccine_brand_name"]'];

		select_value_type1(op_option_type_1);

		select_value_type2(op_option_type_2);
		
		select_value_type3(op_option_type_3);
	}

	//  Pediatric Op Registration
	if ($('form').is('#pediatric-op-form')) {

		var op_option_type_1 = ['#pediatric-op-form select[name="seen_by"]', '#pediatric-op-form select[name^="M_Dose["]', '#pediatric-op-form select[name^="M_Frequency["]', '#pediatric-op-form select[name^="M_Duration["]', '#pediatric-op-form select[name="immunization"]', '#pediatric-op-form select[name="schedule"]', '#pediatric-op-form select[name^="Vaccine["]', '#pediatric-op-form select[name="Sex"]'];

		var op_option_type_3 = ['#pediatric-op-form select[name="op_hours"]', '#pediatric-op-form select[name="op_mins"]', '#pediatric-op-form select[name="op_session"]', '#pediatric-op-form select[name="hospital_name"]', '#pediatric-op-form select[name="review_time"]', '#pediatric-op-form select[name="review_min"]', '#pediatric-op-form select[name="review_session"]'];
		
		add_more_type_1 = ['#pediatric-op-form select[name^="M_Dose["]', '#pediatric-op-form select[name^="vaccine_brand_name"]', '#pediatric-op-form select[name^="M_Frequency["]', '#pediatric-op-form select[name^="M_Duration["]', '#pediatric-op-form select[name^="Vaccine["]'];

		var op_option_type_2 = ['#pediatric-op-form select[name^="vaccine_brand_name"]'];

		select_value_type1(op_option_type_1);

		select_value_type2(op_option_type_2);
		
		select_value_type3(op_option_type_3);
	}

	// Echocardiography
	if ($('form').is('#echocardiography')) {
		var echo_option_type_1 = ['#echocardiography select[name="SeenBy"]', '#echocardiography select[name="Outcome"]'];

		select_value_type1(echo_option_type_1);
	}

	// Echocardiography
	if ($('form').is('#ultrasonography-form')) {
		var ultra_option_type_1 = ['#ultrasonography-form select[name="SeenBy"]'];

		select_value_type1(ultra_option_type_1);
	}

	// Culture Registry
	if ($('form').is('#culture-registry')) {
		var culture_option_type_1 = ['#culture-registry select[name="SeenBy"]', '#culture-registry select[name="Specimen"]', '#culture-registry select[name="Isolate"]', '#culture-registry select[name="AmoxycillinClavulanate"]', '#culture-registry select[name="AmpicillinSulbactum"]', '#culture-registry select[name="Methicillin"]', '#culture-registry select[name="PiperacillinTazobactum"]', '#culture-registry select[name="Carbenicillin"]', '#culture-registry select[name="PenicillinG"]', '#culture-registry select[name="Cefotaxime"]', '#culture-registry select[name="Ceftriaxone"]', '#culture-registry select[name="Cefuroxime"]', '#culture-registry select[name="Cefazolin"]', '#culture-registry select[name="Cefepime"]', '#culture-registry select[name="Cefoxitin"]', '#culture-registry select[name="Cefpodoxime"]', '#culture-registry select[name="Cefaclor"]', '#culture-registry select[name="Cefixime"]', '#culture-registry select[name="Cefoperazone"]', '#culture-registry select[name="Ceftazidime"]', '#culture-registry select[name="Aztreonam"]', '#culture-registry select[name="Imipenem"]', '#culture-registry select[name="Meropenem"]', '#culture-registry select[name="Faropenem"]', '#culture-registry select[name="Ertapenem"]', '#culture-registry select[name="Amikacin"]', '#culture-registry select[name="Gentamicin"]', '#culture-registry select[name="Tobramycin"]', '#culture-registry select[name="Netillin"]', '#culture-registry select[name="Azithromycin"]', '#culture-registry select[name="Erythromycin"]', '#culture-registry select[name="Ciprofloxacin"]', '#culture-registry select[name="Levofloxacin"]', '#culture-registry select[name="Ofloxacin"]', '#culture-registry select[name="Norfloxacin"]', '#culture-registry select[name="CoTrimoxazole"]', '#culture-registry select[name="Chloramphenicol"]', '#culture-registry select[name="Doxycycline"]', '#culture-registry select[name="Tetracycline"]', '#culture-registry select[name="Vancomycin"]', '#culture-registry select[name="Teicoplanin"]', '#culture-registry select[name="Colistin"]', '#culture-registry select[name="PolymyxinB"]', '#culture-registry select[name="Clindamycin"]', '#culture-registry select[name="Linezolid"]', '#culture-registry select[name="NalidixicAcid"]', '#culture-registry select[name="Nitrofurantoin"]', '#culture-registry select[name="Tigecycline"]'];

		select_value_type1(culture_option_type_1);
	}

	// Quality Indicator
	if ($('form').is('#quality-indicator-form')) {
		var quality_option_type_1 = ['#quality-indicator-form select[name="max_grade_rt"]', '#quality-indicator-form select[name="max_grade_lt"]', '#quality-indicator-form select[name="nec_max_stage"]'];

		var quality_option_type_3 = ['#quality-indicator-form select[name="mode_of_delivery"]', '#quality-indicator-form select[name="medication_details"]', '#quality-indicator-form select[name="res_support_type"]', '#quality-indicator-form select[name="gram_positive_culture1"]', '#quality-indicator-form select[name="gram_negative_culture1"]', '#quality-indicator-form select[name="fungus_culture1"]', '#quality-indicator-form select[name="gram_positive_culture2"]', '#quality-indicator-form select[name="gram_negative_culture2"]', '#quality-indicator-form select[name="fungus_culture2"]', '#quality-indicator-form select[name="gram_positive_culture3"]', '#quality-indicator-form select[name="gram_negative_culture3"]', '#quality-indicator-form select[name="fungus_culture3"]', '#quality-indicator-form select[name="outcome_result"]'];

		select_value_type1(quality_option_type_1);

		select_value_type3(quality_option_type_3);
	}

	// NICU Report
	if ($('form').is('#nicu-report')) {
		var nicu_report_option_type_1 = ['#nicu-report select[name="Sex"]', '#nicu-report select[name="TypeOfCare"]', '#nicu-report select[name="birth_status"]', '#nicu-report select[name="SeenBy"]', '#nicu-report select[name="Status"]', '#nicu-report select[name="hospital_name"]'];

		select_value_type1(nicu_report_option_type_1);
	}

	// OP Report
	if ($('form').is('#op-report')) {
		var op_report_option_type_1 = ['#op-report select[name="Sex"]', '#op-report select[name="Outcome"]', '#op-report select[name="SeenBy"]', '#op-report select[name="AppointmentType"]', '#op-report select[name="hospital_name"]'];

		select_value_type1(op_report_option_type_1);
	}

	// Newborn Report
	if ($('form').is('#nb-report')) {
		var nb_report_option_type_1 = ['#nb-report select[name="Sex"]', '#nb-report select[name="SeenBy"]', '#nb-report select[name="hospital_name"]'];

		select_value_type1(nb_report_option_type_1);
	}

	// Birth Report
	if ($('form').is('#birth-report')) {
		var birth_report_option_type_1 = ['#birth-report select[name="Sex"]', '#birth-report select[name="Status"]', '#birth-report select[name="SeenBy"]', '#birth-report select[name="birth_status"]', '#birth-report select[name="hospital_name"]'];

		select_value_type1(birth_report_option_type_1);
	}

	// Echocardiography List Report
	if ($('form').is('#echo-report')) {
		var echo_report_option_type_1 = ['#echo-report select[name="Sex"]', '#echo-report select[name="SeenBy"]', '#echo-report select[name="birth_status"]', '#echo-report select[name="hospital_name"]'];

		select_value_type1(echo_report_option_type_1);
	}

	// Cranial Ultrasonography Report
	if ($('form').is('#ultra-report')) {
		var nicu_report_option_type_1 = ['#ultra-report select[name="Sex"]', '#ultra-report select[name="SeenBy"]', '#ultra-report select[name="birth_status"]', '#ultra-report select[name="hospital_name"]'];

		select_value_type1(nicu_report_option_type_1);
	}

	// OP Activity Report
	if ($('form').is('#opactivity-report')) {
		var opactivity_report_option_type_1 = ['#opactivity-report select[name="Sex"]', '#opactivity-report select[name="Outcome"]', '#opactivity-report select[name="SeenBy"]', '#opactivity-report select[name="AppointmentType"]', '#opactivity-report select[name="hospital_name"]'];

		select_value_type1(opactivity_report_option_type_1);
	}

	// Ballard Score
	if ($('form').is('#ballard-form')) {
		var ballard_report_option_type_3 = ['#ballard-form select[name="Examiner"]'];

		select_value_type1(ballard_report_option_type_3);
	}

	// Glucose Rate Calculator
	if ($('form').is('#glucose-rate-calculator-form')) {
		var glucose_rate_calculator_type_3 = ['#glucose-rate-calculator-form select[name="Perml"]'];

		select_value_type1(glucose_rate_calculator_type_3);
	}

	// Chart
	if ($('div').hasClass('nurse-chart-sheet')) {
		var nurse_chart_option_type_1 = ['.nurse-chart-sheet select[name="vendilation_mode"]'];
		
		var nurse_chart_option_type_3 = ['.nurse-chart-sheet #nurse-chart-date-filter'];

		select_value_type1(nurse_chart_option_type_1);

		select_value_type3(nurse_chart_option_type_3);
	}

	// Postnatal Admission
	if ($('form').hasClass('post-admission-form')) {
		var postnatal_option_type_1 = ['.post-admission-form select[name="typeofcare"]', '.post-admission-form select[name="admitted_from"]', '.post-admission-form select[name="mode"]', '.post-admission-form select[name="nicu_umbilicus"]', '.post-admission-form select[name="nicu_herina"]', '.post-admission-form select[name="nicu_activity"]', '.post-admission-form select[name="sepsisscreen"]', '.post-admission-form select[name^="ivantibiotic["]', '.post-admission-form select[name="enteral_feeding"]'];
		
		var postnatal_option_type_3 = ['.post-admission-form select[name="admission_time_hour"]', '.post-admission-form select[name="admission_time_mins"]', '.post-admission-form select[name="admission_time_session"]', '.post-admission-form select[name="surgeon"]', '.post-admission-form select[name="seenby"]', '.post-admission-form select[name="hospital_name"]', '.post-admission-form select[name="nicu_cry"]', '.post-admission-form select[name="initialbloodgas"]', '.post-admission-form select[name="initialxray"]', '.post-admission-form select[name="pdiscussion_hrs"]', '.post-admission-form select[name="pdiscussion_min"]', '.post-admission-form select[name="pdiscussion_session"]'];

		add_more_type_1 = ['.post-admission-form select[name^="IVAntibiotic["]'];

		select_value_type1(postnatal_option_type_1);

		select_value_type3(postnatal_option_type_3);
	}

	// Postnatal Daycare
	if ($('form').is('#postnatal_daycare_form')) {
		var post_daycare_option_type_1 = ['#postnatal_daycare_form select[name="SeenBy"]', '#postnatal_daycare_form select[name="Activity"]', '#postnatal_daycare_form select[name="postnatal_sepsis"]', '#postnatal_daycare_form select[name^="postnatal_organism["]'];

		var post_daycare_option_type_3 = ['#postnatal_daycare_form select[name="Dayhours"]', '#postnatal_daycare_form select[name="Daymins"]', '#postnatal_daycare_form select[name="Dayam_pm"]', '#postnatal_daycare_form select[name^="postnatal_other_drugs["]'];

		add_more_type_1 = ['#postnatal_daycare_form select[name^="postnatal_organism["]'];

		add_more_type_3 = ['#postnatal_daycare_form select[name^="postnatal_other_drugs["]'];

		select_value_type1(post_daycare_option_type_1);

		select_value_type3(post_daycare_option_type_3);
	}

	// Problem Based Daycare
	if ($('form').is('#problem_base_daycare')) {
		var post_problem_based_daycare_option_type_4 = ['#problem_base_daycare select'];

		select_value_type4(post_problem_based_daycare_option_type_4);
	}

	// Postnatal Discharge Details
	if ($('form').hasClass('postnatal-discharge-form')) {
		var post_discharge_option_type_1 = ['.postnatal-discharge-form select[name="schedule"]', '.postnatal-discharge-form select[name^="M_Dose["]', '.postnatal-discharge-form select[name^="M_Frequency["]', '.postnatal-discharge-form select[name^="M_Duration["]', '.postnatal-discharge-form select[name="discharge_eyes"]', '.postnatal-discharge-form select[name="feeding_at_discharge"]'];

		var post_discharge_option_type_3 = ['.postnatal-discharge-form select[name="discharge_status"]', '.postnatal-discharge-form select[name="appoinment_hrs"]', '.postnatal-discharge-form select[name="appoinment_min"]', '.postnatal-discharge-form select[name="appoinment_session"]', '.postnatal-discharge-form select[name="appoinment_session"]', '.postnatal-discharge-form select[name^="procedures["]'];

		add_more_type_1 = ['.postnatal-discharge-form select[name^="M_Dose["]', '.postnatal-discharge-form select[name^="M_Frequency["]', '.postnatal-discharge-form select[name^="M_Duration["]'];

		add_more_type_3 = ['.postnatal-discharge-form select[name^="procedures["]'];

		select_value_type1(post_discharge_option_type_1);

		select_value_type3(post_discharge_option_type_3);
	}

	// NICU Admission
	if ($('form').hasClass('nicu-admission-form') && !($('.tab-pane.active').is('#dischargeform') || $('.tab-pane.active').is('#Checkform'))) {
		var nicu_admission_option_type_1 = ['.nicu-admission-form select[name="AdmissionTime"]', '.nicu-admission-form select[name="room_id"]', '.nicu-admission-form select[name="SurfactantGiven"]', '.nicu-admission-form select[name="SurfactantType"]', '.nicu-admission-form select[name="AdmittedFrom"]', '.nicu-admission-form select[name="Mode"]', '.nicu-admission-form select[name="nicu_retractions"]', '.nicu-admission-form select[name="nicu_airentry"]', '.nicu-admission-form select[name="ChestMovement"]', '.nicu-admission-form select[name="nicu_central_pulses"]', '.nicu-admission-form select[name="nicu_peripheral_pulses"]', '.nicu-admission-form select[name="nicu_femoral_pulses"]', '.nicu-admission-form select[name="nicu_s1s2"]', '.nicu-admission-form select[name="nicu_murmur"]', '.nicu-admission-form select[name="CFT"]', '.nicu-admission-form select[name="nicu_color"]', '.nicu-admission-form select[name="nicu_abdomen"]', '.nicu-admission-form select[name="nicu_bowel_sounds"]', '.nicu-admission-form select[name="nicu_umbilicus"]', '.nicu-admission-form select[name="nicu_hepatomegaly"]', '.nicu-admission-form select[name="nicu_splenomegaly"]', '.nicu-admission-form select[name="nicu_herina"]', '.nicu-admission-form select[name="nicu_anteriorfontanelle"]', '.nicu-admission-form select[name="nicu_activity"]', '.nicu-admission-form select[name="Tone"]', '.nicu-admission-form select[name="nicu_seizures"]', '.nicu-admission-form select[name="nicu_neonatalreflexes"]', '.nicu-admission-form select[name="SepsisScreen"]', '.nicu-admission-form select[name^="IVAntibiotic["]', '.nicu-admission-form select[name="NBM"]', '.nicu-admission-form select[name="MBP"]', '.nicu-admission-form select[name="LowestTemperature"]', '.nicu-admission-form select[name="Po2Fio2Ratio"]', '.nicu-admission-form select[name="LowestSerumPh"]', '.nicu-admission-form select[name="MultipleSeizures"]', '.nicu-admission-form select[name="UrineOutput"]', '.nicu-admission-form select[name="BWeight"]', '.nicu-admission-form select[name="SgaLessThan3rdPercentile"]', '.nicu-admission-form select[name="Apgar5Mins"]', '.nicu-admission-form select[name="TimeOfDiscussion"]', '.nicu-admission-form select[name="TimeOfDiscussion_MINS"]', '.nicu-admission-form select[name="TimeOfDiscussion_AM"]', '.nicu-admission-form select[name="room_id"]', '.nicu-admission-form select[name="bed_id"]', '.nicu-admission-form select[name^="SeenBy["]'];

		var nicu_admission_option_type_3 = ['.nicu-admission-form select[name="AdmissionTime"]', '.nicu-admission-form select[name="AdmissionTime_MINS"]', '.nicu-admission-form select[name="AdmissionTime_AM"]', '.nicu-admission-form select[name="TypeOfCare"]', '.nicu-admission-form select[name="Surgeon"]', '.nicu-admission-form select[name="hospital_name"]', '.nicu-admission-form select[name^="Problems["]', '.nicu-admission-form select[name^="Complication["]', '.nicu-admission-form select[name="TimeOfAdministration"]', '.nicu-admission-form select[name="TimeOfAdministration_MINS"]', '.nicu-admission-form select[name="TimeOfAdministration_AM"]', '.nicu-admission-form select[name="nicu_genitalia"]', '.nicu-admission-form select[name="nicu_pupils"]', '.nicu-admission-form select[name="nicu_cry"]', '.nicu-admission-form select[name="InitialBloodGas"]', '.nicu-admission-form select[name="age_hours"]', '.nicu-admission-form select[name="age_mins"]', '.nicu-admission-form select[name="InitialXray"]'];

		add_more_type_1 = ['.nicu-admission-form select[name^="IVAntibiotic["]', '.nicu-admission-form select[name^="SeenBy["]'];

		add_more_type_3 = ['.nicu-admission-form select[name^="Problems["]', '.nicu-admission-form select[name^="Complication["]'];

		select_value_type1(nicu_admission_option_type_1);

		select_value_type3(nicu_admission_option_type_3);

	}

	// NICU Daycare
	if ($('form').is('#daycare-form')) {

		var nicu_daycare_option_type_1 = ['#daycare-form select[name="Care"]', '#daycare-form select[name="Ventilation_choose"]', '#daycare-form select[name="TypeOfBloodGas"]', '#daycare-form select[name="Size"]', '#daycare-form select[name="CentralPulses"]', '#daycare-form select[name="PeripheralPulses"]', '#daycare-form select[name="FemoralPulses"]', '#daycare-form select[name="Size"]', '#daycare-form select[name="AspirateNature"]', '#daycare-form select[name="StoolNature"]', '#daycare-form select[name="NECtreatment"]', '#daycare-form select[name="Umbilicus"]', '#daycare-form select[name="Herina"]', '#daycare-form select[name="Activity"]', '#daycare-form select[name="Tone"]', '#daycare-form select[name="NeonatalReflexes"]', '#daycare-form select[name^="F_Product["]', '#daycare-form select[name="Sepsis"]', '#daycare-form select[name^="Organism["]', '#daycare-form select[name="Meningitis"]', '#daycare-form select[name="PiccSite"]', '#daycare-form select[name="PacSite"]', '#daycare-form select[name="TypeofFeeds"]', '#daycare-form select[name="ModeOfVentilation"]', '#daycare-form select[name^="seenby["]', '#daycare-form select[name^="reassessment_seen_by["]'];

		var nicu_daycare_option_type_2 = ['#daycare-form select[name="Frequency"]', '#daycare-form select[name^="reassessment_ventilater["]', '#daycare-form select[name^="reassessment_cpap["]', '#daycare-form select[name^="reassessment_nc["]', '#daycare-form select[name^="reassesment_room_air["]'];

		var nicu_daycare_option_type_3 = ['#daycare-form select[name="DayTime"]', '#daycare-form select[name="DayTime_MINS"]', '#daycare-form select[name="DayTime_AM"]', '#daycare-form select[name="LastBG_Time"]', '#daycare-form select[name="LastBG_Time_MINS"]', '#daycare-form select[name="LastBG_Time_AM"]', '#daycare-form select[name="Cry"]', '#daycare-form select[name^="A_Antibiotic["]', '#daycare-form select[name^="drugs["]', '#daycare-form select[name^="reassessment_time["]', '#daycare-form select[name^="reassessment_min["]', '#daycare-form select[name^="reassessment_am["]'];

		add_more_type_1 = ['#daycare-form select[name^="F_Product["]', '#daycare-form select[name^="Organism["]', '#daycare-form select[name^="seenby["]'];

		add_more_type_3 = ['#daycare-form select[name^="A_Antibiotic["]', '#daycare-form select[name^="drugs["]'];

		select_value_type1(nicu_daycare_option_type_1);

		select_value_type2(nicu_daycare_option_type_2);

		select_value_type3(nicu_daycare_option_type_3);
	}

	// NICU Discharge Form
	if ($('form').hasClass('nicu-admission-form') && ($('.tab-pane.active').is('#dischargeform') || $('.tab-pane.active').is('#Checkform'))) {
		var nicu_daycare_option_type_1 = ['.nicu-admission-form select[name="Schedule"]', '.nicu-admission-form select[name^="M_Dose["]', '.nicu-admission-form select[name^="M_Frequency["]', '.nicu-admission-form select[name^="M_Duration["]', '.nicu-admission-form select[name="Eyes"]', '.nicu-admission-form select[name="discharge_femoral_pulses"]', '.nicu-admission-form select[name="FeedingAtDischarge"]', '.nicu-admission-form select[name="NAT_TIME"]', '.nicu-admission-form select[name="NAT_MINS"]', '.nicu-admission-form select[name="NAT_AM"]', '.nicu-admission-form select[name="oae_left"]', '.nicu-admission-form select[name="oae_right"]', '.nicu-admission-form select[name="abr_left"]', '.nicu-admission-form select[name="abr_right"]', '.nicu-admission-form select[name="result_rop_left"]', '.nicu-admission-form select[name="result_rop_right"]', '.nicu-admission-form select[name^="typeoftreatment_left["]', '.nicu-admission-form select[name^="typeoftreatment_right["]', '.nicu-admission-form select[name^="procedures["]', '.nicu-admission-form select[name="diedTime"]', '.nicu-admission-form select[name="diedMins"]', '.nicu-admission-form select[name="diedAm"]', '.nicu-admission-form select[name="DischargeTransferedTime"]', '.nicu-admission-form select[name="DischargeTransferedTime_MINS"]', '.nicu-admission-form select[name="DischargeTransferedTime_AM"]'];

		var nicu_daycare_option_type_3 = ['.nicu-admission-form select[name="status"]'];

		add_more_type_1 = ['.nicu-admission-form select[name^="M_Dose["]', '.nicu-admission-form select[name^="M_Frequency["]', '.nicu-admission-form select[name^="M_Duration["]', '.nicu-admission-form select[name^="typeoftreatment_left["]', '.nicu-admission-form select[name^="typeoftreatment_right["]', '.nicu-admission-form select[name^="procedures["]'];

		select_value_type1(nicu_daycare_option_type_1);

		select_value_type3(nicu_daycare_option_type_3);
	}

	//  Pediatric Registration
	if ($('form').is('#pediatric-form')) {

		var pediatric_option_type_1 = ['#pediatric-form select[name="BabyBloodGroup"]',
		 '#pediatric-form select[name="Sex"]', '#pediatric-form select[name="admission_time"]',
		  '#pediatric-form select[name="admission_time_mins"]', '#pediatric-form select[name="admission_time_am"]','#pediatric-form select[name="assessment_time"]',
		  '#pediatric-form select[name="assessment_time_mins"]', '#pediatric-form select[name="assessment_time_am"]',
		   '#pediatric-form select[name="type_of_care"]', '#pediatric-form select[name^="surgeon"]', 
		   '#pediatric-form select[name^="pediatric_consultant"]', '#pediatric-form select[name^="specialist"]', 
		   '#pediatric-form select[name="seen_by"]', '#pediatric-form select[name="inspection"]',
		    '#pediatric-form select[name="palpation"]', '#pediatric-form select[name="eye_opening"]', 
		    '#pediatric-form select[name="verbal"]', '#pediatric-form select[name="motor"]', 
		    '#pediatric-form select[name="hospital_name"]', '#pediatric-form select[name="admission_entered_by"]', 
		    '#pediatric-form select[name^="M_Dose["]', '#pediatric-form select[name^="M_Frequency["]', 
		    '#pediatric-form select[name^="M_Duration["]', '#pediatric-form select[name^="T_Dose["]', 
		    '#pediatric-form select[name^="T_Frequency["]', '#pediatric-form select[name^="T_Duration["]', 
		    '#pediatric-form select[name="anaesthetist"]','#pediatric-form select[name^="T_Drugs["]','#pediatric-form select[name^="M_Drugs["]'];
		
		add_more_type_1 = ['#pediatric-form select[name^="pediatric_consultant["]', 
			'#pediatric-form select[name^="surgeon["]', '#pediatric-form select[name^="specialist["]', 
			'#pediatric-form select[name^="M_Dose["]', '#pediatric-form select[name^="M_Frequency["]', 
			'#pediatric-form select[name^="M_Duration["]', '#pediatric-form select[name^="T_Dose["]',
			 '#pediatric-form select[name^="T_Frequency["]', '#pediatric-form select[name^="T_Duration["]', 
			 '#pediatric-form select[name^="T_Drugs["]','#pediatric-form select[name^="M_Drugs["]'];

		select_value_type1(pediatric_option_type_1);
		
	}

	//  Neuro
	if ($('form').is('#neuro-form')) {

		var pediatric_option_type_1 = ['#neuro-form select[name="BabyBloodGroup"]', '#neuro-form select[name="Sex"]', '#neuro-form select[name="TOB_TIME"]', '#neuro-form select[name="TOB_MINS"]', '#neuro-form select[name="TOB_AM"]', '#neuro-form select[name="seen_by"]', '#neuro-form select[name^="seen_by["]', '#neuro-form select[name="examiner"]'];

		var pediatric_option_type_3 = ['#neuro-form select[name="review_time"]', '#neuro-form select[name="review_min"]', '#neuro-form select[name="review_session"]'];

		add_more_type_1 = ['#neuro-form select[name^="seen_by["]'];
		
		select_value_type1(pediatric_option_type_1);

		select_value_type1(pediatric_option_type_3);
		
	}

	//  Feeding
	if ($('form').is('#feeding-form')) {

		var feeding_option_type_1 = ['#feeding-form select[name^="seen_by["]'];

		add_more_type_1 = ['#feeding-form select[name^="seen_by["]'];
		
		select_value_type1(feeding_option_type_1);

	}

	if ($('form').is('#mrform-edit')) {

		var mrform_option_type_1 = ['#mrform-edit select[name^="op_print_user_id["]'];
		
		add_more_type_1 = ['#mrform-edit select[name^="op_print_user_id["]'];

		select_value_type1(mrform_option_type_1);
	}

	$(document).on('click', '#patient-detail', function() {

		var option_type_1 = ['select[name="consultant"]'];
		
		select_value_type1(option_type_1);
	});

	$(document).on('click', '.btn_add', function() {

		var temp_add_more_type_1 = add_more_type_1.toString();

		var temp_add_more_type_2 = add_more_type_2.toString();

		var temp_add_more_type_3 = add_more_type_3.toString();

		var field_name = $(this).parents('table').find('tr').last().find('select');

		var type_1 = false;
		var type_2 = false;
		var type_3 = false;

		$(field_name).each(function() {
			field_name = $(this).attr('name').replace(']', '');
			field_name = field_name.replace(/[0-9]/g, '');

			type_1 = temp_add_more_type_1.indexOf(field_name) != -1;
			if (type_1) {
				return false;
			}
			type_2 = temp_add_more_type_2.indexOf(field_name) != -1;
			if (type_2) {
				return false;
			}
			type_3 = temp_add_more_type_3.indexOf(field_name) != -1;
			if (type_3) {
				return false;
			}
		});
		
		if (type_1) {
			select_value_type1(add_more_type_1);
		}

		if (type_2) {
			select_value_type2(add_more_type_2);
		}
		
		if (type_3) {
			select_value_type3(add_more_type_3);
		}
	});
	
	// Nicu Daycare Reassessment - Add more
	$(document).on('click', '.reassessment-add', function() {

		var nicu_daycare_option_type_1 = ['#daycare-form select[name^="reassessment_seen_by["]'];

		var nicu_daycare_option_type_2 = ['#daycare-form select[name^="reassessment_ventilater["]', '#daycare-form select[name^="reassessment_cpap["]', '#daycare-form select[name^="reassessment_nc["]', '#daycare-form select[name^="reassesment_room_air["]'];

		var nicu_daycare_option_type_3 = ['#daycare-form select[name^="reassessment_time["]', '#daycare-form select[name^="reassessment_min["]', '#daycare-form select[name^="reassessment_am["]'];

	    $('input[name^=reassessment_date]').datepicker({
	        dateFormat: 'dd-mm-yy'
	    });
	    
		select_value_type1(nicu_daycare_option_type_1);

		select_value_type2(nicu_daycare_option_type_2);

		select_value_type3(nicu_daycare_option_type_3);
	});

	// Poblem based daycare - Add more
	$(document).on('click', '.add-medicine, .add-drop-box, .add-antibiotic', function() {
		var field_name = $(this).parents('div.form-group').parents('div.form-group').find('table').find('tbody').find('tr').last().find('select');

		var color = field_name.attr('data-color');

		if (typeof color === 'undefined') {
			var field_name = field_name.attr('name');

			var add_more_type_3 = ['#problem_base_daycare select[name="'+field_name+'"]'];

			select_value_type3(add_more_type_3);
		}
	});

	function select_value_type1(list) {
		$.each(list, function(key, value) {
			$(value).select2();
			$(value).removeClass('form-control').addClass('full-width');
			$(value).each(function() {
				if (typeof $(this).val() != 'undefined') {
					var field_val = $(this).val().length;
					if (field_val == 0) {
						$(this).select2("val", "");
					}
				}
			});
		});
	}
	function select_value_type2(list) {
		$.each(list, function(key, value) {
			$(value).select2();
			$(value).removeClass('form-control').addClass('full-width');
			$(value).each(function() {
				if (typeof $(this).val() != 'undefined') {
					var field_val = $(this).val().length;
					if (field_val == 0) {
						$(this).select2("val", " ");
					}
				}
			});
		});
	}
	function select_value_type3(list) {
		$.each(list, function(key, value) {
			$(value).select2();
			$(value).removeClass('form-control').addClass('full-width').removeClass('shadow').removeClass('custom-form-control');
		});	
	}
	function select_value_type4(list) {
		$(list[0]).each(function() {
			var color = $(this).attr('data-color');
			if (typeof color === 'undefined') {
				$(this).select2();
				$(this).removeClass('form-control').addClass('full-width').removeClass('shadow').removeClass('custom-form-control');
			}
		});	
	}

	$(document).on('click', '.btn_add.standard_dose', function() {

		var add_more = ['#op-form select[name^="M_Dose["]', '#op-form select[name^="M_Frequency["]', '#op-form select[name^="M_Duration["]', '#pediatric-op-form select[name^="M_Dose["]', '#pediatric-op-form select[name^="M_Frequency["]', '#pediatric-op-form select[name^="M_Duration["]']
		
		select_value_type1(add_more);
		
	});

});
