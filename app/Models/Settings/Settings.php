<?php namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Settings extends Model 
{

	protected $table      = 'site_settings';
	protected $primaryKey = 'SiteId';
	public $timestamps    =  false;
	protected $fillable   = ['LogoImage','PrintLogo', 'nurse_entry_start','header_required','discharge_summary_footer','SiteName',
							'BMRSettings','mirthIntegration','MMRSettings','DateModified','OverwriteBabyMR','OverwriteMotherMR',
							'dSummaryedit','discharge_report_left','discharge_report_right','hospital_name','hospital_contact',
							'discharge_instraction','pagenation_limit_options', 'api_key', 'api_user_name', 'api_password', 'period',
							'custom_toastr', 'neonatal_highlight', 'nicu_highlight', 'nicu_daycare_highlight', 'daycare_summary_highlight', 
							'prblm_summary_highlight', 'post_adm_highlight', 'post_daycare_adm_highlight', 'post_summary_highlight',
							'op_highlight','daycare_dates_for_chart','pediatric_discharge_summary','condition_at_discharge','review_details', 'neonatal_op_print_right'];
	/**
	* FETCH THE SITE SETTING FOR EDITING THE LOGO UPDATION AND MR FORMATTING
	*/
	public static function  get_record()
	{
		$results = DB::table('site_settings')->get();		
		return $results;
	}	
	/**
	* USED TO GENERATE THE BABY MR NO TO THE PREDEFINED FORMAT SAVED IN THE SETTINGS
	*/	
	public static function GenerateBMR()
	{
		$setting_results = DB::table('site_settings')->get();
		if (isset($setting_results[0])) {
			$settings = unserialize($setting_results[0]->BMRSettings);
			$BabyMR[1] =  isset($settings[1])?$settings[1]:'';
			$BabyMR[2] =  isset($settings[2])?$settings[2]:'';
			$BabyMR[3] =  isset($settings[3])?$settings[3]:'';
			$BabyMR[4] =  isset($settings[4])?$settings[4]:'';	

			switch ($BabyMR[2]) {
				case 'DD':
					$option2 = date('d');
					break;
				case 'YY':
					$option2 = date('y');
					break;					
				case 'MM':
					$option2 = date('m');
					break;					
				default:
					$option2 = '';
					break;					
			}
			switch ($BabyMR[3]) {
				case 'DD':
					$option3 = date('d');
					break;
				case 'YY':
					$option3 = date('y');
					break;
				case 'MM':
					$option3 = date('m');
					break;
				default:
					$option3 = '';
					break;
			}	
			if ($BabyMR[4]>0)
				$option4 = rand(pow(10, $BabyMR[4]-1), pow(10, $BabyMR[4])-1);
			
			$bmrno = $BabyMR[1].$option2.$option3.'B'.$option4;
		} else {
			$bmrno = rand(100000000000, 999999999999);
		}	
		return $bmrno;	
	}
	/**
	* USED TO GENERATE THE MOTHER MR NO TO THE PREDEFINED FORMAT SAVED IN THE SETTINGS
	*/	
	public static function GenerateMMR()
	{
		$setting_results = DB::table('site_settings')->get();
		if (isset($setting_results[0])) {
			$settings = unserialize($setting_results[0]->MMRSettings);
			$BabyMR[1] =  isset($settings[1])?$settings[1]:'';
			$BabyMR[2] =  isset($settings[2])?$settings[2]:'';
			$BabyMR[3] =  isset($settings[3])?$settings[3]:'';
			$BabyMR[4] =  isset($settings[4])?$settings[4]:'';	
			switch ($BabyMR[2]) {
				case 'DD':
					$option2 = date('d');
				case 'YY':
					$option2 = date('y');
				case 'MM':
					$option2 = date('m');
				default:
					$option2 = '';
			}
			switch ($BabyMR[3]) {
				case 'DD':
					$option3 = date('d');
				case 'YY':
					$option3 = date('y');
				case 'MM':
					$option3 = date('m');
				default:
					$option3 = '';
			}	
			if ($BabyMR[4]>0)
				$option4 = rand(pow(10, $BabyMR[4]-1), pow(10, $BabyMR[4])-1);
			
			$bmrno = $BabyMR[1].$option2.$option3.'B'.$option4;
		} else {
			$bmrno = rand(100000000000, 999999999999);
		}	
		return $bmrno;	
	}	
	/**
	* CHECK WHETHER BABY MR NO EXISTS OR NOT. USED WHILE REGISTRING A NEW BABY
	*/
	public static function ValidateBMR($mrno)
	{
		$results = DB::table('baby')
            ->select('baby.BabyId')->where('BMrNo', $mrno)
            ->get();	

		if ($results) {  
			return true;
        } else {
           return false;
        }
	}
	/**
	* CHECK WHETHER MOTHER MR NO EXISTS OR NOT. USED WHILE REGISTRING A NEW MOTHER
	*/
	public static function ValidateMMR($mrno)
	{
		$results = DB::table('mother')
            ->select('mother.MotherId')
            ->where('MMrNo', $mrno)
            ->get();
            		
		if ($results) {
			return true;
		} else {
			return false;
		}
	}

	/**
     * This method to get the period value
     *
     * @return object
     */
	public static function getPeriod() {
		return DB::table('site_settings')
			     ->select('period')
			     ->first();
	}		
}
