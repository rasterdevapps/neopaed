<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

// Route::get('password/email','Auth\ForgotPasswordController@sendResetLinkEmail');


Route::get('success', 'HomeController@show');


/**
 * ROUTE MAPPING FOR IMPORT SCRIPTS
 */
Route::get('search-reports', 'HomeController@search');

Route::get('nicu_import', 'ImportController@nicu_import');

Route::get('op_import', 'ImportController@op_import');

Route::get('pediatric_import', 'ImportController@pediatric_import');

/**
 * ROUTE MAPPING FOR SITE SETTINGS
 */

Route::post('fhir-json-post', 'Fhir\FhirFormateController@getformatfhir');

Route::get('site', 'Settings\SiteController@index');

Route::post('site', 'Settings\SiteController@store');

Route::get('site/edit', 'Settings\SiteController@edit');

Route::get('speical-permission', 'Settings\SiteController@getPermissionform');

Route::post('site/update', 'Settings\SiteController@update');

Route::post('site/mroverwrite', 'Settings\SiteController@mroverwrite');

Route::get('test', 'Registration\NeonatalController@test');

//external access
Route::post('get-patient-details', 'Fhir\FhirController@getfhirjsondata');
Route::post('get-syringe-details', 'fhirreciver\SyringeReceiverController@getfhirjsondata');
Route::post('get-infusion-details', 'fhirreciver\InfusionReceiverController@getfhirjsondata');
Route::post('get-monitor-details', 'fhirreciver\MonitorReceiverController@getfhirjsondata');
Route::post('get-vendilator-details', 'fhirreciver\VendilatorReceiverController@getfhirjsondata');
Route::post('get-machine-status', 'interfacelog\MachineLogController@getMachineStatus');
Route::get('get-lab-details', 'Lab\LabImportController@getfhirjsondata');


Route::post('post-lab-culture-details', 'Fhir\LabCultureImportController@getfhirjsondata');


Route::post('synchronize-doctors-master', 'Fhir\MasterSyncController@getDoctorMaster');
Route::post('synchronize-department-master', 'Fhir\MasterSyncController@getDepartmentMaster');
Route::post('synchronize-Investigation-master', 'Fhir\MasterSyncController@getInvestigationMaster');
//Oxygen index
Route::get('oxygen-index-update', 'Fhir\ImportFhirController@updateOxygenIndex');
//Oxygen index

//external access


Route::get('lab-fhir-import', 'Fhir\LabFhirFormateController@getlabformatfhir');

Route::get('get-formate-patient-details', 'Fhir\FhirFormateController@getformatfhir');

Route::get('get-create-nurse-sheet', 'Fhir\ImportFhirController@creatensursesheet');

Route::get('home/test', 'HomeController@getAutosuggestionTag');

Route::get('send-prescription/{slug}', 'prescription\PrescriptionController@sendprescription');


Route::get('lab', 'Nurse\LabImportedController@labValues');

Route::get('nurse-all-one-chart/{baby_id}', 'Nurse\NurseChartController@allinonechart');

Route::get('nurse-all-one-chart-data/{baby_id}', 'Nurse\NurseChartController@nurseChartData');

Route::get('lab-request-send', 'Lab\LabRequestController@getSendRequest');

Route::get('lab-send-ip', 'Lab\LabRequestController@getResult');

Route::get('fhir-interface-clean', 'Fhir\FhirBackUpController@fhirInterfaceClean');

Route::get('genrate-pdf/{id}', 'reports\NicuDischargeController@generatePdf');

// Prescription data
Route::post('get-prescription', 'prescription\prescriptionFormatController@getPrescriptionData');
Route::post('prescription-instant-status', 'prescription\prescriptionFormatController@getPrescriptionInstantStatus');
Route::post('prescription-stop-status', 'prescription\prescriptionFormatController@getPrescriptionInstantStop');

// Nurse sheet
Route::get('baby-list', 'Registration\BabyController@babyList');

// Check session is experied or not
Route::get('check-session-experied', 'HomeController@checkAuthLogin');

Route::post('check-user-login', 'HomeController@checkLoginUser');

Route::get('prescriptionLastTime', 'prescription\PrescriptionController@getLastResultTime');

Route::post('dsn-status-data', 'DSNotificationController@getDsnStatusData');

Route::get('dsn-status-data', 'DSNotificationController@getDeviceNotification');

// Nicu Dashboard
Route::get('update-dashboard-data', 'NicuDashboardController@updateDashboardData');

Route::get('get-dashboard-data', 'NicuDashboardController@getDashboardData');

Route::post('post-page-data', 'NicuDashboardController@postIomtRequest');

Route::post('post-pacs-data', 'NicuDashboardController@postPACSRequest');

// Dashboard Event
// Route::post('get-dashboard-event', 'Nurse\DashboardEventController@getDashboardEventResult');

Route::get('active-baby-details', 'Ward\BabyWardController@activeBabyDetails');

Route::get('get-events/{mrn}/{bed_id}', 'Nurse\DashboardEventController@getBabyEvents');

Route::post('store-event-data', 'Nurse\DashboardEventController@storeDashboardEvents');

Route::get('get-event-result', 'Nurse\DashboardEventController@getEventResult');

Route::post('care-event/send-stop-status', 'Nurse\DashboardEventController@postStopStatus');

Route::post('transfer-patient-in-hms', 'Fhir\HmsInterfacingController@transferPatientInHMS');

Route::post('range-data-post', 'Fhir\RangeComparisonChartController@rangePost');

Route::post('ventilator-temp-process', 'VentilatorTempProcessController@index');

Route::get('get-dashboard-data', 'InterfaceData\InterfaceDataController@getDashboardResultDetails');

Route::get('get-nicu-inpatient-list', 'Ward\BabyWardController@getNICUInpatientList');

Route::post('store-daycare-transcribed-data', 'TranscribtionIntegrationController@storeTranscribedDaycareData');
Route::post('store-neonatal-proforma-transcribed-data', 'TranscribtionIntegrationController@storeTranscribedNeonatalProformaData');
Route::post('store-op-neonatal-transcribed-data', 'TranscribtionIntegrationController@storeTranscribedOpNeonatalData');
Route::post('store-nicu-discharge-transcribed-data', 'TranscribtionIntegrationController@storeTranscribedNicuDischargeData');
Route::post('store-nicu-admission-transcribed-data', 'TranscribtionIntegrationController@storeTranscribedNicuAdmissionData');
Route::get('nicu-inpatient-list', 'TranscribtionIntegrationController@getNicuInpatientList');
Route::get('today-op-baby-list', 'TranscribtionIntegrationController@getTodayOpBabyList');


/**
 * ROUTE MAPPING FOR THE LOGGED IN PAGES. THE Auth MIDDLEWATE WILL VALIDATE THE LOGIN AND ONLY THE BELOW PAGES WILL LOAD,
 */
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index');

    Route::post('saveScreenSize', 'HomeController@storeScreenSize');

    Route::get('home', 'HomeController@index');

    Route::get('404', 'HomeController@comingsoon');

    Route::get('start-register', 'Flow\FlowController@flowControl');

    Route::get('start-register-nurse', 'Flow\FlowController@nurseFlowcontrol');

    Route::get('resume-register/{id}', 'Flow\FlowController@resumeFlow');

    Route::get('cancel-current-flow', 'Flow\FlowController@clearFlow');

    Route::get('complete-current-flow', 'Flow\FlowController@completeflow');

    Route::get('flow-list', 'Flow\FlowController@index');

    Route::post('flow-list-update', 'Flow\FlowController@updaterecord');

    Route::resource('mother-registration', 'Registration\MotherController');

    Route::resource('mother-registration-nurse', 'Registration\NurseMotherController');

    Route::resource('baby-registration-nurse', 'Registration\NurseBabyController');

    Route::get('baby-registration-nurse/create/{data}', 'Registration\NurseBabyController@create');

    Route::get('baby-bed-details/{id}/{slug}/{type?}', 'Registration\NurseBabyController@getadmissionbedlist');

    Route::get('baby-ward-room-bed-list/{id}/{slug}', 'Registration\NurseBabyController@getWardRoomBedDetails');

    Route::get('baby-readmission-nurse/baby-list', 'Registration\NurseBabyController@babylistnurse');

    Route::get('baby-readmission/nurse/nicu-admission/{id}', 'Registration\NurseBabyController@babyreadmission');

    Route::post('baby-readmission/create/nicu-admission', 'Registration\NurseBabyController@readmissioncreation');

    Route::resource('usergroups', 'Settings\UsergroupController');

    Route::resource('users', 'Settings\UserController');

    Route::get('age-calculate/{birthdate}/{enddate}/{prematuredays}', 'Registration\BabyController@calculateAge');

    Route::get('baby-registration/search-data', 'Registration\BabyController@searchData');

    Route::get('baby-registration/select', 'Registration\BabyController@chooseMother');

    Route::get('baby-registration/create/{data}', 'Registration\BabyController@create');

    Route::get('baby-registration/{data}/edit/{data1}', 'Registration\BabyController@edit');

    Route::resource('baby-registration', 'Registration\BabyController');

    Route::get('age-calculator', 'Calculators\AgeController@index');

    Route::get('glucose-rate-calculator', 'Calculators\GlucoseController@index');

    Route::get('glucose-intake-calculator', 'Calculators\GlucoseIntakeController@index');

    Route::get('search-data', 'Registration\MotherController@searchData');

    Route::get('get-data', 'Registration\MotherController@getData');

    // Route::patch('neonatal/update_performa/{id}', 'Registration\NeonatalController@update');

    Route::get('neonatal/{data}/getdata', 'Registration\NeonatalController@getData');

    Route::get('neonatal/{data}/edit/{data1}', 'Registration\NeonatalController@edit');

    Route::get('neonatal/sub-neo-list/{data}', 'Registration\NeonatalController@neolist');

    Route::get('neonatal/neonatal-discharge-list', 'Registration\NeonatalController@neonatalDichargelist');

    Route::get('neonatal/search-data', 'Registration\NeonatalController@searchData');

    Route::get('neonatal/select', 'Registration\NeonatalController@chooseBaby');

    Route::get('neonatal/create/{data}', 'Registration\NeonatalController@create');

    Route::resource('neonatal', 'Registration\NeonatalController');

    Route::get('out-patient/{data}/getdata', 'Registration\OpController@getData');

    Route::get('out-patient/visite-list/{data}', 'Registration\OpController@OpsubList');

    Route::get('out-patient-review/{id}', 'Registration\OpController@getReviewDate');

    Route::get('out-patient/search-data', 'Registration\OpController@searchData');

    Route::get('out-patient/select', 'Registration\OpController@chooseBaby');

    Route::get('out-patient/create/{data}', 'Registration\OpController@create');

    Route::get('out-patient/{data}/edit/{data1}', 'Registration\OpController@edit');

    Route::get('out-patient/vaccine-chart-print/{id}', 'Registration\OpController@vaccineChartPrint');

    Route::get('out-patient/vaccine-chart/{id}', 'Registration\OpController@vaccineChart');

    Route::post('out-patient/save-vaccine-chart-patient-data', 'Registration\OpController@saveVaccinePatientData');

    Route::get('get-physical-growth', 'Registration\OpController@getPhysicalGrowth');

    Route::resource('out-patient', 'Registration\OpController');

    Route::get('pediatric-out-patient/create/{data}', 'Registration\PediatricOpController@create');

    Route::get('pediatric-out-patient/select', 'Registration\PediatricOpController@chooseBaby');

    Route::get('pediatric-out-patient/visite-list/{data}', 'Registration\PediatricOpController@OpsubList');

    Route::get('pediatric-out-patient/{data}/op-with-vaccine', 'Registration\PediatricOpController@print');

    Route::resource('pediatric-out-patient', 'Registration\PediatricOpController');

    Route::resource('newborn', 'Registration\NewbornController');

    Route::get('daycare-admission/search-data', 'Admission\DaycareController@searchData');

    // Route::get('daycare-admission/daycare-baby-list/{data}', 'Admission\DaycareController@daycareBabysubList');

    Route::get('daycare-admission/daycare-baby-admissionlist/{data}', 'Admission\DaycareController@daycareBabysubList');

    Route::get('daycare-message-doctor', 'Admission\DaycareController@sentMessagereferaldoctors');

    Route::get('daycare-admission/daycare-admission-daylist/{data}', 'Admission\DaycareController@daycareAdmissionDaylist');

    Route::get('daycare-admission/admission-lists/{data}/{daycare_type?}', 'Admission\DaycareController@getDaycareadmission');

    Route::get('daycare-admission/{data}/printdata', 'Admission\DaycareController@printData');

    Route::get('daycare-admission/create/{type?}', 'Admission\DaycareController@create');

    Route::get('daycare-admission/{data}/reassment-printdata', 'Admission\DaycareController@reassessmentPrintData');

    Route::get('daycare-admission/{data}/getdata', 'Admission\DaycareController@getData');

    Route::get('daycare-admission/{data}/edit/{data1}', 'Admission\DaycareController@edit');

    Route::resource('daycare-admission', 'Admission\DaycareController');

    Route::get('postnatal-daycare/search-data', 'Admission\PostnatalDaycareController@searchData');

    Route::get('postnatal-daycare/{data}/printdata', 'Admission\PostnatalDaycareController@printData');

    Route::get('postnatal-daycare/{data}/getdata', 'Admission\PostnatalDaycareController@getData');

    Route::get('postnatal-daycare/{data}/edit/{data1}', 'Admission\PostnatalDaycareController@edit');

    Route::get('postnatal-daycare-sublist/{data}', 'Admission\PostnatalDaycareController@postnatalSublist');

    Route::get('postnatal-daycare-daywiselist/{data}', 'Admission\PostnatalDaycareController@postnatalDaywiselist');

    Route::get('postnatal-daycare-admisson-list/{data}', 'Admission\PostnatalDaycareController@get_admissions');

    Route::resource('postnatal-daycare', 'Admission\PostnatalDaycareController');

    Route::get('pediatric-admission/{data}/printdata', 'Admission\PediatricController@print');

    Route::get('pediatric-admission/{data}/getdata', 'Admission\PediatricController@getData');

    Route::get('pediatric-admission/{data}/edit/{data1}', 'Admission\PediatricController@edit');

    Route::get('pediatric-admission/search-data', 'Admission\PediatricController@searchData');

    Route::get('pediatric-admission/sub-list/{data}', 'Admission\PediatricController@sublist');

    Route::get('pediatric-admission/{data}/create', 'Admission\PediatricController@show');

    Route::get('pediatric-admission/{data}/summaryprint', 'Admission\PediatricController@summaryprint');

    Route::post('pediatric-admission/approval', 'Admission\PediatricController@summaryApproval');

    Route::post('pediatric-admission/issue-details', 'Admission\PediatricController@issuedDetails');

    Route::resource('pediatric-admission', 'Admission\PediatricController');

    Route::get('nicu-admission/select', 'Admission\NicuController@chooseBaby');

    Route::get('nicu-admission/{data}/printdata', 'Admission\NicuController@printData');

    Route::get('nicu-age-admission-calculate', 'Admission\NicuController@getageonadmission');

    Route::get('nicu-admission-discharge/{id}', 'Admission\NicuController@nicuDischarge');

    Route::get('postanatal-admission-discharge/{id}', 'Admission\PostnatalDischargeController@postanatalDischarge');

    Route::get('nicu-admission/sub-nicu-list/{data}', 'Admission\NicuController@nicuSublists');

    Route::get('nicu-admission/{data}/getdata', 'Admission\NicuController@getData');

    Route::get('nicu-admission/{data}/edit/{data1}', 'Admission\NicuController@edit');

    Route::get('nicu-admission/search-data', 'Admission\NicuController@SearchData');

    Route::get('nicu-admission/discharge-list/{status?}', 'Admission\NicuController@dischargeList');

    Route::get('nicu-admission/discharge-sub-list/{data}', 'Admission\NicuController@dischargeSublist');

    Route::get('nicu-admission/get-baby-lists/{data}', 'Admission\NicuController@nicuBabyadmission');

    Route::post('ip-check', 'Admission\NicuController@checkIpExist');

    Route::resource('postanatal-admission', 'Admission\PostnatalController');

    Route::get('postanatal-admission/{id}/printData', 'Admission\PostnatalController@printData');

    Route::get('postanatal-admission/get-baby-lists/{data}', 'Admission\PostnatalController@postnatalBabyadmission');

    Route::get('postanatal-admission/admissionlist/{baby_id}', 'Admission\PostnatalController@postnatalAdmissionlist');

    Route::resource('postanatal-discharge', 'Admission\PostnatalDischargeController');

    Route::get('postanatal-discharge/admission-list/{baby_id}', 'Admission\PostnatalDischargeController@postnatalDischargelist');

    Route::resource('icd', 'Admission\IcdController');

    Route::get('icd/create/', 'Admission\IcdController@create');

    Route::resource('nicu-admission', 'Admission\NicuController');

    Route::resource('ballard-score', 'Calculators\BallardController');

    Route::get('ballard-score-print/{id}', 'Calculators\BallardController@print');

    Route::resource('echocardiography', 'Extras\CardioController');

    Route::get('echocardiography/{data}/printdata', 'Extras\CardioController@printData');

    Route::get('echocardiography/{data}/getdata', 'Extras\CardioController@getData');

    Route::resource('cranialultrasound', 'Extras\UltraController');

    Route::get('cranialultrasound/{data}/printdata', 'Extras\UltraController@printData');

    Route::get('cranialultrasound/{data}/getdata', 'Extras\UltraController@getData');

    Route::resource('culture-registry', 'Extras\CultureController');

    Route::resource('mass-reports', 'Reports\AnnualReportsController');

    Route::get('mass-inborn-baby-chart', 'Reports\AnnualReportsController@getInbornbaby');

    Route::get('mass-repors-prints/{date1}/{date2}', 'Reports\AnnualReportsController@printData');

    Route::get('culture-registry/{data}/printdata', 'Extras\CultureController@printData');

    Route::get('baby-print', 'Reports\BabyReportController@index');

    Route::post('baby-print', 'Reports\BabyReportController@filter');

    Route::get('baby-tag-print/{id}', 'Reports\BabyReportController@babyTagprint');

    Route::get('nicu-report', 'Reports\NicuReportController@filter');

    Route::post('nicu-report', 'Reports\NicuReportController@index');

    Route::get('op-report', 'Reports\OpReportController@filter');

    Route::post('op-report', 'Reports\OpReportController@index');

    Route::get('culture-report', 'Reports\CultureReportController@filter');

    Route::post('culture-report', 'Reports\CultureReportController@index');

    Route::get('pediatric-report', 'Reports\PediatricReportController@filter');

    Route::post('pediatric-report', 'Reports\PediatricReportController@index');

    Route::get('nb-report', 'Reports\NbReportController@filter');

    Route::post('nb-report', 'Reports\NbReportController@index');

    Route::get('echo-report', 'Reports\EchoReportsController@filter');

    Route::post('echo-report', 'Reports\EchoReportsController@index');

    Route::get('carnial-ultrasound-report', 'Reports\CranialReportController@filter');

    Route::post('carnial-ultrasound-report', 'Reports\CranialReportController@index');

    Route::get('op-activity-report', 'Reports\OpActivityController@filter');

    Route::post('op-activity-report', 'Reports\OpActivityController@index');

    Route::get('neonatal-summary', 'Reports\NeonatalSummaryController@index');

    Route::post('neonatal-summary', 'Reports\NeonatalSummaryController@neonatal_summary');

    // Route::get('nicu-discharge-summary', 'Reports\NicuDischargeController@filter');

    Route::get('nicu-discharge-summary/{data}/{summary_type?}', 'Reports\NicuDischargeController@index');

    Route::post('nicu-discharge-reports', 'Reports\NicuDischargeController@store');

    Route::get('nicu-discharge-remove', 'Reports\NicuDischargeController@destroy');

    Route::get('nicu-discharge-status', 'Reports\NicuDischargeController@getChangestatus');

    Route::post('nicu-discharge-savedefaulte', 'Reports\NicuDischargeController@getSavedefaulte');

    Route::get('nicu-discharge-main-list/{summary_type?}', 'Reports\NicuDischargeController@discharge_main_list');

    Route::get('nicu-discharge-sub-list/{data}/{summary_type?}', 'Reports\NicuDischargeController@discharge_sub_list');

    Route::get('nicu-discharge-reports-editors', 'Reports\NicuDischargeController@getfullEditor');

    Route::post('nicu-discharge-reports-save/{summary_type?}', 'Reports\NicuDischargeController@saveFullEditor');

    Route::get('nicu-abbrivated-summary/{data}/{summary_type?}', 'Reports\NicuDischargeController@getAbbrivatedsummaryShow');

    Route::get('nicu-advance-search', 'Reports\NicuDischargeController@DischargeSummarySearch');

    Route::get('op-advance-search', 'Search\SearchOpController@OpReportSearch');

    Route::get('op-search-report/{id}/{search_text}/{search_mode}', 'Search\SearchOpController@searchreport');

    // Route::get('nicu-discharge','Reports\NicuDischargeController@getDischarge');

    Route::get('birth-report', 'Reports\BirthReportController@filter');

    Route::post('birth-report', 'Reports\BirthReportController@index');

    Route::post('inpatient-list', 'Reports\InpatientListController@filter');

    Route::get('inpatient-list', 'Reports\InpatientListController@index');

    // Route::get('registermother', 'MotherController@create');

    // Masters
    Route::resource('masters/medicines', 'Masters\DrugController');

    Route::resource('masters/vaccines', 'Masters\VaccineController');

    Route::resource('masters/antibiotics', 'Masters\AntibioticController');

    Route::get('add-anitibiotic', 'Masters\AntibioticController@addAntibiotic');

    Route::resource('masters/complications', 'Masters\ComplicationController');

    Route::resource('masters/nicu-procedures', 'Masters\ProcedureController');

    Route::resource('masters/medicalproblems', 'Masters\MediprobsController');

    Route::resource('masters/medical-problems', 'Masters\ProblemController');

    Route::resource('masters/staff', 'Masters\StaffController');

    Route::resource('masters/doctors-list', 'Masters\DoctorController');

    Route::resource('masters/ivfluids', 'Masters\IvFluidsController');

    Route::resource('masters/nurse', 'Masters\NurseController');

    Route::resource('masters/ward', 'Masters\WardController');

    Route::resource('masters/bed', 'Masters\BedController');

    Route::resource('masters/collection-method', 'Masters\CollectioMethodController');

    Route::resource('masters/collection-site', 'Masters\CollectioSiteController');

    Route::resource('masters/department', 'Masters\DepartmentController');

    Route::resource('masters/investigation', 'Masters\InvestigationController');

    Route::resource('masters/m-chat-r-questions', 'Masters\MchatquestionsController');

    Route::post('masters/m-chat-update-parent', 'Masters\MchatfollowupquestionsController@updateParent');

    Route::resource('masters/m-chat-r-followup-questions', 'Masters\MchatfollowupquestionsController');

    Route::resource('masters/frequency', 'Masters\FrequencyController');

    Route::resource('masters/dose', 'Masters\DoseController');

    Route::resource('masters/drugivfluid', 'Masters\DrugIvFluidController');

    Route::resource('masters/prescriptiontype', 'Masters\PrescriptionTypeController');

    Route::resource('masters/investigations', 'Masters\InvestigationsController');

    Route::resource('masters/dasii-questions', 'Masters\DasiiquestionsController');

    Route::resource('masters/cbcl-questions', 'Masters\CBCLQuestionsController');

    Route::resource('masters/issa-questions', 'Masters\ISSAQuestionsController');

    Route::resource('masters/ddst', 'Masters\DdstController');

    Route::resource('masters/bayley-scale', 'Masters\BayleyScaleController');

    Route::get('get-test-names', 'Masters\InvestigationsController@getTestList');

    Route::get('drug-update-master', 'Masters\DrugController@getUpdateMaster');

    Route::get('ivfluids-update-master', 'Masters\IvFluidsController@getUpdateMaster');

    Route::post('collection-site-update-master', 'Masters\CollectioSiteController@getUpdateCollectionSite');

    Route::post('collection-method-update-master', 'Masters\CollectioMethodController@getUpdateCollectionMethod');

    Route::post('doctors-update-master', 'Masters\DoctorController@getUpdateDoctors');

    Route::post('icd-update-master', 'Admission\IcdController@getUpdateIcd');

    Route::resource('masters/referral', 'Masters\ReferralController');

    Route::resource('masters/vaccine-age', 'Masters\VaccineAgeController');

    Route::get('masters/vaccine-age-map', 'Masters\VaccineAgeController@mapWithVaccines');

    Route::post('masters/vaccine-generic/store-vaccine', 'Masters\VaccineAgeController@storeVaccine');

    Route::post('masters/vaccine-generic/map-vaccines', 'Masters\VaccineAgeController@mapVaccines');

    Route::post('masters/vaccine-generic/sorting-vaccines', 'Masters\VaccineAgeController@sortVaccines');

    Route::post('masters/vaccine-generic/delete-vaccine', 'Masters\VaccineAgeController@deleteVaccines');

    // Route::resource('masters/Auto-fill','Masters\MultiplePregnancyCommonController');

    // Route::get('masters/Auto-fill/edit/{data}','Masters\MultiplePregnancyCommonController@edit');

    Route::resource('masters/admission-mode', 'Masters\AdmissionmodeController');

    Route::resource('masters/respiratory-indication', 'Masters\RespiratoryIndicationController');

    Route::resource('masters/surgeon-lists', 'Masters\SurgeonController');

    Route::get('masters/drugs-strength/{id}', 'Masters\DrugController@get_drung_strength');

    //problem base daycare 
    Route::resource('problems-settings', 'ProblemsSettings\ProblemsSettingController');

    Route::resource('masters/problemsintermediaters', 'ProblemsSettings\ProblemsIntermediateController');

    Route::get('problems-settings-forms', 'ProblemsSettings\ProblemsSettingController@getFromproperty');

    Route::get('problems-settings-dropboxes', 'ProblemsSettings\ProblemsSettingController@getDropboxoption');
    //problem base daycare 

    Route::get('approve/', 'Settings\DeleteApprovalController@index');

    Route::delete('approve/{data}/processdata/{data1}', 'Settings\DeleteApprovalController@process');

    Route::get('baby-registration/search-data', 'Registration\BabyController@searchData');

    Route::resource('profile', 'Settings\ProfileController');

    Route::resource('masters/indication', 'Masters\IndicationController');

    Route::resource('site-settings', 'Settings\SiteSettingController');

    Route::post('cropImage', 'Settings\SiteController@cropImage');

    Route::post('uploadImage', 'Settings\SiteController@uploadImage');

    Route::get('test', 'Settings\SiteSettingController@test');

    Route::post('patient-details', 'Sockets\SocketController@Request_patient_details');

    Route::post('get-patient', 'Sockets\SocketController@Retrieve_patient_details');

    Route::post('create-baby-mother', 'Registration\BabyController@Create_mother_baby');

    Route::post('baby-Mrcheck', 'Registration\BabyController@Check_mrno');

    Route::resource('nurse-nicu-daycare', 'Nurse\NicuNurseDaycareController');

    Route::get('nurse-nicu-daycare-admission/{data}', 'Nurse\NicuNurseDaycareController@getAdmissionid');

    Route::get('nurse-nicu-daycare-sublist/{data}', 'Nurse\NicuNurseDaycareController@nicuDaycarebabySublist');

    Route::get('nurse-nicu-daycare-daylist/{data}', 'Nurse\NicuNurseDaycareController@nicuDaycareadmissionList');

    Route::get('daycare-icd-list', 'Admission\DaycareController@Icdlist');

    Route::resource('daycare-search', 'Search\SearchDaycareController');

    Route::resource('quality-indicator-search', 'Search\SearchQualityController');

    Route::get('quality-indicator-searchview/{id}', 'Search\SearchQualityController@qualitysearchview');

    Route::post('quality-indicator-downloads', 'Search\SearchQualityController@qualityListdownload');

    Route::get('daycare-search-index/{id}', 'Search\SearchDaycareController@index');

    Route::get('daycare-search-box-view/{id}', 'Search\SearchDaycareController@daycareSearchview');

    Route::get('daycare-search-list-view/{id}', 'Search\SearchDaycareController@daycareListview');

    Route::post('daycare-search-export', 'Search\SearchDaycareController@daycareListdownload');

    Route::get('mother-mrnumber-check', 'Registration\MotherController@mrcheck');

    Route::get('baby-mrnumber-check', 'Registration\BabyController@mrcheck');

    Route::resource('problems-systems', 'ProblemBaseDaycare\ProblemDaycareController');

    Route::resource('problem-systems-postnatal', 'ProblemBaseDaycare\ProblemPostnatalController');

    Route::get('postproblems-systems-admissions/{id}', 'ProblemBaseDaycare\ProblemPostnatalController@admissionlist');

    Route::get('postproblem-systems-episodes/{id}', 'ProblemBaseDaycare\ProblemPostnatalController@episodeslist');

    Route::get('postproblems-systems-create/{id}', 'ProblemBaseDaycare\ProblemPostnatalController@create');

    Route::get('postproblems-systems-remove/{id}', 'ProblemBaseDaycare\ProblemPostnatalController@getRemoveEpisode');

    Route::get('problems-systems-create/{id}', 'ProblemBaseDaycare\ProblemDaycareController@create');

    Route::get('problems-systems-admissions/{id}', 'ProblemBaseDaycare\ProblemDaycareController@admissionlist');

    Route::get('problem-systems-episodes/{id}', 'ProblemBaseDaycare\ProblemDaycareController@episodeslist');

    Route::get('problem-systems-admissionlist/{id}', 'ProblemBaseDaycare\ProblemDaycareController@getadmission');

    Route::get('problems-systems-components/{data}', 'ProblemBaseDaycare\ProblemDaycareController@getProblemfields');

    Route::get('problem-systems-remove/{id}', 'ProblemBaseDaycare\ProblemDaycareController@getRemoveEpisode');

    Route::get('problems-discharge-baby-list/{summary_type?}', 'Reports\ProblemDischargeController@dischargeBabylist');

    Route::get('problems-discharge-admission-list/{id}/{summary_type?}', 'Reports\ProblemDischargeController@dischargeAdmissionlist');

    Route::get('problems-discharge-summary/{id}/{summary_type?}', 'Reports\ProblemDischargeController@dischargeSummary');

    Route::resource('postproblem-systems-summary', 'Reports\PostnatalDischargeSummary');

    Route::get('growthchart-baby-list', 'Growthchart\GrowthChartController@index');

    Route::get('growthchartzerotofive/{babyid}', 'Growthchart\GrowthChartController@growthwhochartzerotofiveyears');

    Route::get('growthchart-view/{id}', 'Growthchart\GrowthChartController@GenearateGrowthChart');

    Route::get('growthchart-who-view/{id}', 'Growthchart\GrowthChartController@GenearateWhoGrowthChart');

    Route::get('postproblem-discharge-sublist/{baby_id}', 'Reports\PostnatalDischargeSummary@postnatalSublist');

    Route::resource('nicu-nurse-sheets', 'Nurse\NurseSheetController');

    Route::get('nicu-nurse-sheet-admission/{baby_id}', 'Nurse\NurseSheetController@GetAdmissionlist');

    Route::get('nicu-radiology/{baby_id}', 'Nurse\NurseSheetController@GetRadiology');

    Route::get('nicu-nurse-sheet-print/{baby_id}/{date}/{admission_id}', 'Nurse\NurseSheetController@prescriptionprint');

    Route::get('nicu-nurse-sheet-day/{admission_id}/{closelink?}', 'Nurse\NurseSheetController@GetDaylist');

    Route::get('nicu-nurse-sheet-graph/{baby_id}/{admission_id}', 'Nurse\NurseChartController@graphicalview');

    Route::get('nicu-nurse-sheet-graph-data/{baby_id}/{admission_id}', 'Nurse\NurseChartController@graphicaldata');

    Route::get('nicu-nurse-sheet-vendilator-data/{baby_id}/{admission_id}', 'Nurse\NurseChartController@vendilatorgraphicaldata');

    Route::get('nicu-nurse-sheet-print/{day_id}/{closewinlink?}', 'Nurse\NurseSheetController@print');

    Route::get('newbornscreen-report', 'Reports\NewbornScreenController@filter');

    Route::post('newbornscreen-report', 'Reports\NewbornScreenController@index');

    Route::get('nicu-nurse-admission-list/{babyid}', 'Nurse\NurseSheetController@getipadmissionid');

    Route::get('nicu-nurse-sheet-spoturinetotal', 'Nurse\NurseSheetController@getsporturinetotal');

    Route::get('nicu-nurse-sheets-blood-values/{baby_id}', 'Nurse\NurseSheetController@getbloodvalues');

    Route::get('nicu-nurse-sheets-admission/get-prescription-url', 'Nurse\NurseSheetController@getnuresurl');

    Route::get('nicu-nurse-sheets-admission/nicu-nurse-running-total', 'Nurse\NurseSheetController@calculaterunningtotal');

    Route::get('nicu-nurse-sheets/get-weekly-observations/{admission_id}/{admission_date}', 'Nurse\NurseSheetController@getWeeklyObservations');

    Route::get('nicu-nurse-sheets/get-admission-list/{babyid}', 'Nurse\NurseSheetController@GetAdmissionLists');

    Route::get('c-cda/convert', 'Ccda\CcdaController@ccdadecorde');

    Route::get('c-cda/encode/{baby_id}', 'Ccda\CcdaController@ccdaencode');

    Route::resource('complaints', 'Settings\ComplaintsController');

    Route::resource('quality-indicator', 'Quality\QualityController');

    Route::get('/cache', 'Settings\SiteController@cache');

    Route::get('quality-indicator-import/{baby_id}', 'Quality\QualityImportController@importbaby');

    Route::get('quality-indicator-excel', 'Quality\QualityImportController@importbabyexcel');

    Route::post('export-baby', 'Quality\QualityController@exportbaby');

    Route::get('snomed-concept-lists/{limit}/{definition}/{status}', 'Snomed\SnomedConceptController@getConceptlists');

    Route::get('snomed-description-lists/{term}/{status}/{type}/{limit}', 'Snomed\SnomedDescriptionController@getdescriptionlist');

    Route::post('audio-file-recording/{baby_id}/{module_id}/{admission_id}/{field_id}/{module_slug}', 'Audio\AudioFileController@createaudio');

    Route::get('audio-file-list', 'Audio\AudioFileController@index');

    Route::get('audio-file-module-list/{baby_id}', 'Audio\AudioFileController@getModuleList');

    Route::get('google-client', 'GoogleApis\GoogleSpeechApiController@index');

    Route::delete('approve-all/{id}', 'Settings\DeleteApprovalController@getprocess');

    Route::get('stream-test', 'Registration\OpController@getoplisner');

    Route::get('appointment-calendar', 'HomeController@calendar');

    Route::resource('ward-dashboard', 'Ward\BabyWardController');

    Route::resource('patient-history', 'Ward\PatientLogHistoryController');

    Route::get('get-bed-details/{room_id}', 'Ward\PatientLogHistoryController@getBedDetails');

    Route::get('update-bed-details/{room_id}', 'Ward\PatientLogHistoryController@updateBedDetails');

    Route::resource('room-management', 'Masters\RoomManagementController');

    Route::post('update-bed-log', 'Ward\BabyWardController@getupdatebedlog');

    Route::get('add-bed-log', 'Ward\BabyWardController@getaddbabytobed');

    Route::get('baby-bed-interchange', 'Ward\BabyWardController@getbabyinterchange');

    Route::get('update-ward-view', 'Ward\BabyWardController@updateView');

    Route::get('get-baby-bed-info', 'Ward\BabyWardController@getBabyBedDetails');

    Route::resource('interface-log', 'interfacelog\InterfaceMachineController');

    //Route::get('rate-check', 'Audio\AudioFileController@getAudiodetails');

    Route::resource('remove-baby-record', 'Search\RemoveBabyRecordController');

    Route::get('search-baby-reports/{babyid}', 'Search\RemoveBabyRecordController@index');

    Route::get('remove-mother-reports/{babyid}/{motherid}', 'Search\RemoveBabyRecordController@mother_destroy');

    Route::get('remove-baby-reports/{babyid}', 'Search\RemoveBabyRecordController@baby_destroy');

    Route::get('remove-neonatal-performa/{babyid}/{neonatalid}', 'Search\RemoveBabyRecordController@neonatal_performa_destroy');

    Route::get('remove-nicu/{babyid}/{nicuid}', 'Search\RemoveBabyRecordController@nicu_destroy');

    Route::get('remove-postnatal/{babyid}/{postnatalid}', 'Search\RemoveBabyRecordController@postnatal_destroy');

    Route::get('remove-nicu-daycare/{id}', 'Search\RemoveBabyRecordController@nicu_daycare_destroy');

    Route::get('remove-postnatal-daycare/{id}', 'Search\RemoveBabyRecordController@postnatal_daycare_destroy');

    Route::get('remove-postnatal-discharge/{nicuid}', 'Search\RemoveBabyRecordController@postnatal_discharge_destroy');

    Route::get('remove-op/{id}', 'Search\RemoveBabyRecordController@op_destroy');

    Route::get('echocardiography-destroy/{id}', 'Search\RemoveBabyRecordController@echocardiography_destroy');

    Route::get('cranial-destroy/{id}', 'Search\RemoveBabyRecordController@cranial_ultrasonography_destroy');

    Route::patch('patient-detail-update/{id}', 'Flow\FlowController@patientDetailUpdate');

    Route::get('patient-detail-edit/{id}', 'Flow\FlowController@patientDetailEdit');

    Route::resource('readmission', 'ReAdmissionController');

    Route::resource('masters/ward', 'Masters\WardController');

    Route::resource('masters/bed', 'Masters\BedController');

    Route::get('fhir-format-value/{id}/{value_type}', 'Fhir\FhirFormattedValuesController@show');

    Route::resource('fhir-format-value', 'Fhir\FhirFormattedValuesController');

    Route::get('monitor-values', 'Fhir\FhirFormattedValuesController@monitordata');

    Route::get('ventilator-values', 'Fhir\FhirFormattedValuesController@ventilatordata');

    Route::get('pump-values', 'Fhir\FhirFormattedValuesController@pumpdata');

    Route::get('oral-drugs-export', 'Fhir\FhirFormattedValuesController@oraldrugs');

    // Route::get('fhir-schemas-list','Fhir\FhirSchemaController@index');

    Route::resource('syrange-pump-request', 'Syringepump\SyrangePumpController');

    Route::resource('fhir-json-schema', 'Fhir\FhirJsonSchemaController');

    Route::resource('prescription', 'prescription\PrescriptionController');

    Route::get('prescription/{id}/{closelink?}', 'prescription\PrescriptionController@show');

    Route::get('prescription-print/{baby_id}/{admission_id}/{date}/{closewinlink?}', 'prescription\PrescriptionController@print');

    Route::get('prescription-get-admission/{id}', 'prescription\PrescriptionController@getprescriptionadmission');

    Route::get('downloads-prescription/{baby_mrn}/{base_id}/{baby_id}/{admission_id}', 'prescription\PrescriptionController@getDownloadPumpData');

    Route::get('iv-infusion-form/{baby_id}/{admission_id}/{id}', 'prescription\PrescriptionController@getIvDrugInfusionForm');

    Route::patch('iv-infusion-update', 'prescription\PrescriptionController@addIvDrugInfusionupdate');

    Route::get('other-iv-drugs-form/{baby_id}/{admission_id}/{id}', 'prescription\PrescriptionController@getOtherIvDrugsForm');

    Route::patch('other-iv-drugs-update', 'prescription\PrescriptionController@addOtherIvDrugupdate');

    Route::get('other-iv-infusion-form/{baby_id}/{admission_id}/{id}', 'prescription\PrescriptionController@getOtherIvInfusionForm');

    Route::patch('other-iv-infusion-update', 'prescription\PrescriptionController@addOtherIvInfusionupdate');

    Route::get('glucose-intake-form/{baby_id}/{admission_id}/{id}', 'prescription\PrescriptionController@getGlucoseIntakeForm');

    Route::patch('glucose-intake-update', 'prescription\PrescriptionController@getGlucoseIntakeupdate');

    Route::get('oral-rectal-form/{baby_id}/{admission_id}/{id}', 'prescription\PrescriptionController@getOralRectalForm');

    Route::patch('oral-rectal-update', 'prescription\PrescriptionController@getOralRectalUpdate');

    Route::get('prescription-remove', 'prescription\PrescriptionController@getPrescriptionRemove');

    Route::post('prescription-status-changes', 'prescription\PrescriptionController@getPrescriptionStatusChange');

    Route::get('prescription-discharge/{id}', 'prescription\PrescriptionController@getDischarge');

    Route::get('prescription-log', 'prescription\PrescriptionController@getPrescriptionLog');

    // Route::get('ivdruginfusion-resend/{drug_id}','prescription\PrescriptionController@IvdrugInfusionresend');

    // Route::get('otherivdrugs-resend/{drug_id}','prescription\PrescriptionController@OtherIvdrugsresend');

    // Route::get('otherivinfusion-resend/{drug_id}','prescription\PrescriptionController@OtherIvinfusion');

    // Route::get('specialivfluids-resend/{drug_id}','prescription\PrescriptionController@SpecialIvfluids');

    Route::post('resend', 'prescription\PrescriptionController@resendPrescription');

    Route::get('prescription-data', 'prescription\PrescriptionController@prescriptionData');

    Route::get('get-previous-fluids/{baby_id}/{admission_id}/{previous_day}', 'Nurse\NurseSheetController@getPreviousfluids');

    Route::resource('infusion-pump', 'infusion\InfusionController');

    Route::get('discharge-baby', 'Ward\BabyWardController@dischargeurl');

    Route::resource('nurse-observation-chart', 'Nurse\NurseObservationChartController');

    Route::get('get-chart-observation/{mrn}/{snomed_code}/{ip_number}/{key_name}', 'Nurse\NurseObservationChartController@getChartValues');

    Route::get('list-monitor-values/{babyid}/{admissionid}', 'fhirformate\MonitorFormatController@getMonitordetails');

    Route::get('list-infusion-values/{babyid}/{admissionid}', 'fhirformate\InfusionPumpFormatController@infusionSyringelist');

    Route::get('lab-value-print', 'Nurse\NurseSheetController@labValuePrint');

    Route::get('lab-invite/{admissionid}/{slug}', 'Nurse\LabImportedController@labInvite');

    Route::get('list-vendilator-values/{babyid}/{admissionid}', 'fhirformate\VendilatorFormatController@VendilatorList');

    Route::get('multiple-chart/{babyid}/{admissionid}/{sheetdate}/{slug}', 'Nurse\MultipleChartContoller@show');

    Route::get('multiple-list-chart/{babyid}/{admissionid}/{selectedstartdate}/{selectedenddate}', 'Nurse\MultipleChartContoller@multipleChart');

    Route::get('multiple-chart-data/{babyid}/{admissionid}/{sheetdate}', 'Nurse\MultipleChartContoller@multiChartData');

    Route::get('multiple-single-chart/{babyid}/{admissionid}/{paramname}', 'Nurse\MultipleChartContoller@multipleSingleChart');

    Route::resource('snomedct-list', 'Snomed\SnomedCodeController');

    Route::get('snomed-concept-lists/{limit}/{definition}/{status}', 'Snomed\SnomedConceptController@getConceptlists');

    Route::get('snomed-description-lists/{term}/{status}/{type}/{limit}', 'Snomed\SnomedDescriptionController@getdescriptionlist');

    Route::get('snomed-medicine-view/{searchText}', 'Snomed\SnomedConceptController@getMedicineView');

    Route::get('snomed-medicine-lists/{searchText}', 'Snomed\SnomedConceptController@getMedicineLists');

    Route::resource('lab-request-list', 'Lab\LabRequestController');

    Route::get('lab-request-print/{id}', 'Lab\LabRequestController@print');

    Route::get('lab-request-investigation/{id}', 'Lab\LabRequestController@getInvestigations');

    Route::get('nurse-sheet-prescription/{baby_id}/{admission_id}', 'Nurse\NurseSheetController@getPrintPrescription');

    Route::patch('store-working-weight', 'prescription\PrescriptionController@storeWorkingWeight');

    Route::get('get-medicine-brand/{id}', 'Masters\DrugAndInfusionController@getBrandName');

    Route::get('get-medicine-generic', 'Masters\DrugAndInfusionController@getGenericName');

    Route::get('prescription-screen', 'Masters\DrugAndInfusionController@getprescription');

    Route::resource('drug-and-infusion', 'Masters\DrugAndInfusionController');

    Route::get('print-filter-by-date/{babyid}/{admissionid}/{fromdate}/{todate}', 'prescription\PrescriptionController@printFilteredByDate');

    Route::get('print/{id}', 'Quality\QualityController@print');

    Route::resource('photo-video', 'PhotoVideoUploadController');

    Route::post('video-upload', 'PhotoVideoUploadController@uploadVideo');

    Route::post('photo-upload', 'PhotoVideoUploadController@uploadPhoto');

    Route::get('photo-delete', 'PhotoVideoUploadController@deletePhoto');

    Route::get('video-delete', 'PhotoVideoUploadController@deleteVideo');

    // Route::resource('nurse-automatic-sheet', 'Nurse\NurseAutoController');

    // Route::get('nurse-automatic-sheet-admission/{baby_id}','Nurse\NurseAutoController@GetAdmissionlist');

    // Route::get('nurse-automatic-sheet-day/{admission_id}','Nurse\NurseAutoController@GetDaylist');

    // Route::get('nurse-automatic-print/{baby_id}','Nurse\NurseAutoController@print');

    // Route::get('nurse-automatic-admission/nicu-nurse-running-total', 'Nurse\NurseAutoController@calculaterunningtotal');

    // Route::get('nurse-automatic-spoturinetotal','Nurse\NurseAutoController@getsporturinetotal');

    Route::post('other_iv_drugs_repeat_prescription/{drug_id}/{val}', 'prescription\PrescriptionController@OtherIvDrugsRepeatPrescription');

    Route::get('repeat-prescription-status', 'prescription\PrescriptionController@getUpdateRepeatPrescription');

    Route::get('prescription-status-update', 'prescription\PrescriptionController@prescriptionStatusList');

    Route::resource('nurse-sheets-manual', 'NurseManual\NurseManualController');

    Route::get('nurse-sheets-manual-print/{day_id}', 'NurseManual\NurseManualController@print');

    Route::get('nurse-sheets-manual-admission/{baby_id}', 'NurseManual\NurseManualController@GetAdmissionlist');

    Route::get('nurse-sheets-manual-running-total', 'NurseManual\NurseManualController@calculaterunningtotal');

    Route::get('nurse-sheets-manual-spoturinetotal', 'NurseManual\NurseManualController@getsporturinetotal');

    Route::get('nurse-sheets-manual-day/{admission_id}', 'NurseManual\NurseManualController@GetDaylist');

    Route::get('nurse-sheets-manual-graph/{baby_id}', 'NurseManual\NurseManualChartController@graphicalview');

    Route::get('nurse-sheets-manual-graph-data/{baby_id}', 'NurseManual\NurseManualChartController@graphicaldata');

    Route::get('nurse-sheets-manual-ventilator-data/{baby_id}', 'NurseManual\NurseManualChartController@vendilatorgraphicaldata');

    Route::get('nurse-sheets-manual-multiple-chart/{babyid}/{admissionid}/{sheetdate}', 'NurseManual\MultipleChartContoller@show');

    Route::get('nurse-sheets-manual-multiple-chart-data/{babyid}/{admissionid}/{sheetdate}', 'NurseManual\MultipleChartContoller@multiChartData');

    Route::get('nurse-sheets-manual-multiple-list-chart/{babyid}/{admissionid}/{sheetdate}/{sheetdate1}', 'NurseManual\MultipleChartContoller@multipleChart');

    Route::get('nurse-sheets-manual-multiple-single-chart/{babyid}/{admissionid}/{paramname}', 'NurseManual\MultipleChartContoller@multipleSingleChart');

    Route::get('nurse-sheets-manual-print-latest', 'NurseManual\NurseManualController@getLatestPrint');

    Route::post('terminate-prescription', 'prescription\PrescriptionController@getTerminatePrescription');

    Route::post('nicu-problem-base-discharge-reports', 'Reports\ProblemDischargeController@store');

    Route::get('neonatal-reports-editors', 'Registration\NeonatalController@getfullEditor');

    Route::get('neonatal-abbreviated/{data}', 'Registration\NeonatalController@getAbbreviatedsummaryShow');

    Route::post('neonatal-reports-save', 'Registration\NeonatalController@saveFullEditor');

    Route::get('nicu-adm-reports-editors', 'Admission\NicuController@getfullEditor');

    Route::get('nicu-adm-abbreviated/{data}', 'Admission\NicuController@getAbbreviatedsummaryShow');

    Route::post('nicu-adm-reports-save', 'Admission\NicuController@saveFullEditor');

    Route::get('nicu-daycare-reports-editors', 'Admission\DaycareController@getfullEditor');

    Route::get('nicu-daycare-abbreviated/{data}', 'Admission\DaycareController@getAbbreviatedsummaryShow');

    Route::post('nicu-daycare-reports-save', 'Admission\DaycareController@saveFullEditor');

    Route::get('nicu-pblm-disch-reports-editors/{summary_type?}', 'Reports\ProblemDischargeController@getfullEditor');

    Route::get('nicu-pblm-disch-abbreviated/{data}/{summary_type?}', 'Reports\ProblemDischargeController@getAbbreviatedsummaryShow');

    Route::post('nicu-pblm-disch-reports-save/{summary_type?}', 'Reports\ProblemDischargeController@saveFullEditor');

    Route::get('op-reports-editors', 'Registration\OpController@getfullEditor');

    Route::get('op-abbreviated/{data}', 'Registration\OpController@getAbbreviatedsummaryShow');

    Route::post('op-reports-save', 'Registration\OpController@saveFullEditor');

    Route::get('hrs-sheet-editors', 'NurseManual\NurseManualController@getfullEditor');

    Route::get('hrs-sheet-abbreviated/{data}', 'NurseManual\NurseManualController@getAbbreviatedsummaryShow');

    Route::post('hrs-sheet-save', 'NurseManual\NurseManualController@saveFullEditor');

    Route::get('postnatal-reports-editors', 'Admission\PostnatalController@getfullEditor');

    Route::get('postnatal-abbreviated/{data}', 'Admission\PostnatalController@getAbbreviatedsummaryShow');

    Route::post('postnatal-reports-save', 'Admission\PostnatalController@saveFullEditor');

    Route::get('postnatal-daycare-reports-editors', 'Admission\PostnatalDaycareController@getfullEditor');

    Route::get('postnatal-daycare-abbreviated/{data}', 'Admission\PostnatalDaycareController@getAbbreviatedsummaryShow');

    Route::post('postnatal-daycare-reports-save', 'Admission\PostnatalDaycareController@saveFullEditor');

    Route::get('postnatal-daycare-reports-editors', 'Admission\PostnatalDaycareController@getfullEditor');

    Route::get('postnatal-summary-reports-editors', 'Reports\PostnatalDischargeSummary@getfullEditor');

    Route::get('postnatal-summary-abbreviated/{data}', 'Reports\PostnatalDischargeSummary@getAbbreviatedsummaryShow');

    Route::post('postnatal-summary-reports-save', 'Reports\PostnatalDischargeSummary@saveFullEditor');

    Route::get('daycare-reassessment/create', 'Admission\DaycareController@reassessmentCreate');

    Route::post('daycare-reassessment', 'Admission\DaycareController@reassessmentSheetStore');

    Route::post('problems-discharge-summary-save', 'Reports\ProblemDischargeController@store');

    Route::get('testtemplate', 'HomeController@testlog');

    Route::get('get-master-table-fields/{master_table}', 'Masters\MasterController@getMasterTableFields');

    Route::post('save_master_data', 'Masters\MasterController@saveMasterData');

    Route::post('review-date-update', 'prescription\PrescriptionController@updateReviewDate');

    Route::post('change-prescription-time', 'prescription\PrescriptionController@updatePrescriptionTime');

    Route::get('prescription-edit', 'prescription\PrescriptionController@editPrescription');

    Route::patch('save-allegries', 'Registration\BabyController@updateAllegries');

    Route::get('prescription-generate', 'prescription\PrescriptionController@createprescription');

    Route::get('recently-prescribe', 'prescription\PrescriptionController@recentlyprescribe');

    Route::get('hero', 'Nurse\NurseSheetController@getHeroScore');

    Route::get('download-hero-score/{baby_mrn}/{baby_name}/{baby_id}/{mindate}/{maxdate}', 'Nurse\NurseSheetController@getDownloadHeroScore')->where('baby_name', '(.*)');

    Route::patch('pump-data-approval', 'prescription\PrescriptionController@pumpDataApproval');

    Route::patch('pump-data-update', 'prescription\PrescriptionController@pumpDataUpdate');

    Route::get('pump-data-info', 'prescription\PrescriptionController@pumpDataInfo');

    Route::get('dsn-current-status', 'DSNotificationController@getDsnCurrentStatus');

    Route::patch('disconnect-status-update', 'DSNotificationController@disconnectStatusUpdate');

    Route::get('dsn-connect-device', 'DSNotificationController@getConnectedDevice');

    Route::get('check-record-is-exists', 'Registration\BabyController@checkRecordIsExists');

    Route::get('nicu-admission/create/{data}', 'Admission\NicuController@create');

    Route::get('lab-baby-select/{type?}', 'Nurse\NurseSheetController@labBabySelect');

    Route::get('weekly-observation-baby-select', 'Nurse\NurseSheetController@weeklyObservationBabySelect');

    Route::get('all-in-one-chart-baby-select', 'Nurse\NurseSheetController@allInOneChartBabySelect');

    Route::get('chart-baby-select', 'Nurse\NurseSheetController@chartBabySelect');

    Route::get('get-admission', 'Nurse\NurseSheetController@getAdmissionId');

    Route::get('get-admission', 'Nurse\NurseSheetController@getAdmissionId');

    Route::get('prescription-filter', 'prescription\PrescriptionController@prescriptionDateFilter');

    Route::get('prescription-default-value-fetch', 'prescription\PrescriptionController@fetchDefaultValue');

    Route::get('nicu-nurse-sheet-pump-data', 'Nurse\NurseSheetController@getPumpData');

    Route::get('nicu-nurse-sheet-monitor-data', 'Nurse\NurseSheetController@getMonitorData');

    Route::get('nicu-nurse-sheet-ventilator-data', 'Nurse\NurseSheetController@getVentilatorData');

    Route::get('nicu-nurse-sheet-lab-data', 'Nurse\NurseSheetController@getLabData');

    Route::patch('machine-data-approval', 'Nurse\NurseSheetController@machineDataApproval');

    Route::patch('machine-data-update', 'Nurse\NurseSheetController@machineDataUpdate');

    Route::get('prescription-filter', 'prescription\PrescriptionController@prescriptionDateFilter');

    Route::get('check-nuero-record-exist', 'Registration\OpController@checkNeuroRecordExist');

    Route::get('print-nuero-report/{op_id}', 'Registration\OpController@printNeuroDevelopmentReport');

    Route::get('select-prescription', 'prescription\PrescriptionController@selectPrescription');

    Route::get('generate-ddst-pdf/{op_id}', 'Registration\OpController@generateDDSTPdf');

    Route::get('get-today-machine-records', 'Admission\DaycareController@getTodayMachineRecords');

    Route::post('nicu-discharge-summary-save-printed-content', 'Reports\NicuDischargeController@savePrintedContent');

    Route::get('nicu-discharge-summary-get-printed-content', 'Reports\NicuDischargeController@getPrintedContent');

    Route::get('nicu-discharge-summary-get-printed-html-content', 'Reports\NicuDischargeController@getPrintedHtmlContent');

    Route::patch('nicu-discharge-summary-add-approvals', 'Reports\NicuDischargeController@summaryApproval');

    Route::get('live-chart', 'Nurse\NurseSheetController@liveChart');

    Route::get('get-interface-details', 'InterfaceData\InterfaceDataController@getInterfaceData');

    Route::get('get-interface-parameter', 'InterfaceData\InterfaceDataController@getInterfaceParameter');

    Route::get('get-baby-result-timing', 'InterfaceData\InterfaceDataController@getStartTime');

    Route::get('get-event-list', 'InterfaceData\InterfaceDataController@getEventList');

    Route::resource('local-code-group', 'LocalCodeGroupController');

    Route::get('get-interface-data-accuracy', 'InterfaceData\InterfaceDataController@getInterfaceDataAccuracy');

    Route::get('baby-data/{mrn}/{admissionid}', 'InterfaceData\InterfaceDataController@babyData');

    Route::post('nicu-prblm-discharge-summary-save-printed-content', 'Reports\ProblemDischargeController@savePrintedContent');

    Route::get('nicu-prblm-discharge-summary-get-printed-content', 'Reports\ProblemDischargeController@getPrintedContent');

    Route::get('nicu-prblm-discharge-summary-get-printed-html-content', 'Reports\ProblemDischargeController@getPrintedHtmlContent');

    Route::patch('nicu-prblm-discharge-summary-add-approvals', 'Reports\ProblemDischargeController@summaryApproval');

    Route::post('postnatal-summary-save-printed-content', 'Reports\PostnatalDischargeSummary@savePrintedContent');

    Route::get('postnatal-summary-get-printed-content', 'Reports\PostnatalDischargeSummary@getPrintedContent');

    Route::get('postnatal-summary-get-printed-html-content', 'Reports\PostnatalDischargeSummary@getPrintedHtmlContent');

    Route::patch('postnatal-summary-add-approvals', 'Reports\PostnatalDischargeSummary@summaryApproval');

    Route::get('nicu-discharge/{id}', 'Admission\NicuController@dischargeedit');

    Route::patch('nicu-discharge-update/{id}', 'Admission\NicuController@dischargeupdate');

    Route::get('demo-chart', 'Nurse\DashboardEventController@getCharts');

    Route::get('get-baby-details-from-his', 'Fhir\HmsInterfacingController@getBabyDetails');

    Route::get('get-mother-details-from-his', 'Fhir\HmsInterfacingController@getMotherDetails');

    Route::get('get-visit-no-from-his', 'Fhir\HmsInterfacingController@getVisitNumber');

    Route::get('lab-report-import', 'Fhir\LabFhirFormateController@getSingleLabReport');

    Route::patch('op-page-spacing', 'Settings\SiteController@opPageSpacing');

    //Route::get('clinical-events/{id}', 'ClinicalEventController@show');

    Route::post('remove-clinical-event', 'ClinicalEventController@removeEvent');

    Route::get('select-clinical-event', 'ClinicalEventController@select');

    Route::get('get-admission/{id}', 'ClinicalEventController@getAdmission');

    Route::resource('clinical-events', 'ClinicalEventController');

    Route::get('who-g5-growth-chart', 'charts\WhoGrowthChartcontroller@greaterthanfive');

    Route::resource('who-growth-chart', 'charts\WhoGrowthChartcontroller');
    Route::resource('zscore-growth-chart', 'charts\ZScoreChartController');

    Route::get('overall-lab-value-print/{baby_id}', 'Nurse\NurseSheetController@overallLabValuePrint');

    Route::resource('inter-growth-chart', 'charts\InterGrowthChartController');

    Route::get('get-saraswathi-mrn', 'Registration\BabyController@getSaraswathiMrn');

    Route::get('get-saraswathi-ip', 'Registration\BabyController@getSaraswathiIp');

    Route::get('neuro-develop/select', 'Registration\NeuroController@chooseBaby');

    Route::get('neuro-develop/visite-list/{data}', 'Registration\NeuroController@NeuroSubList');

    Route::get('neuro-develop/create/{data}', 'Registration\NeuroController@create');

    Route::get('neuro-develop/get-baby-visit/{baby_id}', 'Registration\NeuroController@opVisit');

    Route::post('save-ddst', 'Registration\NeuroController@saveddst');

    Route::get('interpret-ddst', 'Registration\NeuroController@interpretddst');

    Route::get('ddst', 'Registration\NeuroController@ddst');

    Route::get('get-baby-background-details/{mrn}', 'Registration\NeuroController@getBabyBackgroundDetails');

    Route::get('get-previous-eligibility-details/{mrn}', 'Registration\NeuroController@getPreviousEligibilityDetails');

    Route::get('neuro-assessment-print/{id}', 'Registration\NeuroController@assessmentprint');

    Route::get('neuro-develop/import', 'Registration\NeuroController@import');

    Route::resource('neuro-develop', 'Registration\NeuroController');

    Route::get('get-baby-details/{mrn}', 'Registration\BabyController@getBabyDetails');

    Route::get('get-pump-list', 'InterfaceData\InterfaceDataController@getPumpResults');

    Route::post('hms-quick-reg', 'Fhir\HmsInterfacingController@registerPatientInHMS');

    Route::get('update-hms-reg-baby', 'Fhir\HmsInterfacingController@updateQuickRegBabyDetails');

    Route::get('update-hms-reg', 'Fhir\HmsInterfacingController@updateQuickReg');

    Route::get('patient-status', 'Ward\BabyWardController@getPatientStatus');

    Route::get('ward-basic-reg', 'Flow\FlowController@wardBasicReg');

    Route::get('pacs/{mrn?}', 'Ward\BabyWardController@pacs');

    Route::post('image-upload', 'DocumentsUploadController@upload');

    Route::post('image-delete', 'DocumentsUploadController@deleteuploads');

    Route::get('get-uploaded-files', 'DocumentsUploadController@getUploadedFile');

    Route::get('ward-dashboard-view', 'Ward\BabyWardController@wardview');

    Route::post('ward-dashboard-view-update', 'Ward\BabyWardController@wardDashboardViewUpdate');

    Route::get('usage-track', 'Reports\UsageTrackController@list');

    Route::resource('tpn-calculator', 'Calculators\TpnCalculatorController');

    Route::get('get-latest-weight/{id?}', 'Calculators\TpnCalculatorController@getLatestWeight');

    Route::get('export-lab-report', 'Fhir\LabFhirFormateController@exportLabReport');

    Route::get('export-lab-report-live', 'Fhir\LabFhirFormateController@exportLabReportLive');

    Route::get('get-patient-ward-menu', 'Ward\BabyWardController@getBabyWardMenu');

    Route::get('get-pacs-viewer/{uhid}', 'Nurse\NurseSheetController@pacsViewer');

    Route::get('comparison-charts', 'Fhir\RangeComparisonChartController@show');

    Route::get('range-comparison-charts', 'Fhir\RangeComparisonChartController@rangeData');

    Route::get('table-comparison-charts', 'Fhir\RangeComparisonChartController@tableData');

    Route::get('hour-wise-range-data', 'Fhir\RangeComparisonChartController@hourWiseRangeData');

    Route::get('fio2-charts', 'Fhir\RangeComparisonChartController@fio2Show');

    Route::get('fio2-calculation-charts', 'Fhir\RangeComparisonChartController@fio2CalculationData');

    Route::get('get-bed-list', 'Ward\BabyWardController@getBedList');

    Route::get('neonatal-time-line', 'HomeController@getTimelinePage');

    Route::get('same-date-exist', 'Registration\OpController@chekcSameDateIsExist');

    Route::get('get-pacs-studies', 'Ward\BabyWardController@getPacsStudies');

    Route::get('get-contact-number', 'HomeController@getContactNumbers');

    Route::get('care-event-list', 'Nurse\DashboardEventController@index');

    Route::get('care-event-chart', 'Nurse\DashboardEventController@chart');

    Route::get('care-event-chart-details', 'Nurse\DashboardEventController@getChartDetails');

    Route::resource('nicu-search', 'Search\NicuController');

    Route::get('nicu-search-view/{id}', 'Search\NicuController@searchview');

    Route::post('nicu-search-export', 'Search\NicuController@download');

    Route::resource('postnatal-search', 'Search\PostnatalController');

    Route::get('postnatal-search-view/{id}', 'Search\PostnatalController@searchview');

    Route::post('postnatal-search-export', 'Search\PostnatalController@download');

    Route::resource('neonatal-search', 'Search\NeonatalController');

    Route::get('neonatal-search-view/{id}', 'Search\NeonatalController@searchview');

    Route::post('neonatal-search-export', 'Search\NeonatalController@download');

    Route::resource('pediatric-search', 'Search\PediatricController');

    Route::get('pediatric-search-view/{id}', 'Search\PediatricController@searchview');

    Route::post('pediatric-search-export', 'Search\PediatricController@download');

    Route::resource('neuro-search', 'Search\NeuroController');

    Route::get('neuro-search-view/{id}', 'Search\NeuroController@searchview');

    Route::post('neuro-search-export', 'Search\NeuroController@download');

    Route::get('ecg/{mrn?}', 'Nurse\NurseSheetController@ecgchart');

    Route::get('feeding/visite-list/{data}', 'Registration\FeedingController@subList');

    Route::get('feeding/create/{data}', 'Registration\FeedingController@create');

    Route::get('feeding/mother-select', 'Registration\FeedingController@chooseMother');

    Route::get('feeding/baby-select', 'Registration\FeedingController@chooseBaby');

    Route::resource('feeding', 'Registration\FeedingController');

    Route::post('infants-reports', 'Registration\NeuroController@infantChart');

    Route::post('preschoolers-reports', 'Registration\NeuroController@preschoolersChart');

    Route::post('fetch-shortcode-description', 'Masters\ShortcodeController@fetchDescription');

    Route::resource('masters/shortcode-list', 'Masters\ShortcodeController');

    Route::get('nicu-time-line', 'HomeController@getNICUTimelinePage');

    Route::get('nnf-report', 'Reports\NNFController@filter');

    Route::post('nnf-report', 'Reports\NNFController@index');

    Route::get('nsofa-report', 'Reports\NsofaController@index');

    Route::get('nsofa-report-view', 'Reports\NsofaController@show');

    Route::get('msns-report', 'Reports\MSNSController@index');

    Route::get('msns-report-view', 'Reports\MSNSController@show');
    Route::get('msns-get-admission/{baby_id}', 'Reports\MSNSController@getAdmissions');

    Route::get('nutrition-chart-report', 'Reports\NutritionChartController@index');

    Route::get('nutrition-chart-report-data', 'Reports\NutritionChartController@getNutritionData');

    Route::get('nutrition-chart-export', 'Reports\NutritionChartController@export');

    Route::get('get-nutrition-data', 'Reports\NutritionChartController@getNutritionDataByDateWise');

});