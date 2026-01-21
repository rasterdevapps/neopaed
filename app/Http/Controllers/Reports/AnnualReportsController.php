<?php
namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\Reports\AnnualReportsRequest;
use App\Http\Controllers\Controller;
use App\Models\Reports\AnnualReports;
use App\Models\Daycare;
use App\Http\Controllers\Reports\AnnualReportsSupport;
use App\Http\Controllers\Reports\AnnualReportsDateController;
use App\Models\Masters\StaffMaster;
use App\Models\Masters\DoctorMaster;

class AnnualReportsController extends Controller implements AnnualReportsSupport 
{

    public function __construct()
    {

        $this->annualreports = new AnnualReports();

        $this->notApplicable = 'N/A';
        
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chartTypes = AnnualReportsSupport::CHART_TYPE;
        $navigate['main_nav'] = 'report';
        $navigate['sub_nav']  = 'annual_report';   

       return view('reports.annual.create', compact('chartTypes','navigate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnualReportsRequest $request)
    {



        $input = $request->all();

        // Initialize  the variables 

        // Initialize list count array variables  
         $mpType = $diffTemp = $sexDistribution  = $inbornConception = $modeofDelivery = $inbornGestation = $inbornbirthWeight = $inbornNicuadmission =  $outborninbornNicuadmission  = $patientDays = $nicuGestation = $nicuBirthweight = $chronicLung = $respiratoryTherapy =  $surfactantTherapy =  $cardiovascular = $gastrointestinal = $ROP = $sepsis = $survivalList = $survivalWeightlist = $outBournbabies = $organizam = array();

        // Initialize charts array variables
         $inbornBabieschart = $sexDistributioncharts = $inbornConceptioncharts  = $modeofDeliverycharts = $inbornGestationcharts = $inbornbirthWeightcharts = $inbornNicuadmissionCharts = $outborninbornNicuadmissioncharts = $patientDayscharts = $nicuGestationcharts = $nicuBirthweightchart = $chronicLungchart = $respiratoryTherapychart = $surfactantTherapychart = $cardiovascularChart = $survivalChart = $survivalWeightchart = $outBournbabieschart = $organizamChart = array();

        //Initialize list avarage array variables
         $sexDistributioncount = $modeofDeliverycount = $modeofDeliverycount = $inbornGestationcount = $inbornbirthWeightcount = $inbornNicuadmissioncount = $outborninbornNicuadmissioncount  = $patientDayscount = $nicuGestationcount = $nicuBirthweightcount = $survivalcount = $survivalWeightcount = $outBournbabiescount = $organizamcount = $doctorList = $staffList =  array();


        // count 

            $outborncount = 0;


             $chartType = $input['chart_type'] ;
             $presentedBy = $input['presented_by'];
            // preparing data for header pages 
            $tempStartdate                = strtotime($input['startdate']); 
            $headStartdate                = date('d', $tempStartdate).'<sup>'.date('S', $tempStartdate).'</sup> '.date('F', $tempStartdate).' '.date('Y', $tempStartdate);
            $tempEnddate                  = strtotime($input['enddate']);
            $headEnddate                  = date('d', $tempEnddate).'<sup>'.date('S', $tempEnddate).'</sup> '.date('F', $tempEnddate).' '.date('Y', $tempEnddate);
     
            $startdate                    = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($input['startdate'])));
         
            $enddate                      = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($input['enddate'])));
     
            $sourceDate                   = new AnnualReportsDateController($startdate, $enddate);

            $differenceList[]             = $sourceDate->differentsIn();


           

            $diedBabyenddate =  (isset($input['compare_start_date']) && isset($input['compare_start_date'][(count($input['compare_start_date'])-1)])) ? $input['compare_start_date'][(count($input['compare_start_date'])-1)] : $input['enddate'];
          
            $diedBaby                              = $this->annualreports->getDiedbabylist($input['startdate'], $diedBabyenddate);

            

           
           // re-arrange the input start and end dates 

           $datesDifferents[] = array('start_date'=>$input['startdate'],'end_date'=>$input['enddate']);

            foreach ($input['compare_start_date'] as $key => $value) {

              if (!empty($input['compare_start_date'][$key]) && !empty($input['compare_end_date'][$key])) {

                 $datesDifferents[] = array('start_date'=>$input['compare_start_date'][$key], 'end_date'=>$input['compare_end_date'][$key]); 

               }
            }


           // Get List and Chart based on start and end date 
            foreach ($datesDifferents as $key => $value) {
               

               if (!empty($value['start_date']) && !empty($value['end_date'])) {   
                      
                     
                     $startDateindex                    =  date('M-Y', strtotime($value['start_date']));                    

                   // Get Inborn baby list
                     $tempBabies                        = $this->annualreports->inbornbabyList($value['start_date'], $value['end_date']);
                
                   // Get Inborn nicu baby list 

                     $tempnicubabyList                 = $this->annualreports->inbornNicubabylist($value['start_date'], $value['end_date']);

                   // Get outborn nicu baby list 

                     $tempnicuoutborninbornList        = $this->annualreports->inoutbornNicubabylist($value['start_date'], $value['end_date']); 

                  // Get daycare list 

                     $tempdaycareList                  = $this->annualreports->daycareList($value['start_date'], $value['end_date']);
                 


                  // Get live discharge nicu baby list 
                     $tempsurvialBabylist              = $this->annualreports->nicuListwithoutdied($value['start_date'], $value['end_date']);
 

                   // Get In and  outborn nicu baby list  based on Date of Admission

                    $temp_nicuadmission_inoutborn_list = $this->annualreports->NicuadmissionList($value['start_date'], $value['end_date']);  

                    $tempsourceDate                    = new AnnualReportsDateController($startdate, $enddate);


                    $differenceList[]                  = $tempsourceDate->differentsIn();

                 //Get outborn baby list 
                    $tempOutborn                        =  $tempnicuoutborninbornList ;
                    $tempOutborn                        =  collect($tempOutborn);
                    $tempOutborn                        =  $tempOutborn->where('BirthStatus', 'Outborn')->toArray();

                  // Preparing  the compare dates inborn and multiple pregnancy list
                     $inbornBabieschart[]                      =  array_merge(['Year'   => $startDateindex], $this->mpTypevalues($tempBabies)); 
                     $mpType[$startDateindex]                  =     $this->mpTypevalues($tempBabies); 

                 //Preparing the Compare sex distribution list

                    $tempSexdistributions                     = $this->sexDistributions($tempBabies, true);
                    $sexDistribution[$startDateindex]         = $tempSexdistributions; 
                    $sexDistributioncharts[]                  = array_merge(['Year'   => $startDateindex], $tempSexdistributions);
                    $sexDistributioncount[$startDateindex]    = $this->sexDistributions($tempBabies, false);
                    unset($tempSexdistributions); 
                 
                 //preparing the Conception data   

                    $tempConception                           =  $this->inbornConception($tempBabies, true); 
                    $inbornConception[$startDateindex]        =  $tempConception;
                    $inbornConceptioncount[$startDateindex]   = $this->inbornConception($tempBabies, false); 
                    $inbornConceptioncharts[]                 = array_merge(['Year'   => $startDateindex], $tempConception);
                    unset($tempConception); 

                 //preparing mode of delivery data  
                    
                    $tempmode                                 =  $this->deliveryMode($tempBabies, true); 
                    $modeofDelivery[$startDateindex]          =  $tempmode;
                    $modeofDeliverycount[$startDateindex]     =  $this->deliveryMode($tempBabies, false); 
                    $modeofDeliverycharts[]                   =  array_merge(['Year'   => $startDateindex], $tempmode);
                    unset($tempmode); 

                  //preparing gestation data


                    $tempgestation                             =  $this->gestationList($tempBabies, true); 
                    $inbornGestation[$startDateindex]          =  $tempgestation;
                    $inbornGestationcount[$startDateindex]     = $this->gestationList($tempBabies, false); 
                    $inbornGestationcharts[]                   = array_merge(['Year'   => $startDateindex], $tempgestation);
                    unset($tempgestation); 
                    

                  //preparing  birth weight 


                    $tempbirthweight                            =  $this->birthweightList($tempBabies, true); 
                    $inbornbirthWeight[$startDateindex]         =  $tempbirthweight;
                    $inbornbirthWeightcount[$startDateindex]    = $this->birthweightList($tempBabies, false); 
                    $inbornbirthWeightcharts[]                  = array_merge(['Year'   => $startDateindex], $tempbirthweight);
                    unset($tempbirthweight); 

                 //preparing outborn & inborn nicu admission   

                    $outborninbornNicuadmission[$startDateindex]         = $this->inbornOutbornadmission($tempnicuoutborninbornList, true);
                    $outborninbornNicuadmissioncount[$startDateindex]    = $this->inbornOutbornadmission($tempnicuoutborninbornList, false);
                    $outborninbornNicuadmissioncharts[]                  = array_merge(['Year'=> $startDateindex], $this->inbornOutbornadmission($tempnicuoutborninbornList));    
 
                  

                  //preparing nicu admisson

                    $inbornNicuadmission[$startDateindex]         = $this->inbornNicuadmission($temp_nicuadmission_inoutborn_list, true);
                    $inbornNicuadmissioncount[$startDateindex]    = $this->inbornNicuadmission($temp_nicuadmission_inoutborn_list, false);
                    $inbornNicuadmissionCharts[]                  = array_merge(['Year'=> $startDateindex], $this->inbornNicuadmission($temp_nicuadmission_inoutborn_list));    
              

                   //preparting daycare sheet 

                    $patientDays[$startDateindex]         = $this->patientDays($tempdaycareList, true); 
                    $patientDayscount[$startDateindex]    = $this->patientDays($tempdaycareList, false);
                    $patientDayscharts[]                  = array_merge(['Year'=> $startDateindex], $this->patientDays($tempdaycareList, false)); 
                    
                    unset($tempsourceDate);


                     //preparing nicu gestation list and chart

                    $nicuGestation[$startDateindex]           = $this->gestationList($tempnicuoutborninbornList, true, 'Gestation', 'g_weeks');        
                    $nicuGestationcount[$startDateindex]      = $this->gestationList($tempnicuoutborninbornList, false, 'Gestation', 'g_weeks');
                    $nicuGestationcharts[]                    = array_merge(['Year'=> $startDateindex], $this->gestationList($tempnicuoutborninbornList, true, 'Gestation', 'g_weeks'));

                    //preparing nicu birth weight list and chart

                    $nicuBirthweight[$startDateindex]          = $this->birthweightList($tempnicuoutborninbornList, true);
                    $nicuBirthweightcount[$startDateindex]     = $this->birthweightList($tempnicuoutborninbornList, false);
                    $nicuBirthweightcharts[]                   = array_merge(['Year'=> $startDateindex], $this->birthweightList($tempnicuoutborninbornList, true));
               
                    //preparing nicu chronic 

                    $chronicLung[$startDateindex]              = $this->chronicLungdiseaseList($tempdaycareList, $tempnicuoutborninbornList);
                    $chronicLungchart[]                        = array_merge(['Year'=>$startDateindex], $this->chronicLungdiseaseList($tempdaycareList, $tempnicuoutborninbornList));

                    //preparing respiratary system

                    $respiratoryTherapy[$startDateindex]     = $this->respiratoryTherapy($tempdaycareList, $tempnicuoutborninbornList);
                    $respiratoryTherapychart[]               = array_merge(['Year'=>$startDateindex], $this->respiratoryTherapy($tempdaycareList, $tempnicuoutborninbornList));

                    // Preparing surfactant Therapy
                    $surfactantTherapy[$startDateindex]      = $this->surfactantTherapy($tempdaycareList); 
                    $surfactantTherapychart[]                = array_merge(['Year'=>$startDateindex], $this->surfactantTherapy($tempdaycareList));

                     //Preparing cardiovascular Morbidites 
                    $cardiovascular[$startDateindex]              =  $this->cardiovascularMorbidites($tempdaycareList); 

                     //Preparing gastrointestinal Morbidity 
                    $gastrointestinal[$startDateindex]            =  $this->gastrointestinalMorbidites($tempdaycareList);

                    // preparing rop 
                    $ROP[$startDateindex]                         =  $this->retinopathyPrematurity($tempnicuoutborninbornList);
                     
                    // survival list based on gestation 
                    $survivalList[$startDateindex]           = $this->survialgestationList($tempnicuoutborninbornList, true, 'Gestation', 'g_weeks');
                    $survivalcount[$startDateindex]          = $this->survialgestationList($tempnicuoutborninbornList, false, 'Gestation', 'g_weeks');
                    $survivalChart[]                         =  array_merge(['Year'=>$startDateindex], $this->survialgestationList($tempnicuoutborninbornList, true, 'Gestation', 'g_weeks'));

                    // survival list based on weight
                    $survivalWeightlist[$startDateindex]       = $this->survivalbirthweightList($tempsurvialBabylist, true);
                    $survivalWeightcount[$startDateindex]      = $this->survivalbirthweightList($tempsurvialBabylist, false);
                    $survivalWeightchart[]                     = array_merge(['Year'=>$startDateindex], $this->survivalbirthweightList($tempsurvialBabylist));

                    
                    //preparing outborn babies gastation based list
                    $outborncount += count($tempOutborn);

                    $outBournbabies[$startDateindex]           = $this->gestationList($tempOutborn, true, 'Gestation', 'g_weeks');        
                    $outBournbabiescount[$startDateindex]      = $this->gestationList($tempOutborn, false, 'Gestation', 'g_weeks');
                    $outBournbabieschart[]                     = array_merge(['Year'=> $startDateindex], $this->gestationList($tempOutborn, true, 'Gestation', 'g_weeks'));
                     

                    // survival list based on weight
                    $organizam[$startDateindex]                = $this->getOrganizam($tempdaycareList);

                   

                }

             }

             // formate the list for blood organizam
                $temporg = array_collapse($organizam);
                $temporg = array_keys($temporg);

                $organizam_titles = array();

                foreach ($temporg as $value) {
                   $organizam_titles[$value]=array();
                }
                
                ksort($organizam_titles);

                foreach ($organizam_titles as $orgbasekey => $org_title) {
                    foreach ($organizam as $orgsubkey => $orgvalue) {
                        if (!array_key_exists($orgbasekey, $orgvalue)) {
                           $organizam[$orgsubkey][$orgbasekey] = 0; 
                        }
                    }
                }
                $organizam = array_sort_recursive($organizam);

                $organizam_titles = array_keys($organizam);

                $organizamList    = array();

                foreach ($organizam as $orgbasekey => $orgbaseValue) {

                    foreach ($orgbaseValue as $orgsubKey => $orgsubValue) {
                       $organizamList[$orgsubKey][] =  $orgsubValue ; 
                    }

                }

               
                //Preparing the list for procedures count
                $proceduresDetails  = $this->proceduresList($datesDifferents);

                //preparing the list for died baby resons
                $characterofdiedbaby                   = $this->diedBabyList($diedBaby);



                      

                    // Get dyanamic Keys chart and list  property  for surfactant
                    $tempsurfactant  = array();
                    foreach ($surfactantTherapy as $key => $value) {

                         $tempsurfactant = array_merge($tempsurfactant, $value); 

                    }
                    $surfactantKey          =  array_keys($tempsurfactant);
                    $surfactantProperties   =  \SiteHelpers::chartProperty($surfactantKey);
                    unset($tempsurfactant);


                    if ($chartType == 1) {

                           $inbornProperty                        = \SiteHelpers::mixedChartparam(AnnualReportsSupport::MPTYPES, false);

                           $sexChartsproperty                     = \SiteHelpers::mixedChartparam(AnnualReportsSupport::SEXDP);

                           $inbornConceptionsproperty             = \SiteHelpers::mixedChartparam(AnnualReportsSupport::CONCEPTION);

                           $modeofDeliveryproperty                = \SiteHelpers::mixedChartparam(AnnualReportsSupport::DELIVERYMODE);

                           $inbornGestationproperty               = \SiteHelpers::mixedChartparam(AnnualReportsSupport::GESTATION);

                           $inbornbirthWeightproperty             = \SiteHelpers::mixedChartparam(AnnualReportsSupport::BIRTHWEIGHT);

                           $outborninbornNicuadmissionproperty    = \SiteHelpers::mixedChartparam(AnnualReportsSupport::NICUADMISSION_BIRTHSTATUS);

                           $inbornNicuadmissionproperty           = \SiteHelpers::mixedChartparam(AnnualReportsSupport::NICUADMISSION);

                           $patientDaysproperties                 = \SiteHelpers::mixedChartparam(AnnualReportsSupport::PATIENTS_DAYS, false);

                           $nicuGestationproperties               =  \SiteHelpers::mixedChartparam(AnnualReportsSupport::GESTATION);

                           $nicuBirthweightproperties              = \SiteHelpers::mixedChartparam(AnnualReportsSupport::BIRTHWEIGHT);

                           $nicuchronicproperties                  =  \SiteHelpers::mixedChartparam(AnnualReportsSupport::CHRONIC, false);

                           $respirataryProperties                  =  \SiteHelpers::mixedChartparam(AnnualReportsSupport::RESPIRATORY_THERAPY, false);

                           $surfactantProperties                   =  \SiteHelpers::mixedChartparam($surfactantProperties, false);


                        } elseif ($chartType == 2) {

                         $inbornProperty                        = \SiteHelpers::multipleChartparam(AnnualReportsSupport::MPTYPES, false);

                           $sexChartsproperty                     = \SiteHelpers::multipleChartparam(AnnualReportsSupport::SEXDP);
                 
                           $inbornConceptionsproperty             = \SiteHelpers::multipleChartparam(AnnualReportsSupport::CONCEPTION);

                           $modeofDeliveryproperty                = \SiteHelpers::multipleChartparam(AnnualReportsSupport::DELIVERYMODE);

                           $inbornGestationproperty               = \SiteHelpers::multipleChartparam(AnnualReportsSupport::GESTATION);

                           $inbornbirthWeightproperty             = \SiteHelpers::multipleChartparam(AnnualReportsSupport::BIRTHWEIGHT);

                           $outborninbornNicuadmissionproperty    = \SiteHelpers::multipleChartparam(AnnualReportsSupport::NICUADMISSION_BIRTHSTATUS);

                           $inbornNicuadmissionproperty           = \SiteHelpers::multipleChartparam(AnnualReportsSupport::NICUADMISSION);

                           $patientDaysproperties                 = \SiteHelpers::multipleChartparam(AnnualReportsSupport::PATIENTS_DAYS);
                          
                           $nicuGestationproperties               = \SiteHelpers::multipleChartparam(AnnualReportsSupport::GESTATION);

                           $nicuBirthweightproperties             = \SiteHelpers::multipleChartparam(AnnualReportsSupport::BIRTHWEIGHT);
                        
                           $nicuchronicproperties                 =  \SiteHelpers::multipleChartparam(AnnualReportsSupport::CHRONIC, false);

                           $respirataryProperties                 =  \SiteHelpers::multipleChartparam(AnnualReportsSupport::RESPIRATORY_THERAPY, false);
                           
                           $surfactantProperties                   =  \SiteHelpers::multipleChartparam($surfactantProperties, false);

                     } 



                    $inbornBabieschart                 = json_encode($inbornBabieschart);
                    $inbornProperty                    = json_encode($inbornProperty);


                    $inbornConceptioncharts            = json_encode($inbornConceptioncharts);
                    $inbornConceptionsproperty         = json_encode($inbornConceptionsproperty);

                    $sexDistributioncharts             = json_encode($sexDistributioncharts);
                    $sexChartsproperty                 = json_encode($sexChartsproperty);

                    $modeofDeliverycharts              = json_encode($modeofDeliverycharts);
                    $modeofDeliveryproperty            = json_encode($modeofDeliveryproperty);
                   
                    $inbornGestationcharts             = json_encode($inbornGestationcharts);
                    $inbornGestationproperty           = json_encode($inbornGestationproperty);

                    $inbornbirthWeightcharts           = json_encode($inbornbirthWeightcharts);
                    $inbornbirthWeightproperty         = json_encode($inbornbirthWeightproperty);


                    $outborninbornNicuadmissioncharts  = json_encode($outborninbornNicuadmissioncharts);
                    $outborninbornNicuadmissionproperty= json_encode($outborninbornNicuadmissionproperty); 

                    $inbornNicuadmissionCharts         = json_encode($inbornNicuadmissionCharts);
                    $inbornNicuadmissionproperty       = json_encode($inbornNicuadmissionproperty); 

                    $patientDaysproperties             = json_encode($patientDaysproperties);
                    $patientDayscharts                 = json_encode($patientDayscharts);

                    $nicuGestationproperties           = json_encode($nicuGestationproperties);
                    $nicuGestationcharts               = json_encode($nicuGestationcharts);



                    $nicuBirthweightproperties          = json_encode($nicuBirthweightproperties);
                    $nicuBirthweightcharts              = json_encode($nicuBirthweightcharts);

                    $nicuchronicproperties              = json_encode($nicuchronicproperties);
                    $chronicLungchart                   = json_encode($chronicLungchart);

                    $respirataryProperties              = json_encode($respirataryProperties);
                    $respiratoryTherapychart            = json_encode($respiratoryTherapychart);

                    $surfactantTherapychart             = json_encode($surfactantTherapychart);
                    $surfactantProperties               = json_encode($surfactantProperties);

                    $survivalChart                      = json_encode($survivalChart);
                    $survivalWeightchart                = json_encode($survivalWeightchart);

                    $outBournbabieschart                = json_encode($outBournbabieschart);


                    $doctorList                     = DoctorMaster::ListData();
                    $StaffMaster                    = StaffMaster::ListData();
                    $closewinlink                   = url('mass-reports/create');
                    
        return view('reports.annual.print', compact('StaffMaster', 'doctorList', 'closewinlink','inbornBabieschart', 'presentedBy', 'organizamList', 'outborncount', 'organizam_titles', 'outBournbabieschart', 'outBournbabies', 'outBournbabiescount', 'inbornProperty', 'proceduresDetails', 'characterofdiedbaby', 'survivalWeightchart', 'survivalWeightcount', 'survivalWeightlist', 'survivalList', 'survivalcount', 'survivalChart', 'ROP', 'cardiovascular', 'gastrointestinal', 'surfactantKey', 'surfactantProperties', 'surfactantTherapy', 'surfactantTherapychart', 'respirataryProperties', 'respiratoryTherapy', 'respiratoryTherapychart', 'nicuchronicproperties', 'chronicLungchart', 'chronicLung', 'nicuBirthweightproperties', 'nicuBirthweightcharts', 'nicuBirthweightcount', 'nicuBirthweight', 'nicuGestationproperties', 'nicuGestationcharts', 'nicuGestationcount', 'nicuGestation', 'patientDays', 'patientDaysproperties', 'patientDayscharts', 'patientDayscount', 'mpType', 'test', 'chartType', 'outborninbornNicuadmissioncount', 'outborninbornNicuadmissionproperty', 'outborninbornNicuadmissioncharts', 'outborninbornNicuadmission', 'inbornNicuadmissionproperty', 'inbornNicuadmissionCharts', 'inbornNicuadmissioncount', 'inbornNicuadmission', 'inbornbirthWeight', 'inbornbirthWeightcount', 'inbornbirthWeightcharts', 'inbornbirthWeightproperty', 'inbornGestationcount', 'inbornGestationcharts', '', 'inbornGestation', 'inbornGestationproperty', 'modeofDeliverycharts', 'modeofDeliveryproperty', 'modeofDelivery', 'modeofDeliverycount', 'inbornConceptionsproperty', 'inbornConceptioncharts', 'inbornConception', 'inbornConceptioncount', 'sexDistribution', 'sexChartsproperty', 'sexDistributioncharts', 'sexDistributioncount', 'headStartdate', 'headEnddate'));

    }

    /**
     * Preparing the multiple pregnancy count for charts  
     *
     * @param  baby list type array
     * @return baby counts based on multiple pregnancy  
     *

    */

    private function mpTypevalues($babyList) 
    {
        $babyList = collect($babyList);

        return ['singleTone'  => $babyList->where('MultiplePregnancyType', 'Singleton')->count(),
                'Twins'       => $babyList->where('MultiplePregnancyType', 'Twins')->groupBy('MotherId')->count(),
                'TripLets'    => $babyList->where('MultiplePregnancyType', 'Triplets')->groupBy('MotherId')->count(),
                'QuadrupLets' => $babyList->where('MultiplePregnancyType', 'Quadruplets')->groupBy('MotherId')->count(),
                'QuintupLets' => $babyList->where('MultiplePregnancyType', 'Quintuplets')->groupBy('MotherId')->count(),
                'SextupLets'  => $babyList->where('MultiplePregnancyType', 'Sextuplets')->groupBy('MotherId')->count(),
                'SeptupLets'  => $babyList->where('MultiplePregnancyType', 'Septuplets')->groupBy('MotherId')->count(),
                'OctupLets'   => $babyList->where('MultiplePregnancyType', 'Octuplets')->groupBy('MotherId')->count(),
                'Total'       => count($babyList), ];

    }

     /**
     * Preparing the Sex Distributions count for charts  
     *
     * @param  $babyList type array
     * @param  $flage type boolean 
     * @return baby counts based on Sex Distributions 
     *

    */


    private function sexDistributions($babyList, $flage = true) 
    {
        $babyList = collect($babyList);

        if ($flage && count($babyList)!=0) {
            return ['Male'     => number_format(($babyList->where('Sex', 'Male')->count()/count($babyList))*100, 2),
                    'Female'   => number_format(($babyList->where('Sex', 'Female')->count()/count($babyList))*100, 2),
                    'Indeterminate'    => number_format(($babyList->where('Sex', 'Indeterminate')->count()/count($babyList))*100), 2];
        } else {
             return ['Male'     => $babyList->where('Sex', 'Male')->count(),
                    'Female'   => $babyList->where('Sex', 'Female')->count(),
                    'Indeterminate'    => $babyList->where('Sex', 'Indeterminate')->count()];
        }        

    }

    /**
     * Preparing the mode of conception count for charts  
     *
     * @param  $babyList type array
     * @param  $flage type boolean 
     * @return baby counts based on Sex Distributions 
     *

    */

    private function inbornConception($babyList, $flage = true) 
    {

        $babyList = collect($babyList);

        if ($flage && count($babyList)!=0) {
          
            return ['spontaneous'     => ($babyList->where('Conception', 'Spontaneous')->count() > 0) ?  number_format(($babyList->where('Conception', 'Spontaneous')->count()/count($babyList))*100, 2) : $this->notApplicable ,
                    'medicalArt'      => ($babyList->where('Conception', 'Medical ART')->count() > 0) ?  round(($babyList->where('Conception', 'Medical ART')->count()/count($babyList))*100, 2) : $this->notApplicable ,
                    'art'             => ($babyList->where('Conception', 'ART')->count() > 0) ? number_format(($babyList->where('Conception', 'ART')->count()/count($babyList))*100, 2) : $this->notApplicable,
                    'IVF'             => ($babyList->where('TypeofART', 'IVF')->count() > 0) ? number_format(($babyList->where('TypeofART', 'IVF')->count()/count($babyList))*100, 2) : $this->notApplicable,
                    'ICSI'            => ($babyList->whereIn('TypeofART', array('ICSI', 'ICSI - DEP', 'ICSI - DOP', 'ICSI - Donor Sperm'))->count() > 0) ? number_format(($babyList->whereIn('TypeofART', array('ICSI', 'ICSI - DEP', 'ICSI - DOP', 'ICSI - Donor Sperm'))->count()/count($babyList))*100, 2) : $this->notApplicable ];
        } else {

             return ['spontaneous'     => ($babyList->where('Conception', 'Spontaneous')->count() > 0) ?  $babyList->where('Conception', 'Spontaneous')->count() : $this->notApplicable,
                     'medicalArt'      => ($babyList->where('Conception', 'Medical ART')->count() > 0) ?  $babyList->where('Conception', 'Medical ART')->count() : $this->notApplicable,
                     'art'             => ($babyList->where('Conception', 'ART')->count() > 0) ? $babyList->where('Conception', 'ART')->count() : $this->notApplicable,
                     'IVF'             => ($babyList->where('TypeofART', 'IVF')->count() > 0) ? $babyList->where('TypeofART', 'IVF')->count() : $this->notApplicable,
                     'ICSI'            => ($babyList->whereIn('TypeofART', array('ICSI', 'ICSI - DEP', 'ICSI - DOP', 'ICSI - Donor Sperm'))->count() > 0) ? $babyList->whereIn('TypeofART', array('ICSI', 'ICSI - DEP', 'ICSI - DOP', 'ICSI - Donor Sperm'))->count() : $this->notApplicable];
        }        

    }

    /**
     * Preparing the mode of deivery count for charts  
     *
     * @param  $babyList type array
     * @param  $flage type boolean 
     * @return baby counts based on Sex Distributions 
     *

    */

    private function deliveryMode($babyList, $flage = true) 
    {

        $babyList = collect($babyList);


        if ($flage && count($babyList)!=0) {


        return ['Vaginal'              => number_format(($babyList->where('ModeOfDelivery', 'Normal Vaginal')->count()/count($babyList))*100, 2) + number_format(($babyList->where('ModeOfDelivery', 'Preterm Vaginal')->count()/count($babyList))*100, 2),
                'Instrumental'          => number_format(($babyList->where('ModeOfDelivery', 'Forceps')->count()/count($babyList))*100, 2)+number_format(($babyList->where('ModeOfDelivery', 'Ventouse')->count()/count($babyList))*100, 2),                  
                'Caesarian_section'     => number_format(($babyList->where('ModeOfDelivery', 'Caesarian')->count()/count($babyList))*100, 2)+number_format(($babyList->where('ModeOfDelivery', 'Emergency Caesarian')->count()/count($babyList))*100, 2)+number_format(($babyList->where('ModeOfDelivery', 'Elective Caesarian')->count()/count($babyList))*100, 2) ];
        } else {

             return ['Vaginal'            => $babyList->where('ModeOfDelivery', 'Normal Vaginal')->count() + $babyList->where('ModeOfDelivery', 'Preterm Vaginal')->count(),
                     'Instrumental'        => $babyList->where('ModeOfDelivery', 'Forceps')->count() + $babyList->where('ModeOfDelivery', 'Ventouse')->count(),
                     'Caesarian_section'   => $babyList->where('ModeOfDelivery', 'Caesarian')->count() + $babyList->where('ModeOfDelivery', 'Elective Caesarian')->count() + $babyList->where('ModeOfDelivery', 'Emergency Caesarian')->count() ];
        }        

    }

    /**
     * Preparing the gestation count for charts  
     *
     * @param  $babyList type array
     * @param  $flage type boolean 
     * @return baby counts based on Sex Distributions 
     *

    */


     private function gestationList($babyList, $flage = true, $field = 'Gestation', $subfield ='g_weeks') 
     {

        // $babyList = \SiteHelpers::convert_obj_to_array($babyList);

         
         $gCountone = $gCounttwo = $gCountthree = $gCountfour = $gCountfive = $gCountsix = $gCountseven = $gCounteight = 0;

        foreach ($babyList as $key => $value) {

            $tempGestation = collect(json_decode($value->Gestation))->toArray();

            $tempGestation[$subfield] =  isset($tempGestation[$subfield]) ? $tempGestation[$subfield] : 0;

            $gestation_weeks = (int)$tempGestation[$subfield];
           
            if ($gestation_weeks < 28) {

                $gCountone = $gCountone +1;

            } elseif ($gestation_weeks >= 28 && $gestation_weeks <= 30) {

                 $gCounttwo = $gCounttwo +1;

            } elseif ($gestation_weeks >= 31 && $gestation_weeks <= 32) {

                 $gCountthree = $gCountthree +1;
                 
            } elseif ($gestation_weeks >= 33 && $gestation_weeks <= 36) {

                 $gCountfour = $gCountfour +1;
                 
            } elseif ($gestation_weeks >= 37 && $gestation_weeks <= 38) {

                 $gCountfive = $gCountfive +1;
                 
            } elseif ($gestation_weeks >= 39 && $gestation_weeks <= 40) {

                 $gCountsix = $gCountsix +1;
                 
            } elseif ($gestation_weeks >= 41 && $gestation_weeks <= 42) {

                 $gCountseven = $gCountseven +1;
                 
            } elseif ($gestation_weeks > 42) {

                 $gCounteight = $gCounteight +1;
            }     

        }

      


       if ($flage && count($babyList)!=0) {

        return [    'greater28'   => number_format(($gCountone / count($babyList))*100, 2),
                    '28–30' => number_format(($gCounttwo / count($babyList))*100, 2),
                    '31-32' => number_format(($gCountthree / count($babyList))*100, 2),
                    '33-36' => number_format(($gCountfour / count($babyList))*100, 2),
                    '37-38' => number_format(($gCountfive / count($babyList))*100, 2),
                    '39-40' => number_format(($gCountsix / count($babyList))*100, 2),
                    '41-42' => number_format(($gCountseven / count($babyList))*100, 2),
                    'less42'=> number_format(($gCounteight / count($babyList))*100, 2)];
        } else {

             return ['greater28' => $gCountone,
                     '28–30' => $gCounttwo,
                     '31-32' => $gCountthree,
                     '33-36' => $gCountfour,
                     '37-38' => $gCountfive,
                     '39-40' => $gCountsix,
                     '41-42' => $gCountseven,
                     'less42'   => $gCounteight ];
        }  

    }

    private function survialgestationList($babyList, $flage = true, $field = 'Gestation', $subfield ='g_weeks') 
    {

       //  $babyList = \SiteHelpers::convert_obj_to_array($babyList);

         $gCountone = $gCounttwo = $gCountthree = $gCountfour = $gCountfive = $gCountsix = $gCountseven = $gCounteight = 0;

         $totalCountone = $totalCounttwo = $totalCountthree = $totalCountfour = $totalCountfive = $totalCountsix = $totalCountseven = $totalCounteight = 0;
        
        foreach ($babyList as $key => $value) {



            $tempGestation = collect(json_decode($value->Gestation))->toArray();

            $tempGestation[$subfield] =  isset($tempGestation[$subfield]) ? $tempGestation[$subfield] : 0;

              $temp_weeks = (int)$tempGestation[$subfield];
              $baby_status = trim($value->status);
           
            if ($temp_weeks < 28 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {
                        
                $gCountone = $gCountone +1;

            } elseif ($temp_weeks >= 28 && $temp_weeks <= 30 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $gCounttwo = $gCounttwo +1;

            } elseif ($temp_weeks >= 31 && $temp_weeks <= 32 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $gCountthree = $gCountthree +1;
                 
            } elseif ($temp_weeks >= 33 && $temp_weeks <= 36 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $gCountfour = $gCountfour +1;
                 
            } elseif ($temp_weeks >= 37 && $temp_weeks <= 38 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $gCountfive = $gCountfive +1;
                 
            } elseif ($temp_weeks >= 39 && $temp_weeks <= 40 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $gCountsix = $gCountsix +1;
                 
            } elseif ($temp_weeks >= 41 && $temp_weeks <= 42 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $gCountseven = $gCountseven +1;
                 
            } elseif ($temp_weeks > 42 && $baby_status != 'Died' || $baby_status != 'Died (OCNR)') {

                 $gCounteight = $gCounteight +1;
            }


            if ($temp_weeks < 28) {

                $totalCountone = $totalCountone +1;

            } elseif ($temp_weeks >= 28 && $temp_weeks <= 30) {

                 $totalCounttwo = $totalCounttwo +1;

            } elseif ($temp_weeks >= 31 && $temp_weeks <= 32) {

                 $totalCountthree = $totalCountthree +1;
                 
            } elseif ($temp_weeks >= 33 && $temp_weeks <= 36) {

                 $totalCountfour = $totalCountfour +1;
                 
            } elseif ($temp_weeks >= 37 && $temp_weeks <= 38) {

                 $totalCountfive = $totalCountfive +1;
                 
            } elseif ($temp_weeks >= 39 && $temp_weeks <= 40) {

                 $totalCountsix = $totalCountsix +1;
                 
            } elseif ($temp_weeks >= 41 && $temp_weeks <= 42) {

                 $totalCountseven = $totalCountseven +1;
                 
            } elseif ($temp_weeks > 42) {

                 $totalCounteight = $totalCounteight +1;
            }          

        }

 
       if ($flage && count($babyList)!=0) {

        return [    'greater28'   => ($totalCountone != 0) ? number_format(($gCountone / $totalCountone)*100, 2) : 0 ,
                    '28–30' => ($totalCounttwo != 0) ? number_format(($gCounttwo / $totalCounttwo)*100, 2) : 0 ,
                    '31-32' => ($totalCountthree != 0) ? number_format(($gCountthree / $totalCountthree)*100, 2) : 0 ,
                    '33-36' => ($totalCountfour != 0) ? number_format(($gCountfour / $totalCountfour)*100, 2) : 0,
                    '37-38' => ($totalCountfive != 0) ? number_format(($gCountfive / $totalCountfive)*100, 2) : 0,
                    '39-40' => ($totalCountsix != 0) ? number_format(($gCountsix / $totalCountsix)*100, 2): 0,
                    '41-42' => ($totalCountseven != 0) ? number_format(($gCountseven / $totalCountseven)*100, 2): 0,
                    'less42'=> ($totalCounteight !=0) ?number_format(($gCounteight / $totalCounteight)*100, 2) : 0];
        } else {

             return ['greater28' => $gCountone,
                     '28–30' => $gCounttwo,
                     '31-32' => $gCountthree,
                     '33-36' => $gCountfour,
                     '37-38' => $gCountfive,
                     '39-40' => $gCountsix,
                     '41-42' => $gCountseven,
                     'less42'   => $gCounteight ];
        }  

    }


    private function birthweightList($babyList, $flage = true) 
    {

         $babyList = collect($babyList);

        


         $bCountone = $bCounttwo = $bCountthree = $bCountfour = $bCountfive = $bCountsix = $bCountseven = $bCounteight =0;
        
        foreach ($babyList as $key => $value) {

            $tempGestation = $value->BirthWeight;
          
           
            if ($value->BirthWeight < 1000) {

                $bCountone = $bCountone +1;

            } elseif ($value->BirthWeight >= 1001 && $value->BirthWeight <= 1500) {

                 $bCounttwo = $bCounttwo +1;

            } elseif ($value->BirthWeight >= 1501 && $value->BirthWeight <= 2000) {

                 $bCountthree = $bCountthree +1;
                 
            } elseif ($value->BirthWeight >= 2001 && $value->BirthWeight <= 2500) {

                 $bCountfour = $bCountfour +1;
                 
            } elseif ($value->BirthWeight >= 2501 && $value->BirthWeight <= 3000) {

                 $bCountfive = $bCountfive +1;

            } elseif ($value->BirthWeight >= 3001 && $value->BirthWeight <= 3500) {

                  $bCountsix = $bCountsix + 1; 

            } elseif ($value->BirthWeight >= 3501 && $value->BirthWeight <= 4000) {

                  $bCountseven = $bCountseven + 1; 

            } elseif ($value->BirthWeight >= 4001) {

                  $bCounteight = $bCounteight + 1; 

            }      

        }


       if ($flage && count($babyList)!=0) {

        return ['0000-1000'  => number_format(($bCountone / count($babyList))*100, 2),
                '1000-1499'  => number_format(($bCounttwo / count($babyList))*100, 2),
                '1500-1999'  => number_format(($bCountthree / count($babyList))*100, 2),
                '2000-2499'  => number_format(($bCountfour / count($babyList))*100, 2),
                '2500-2999'  => number_format(($bCountfive / count($babyList))*100, 2),
                '3000-3499'  => number_format(($bCountsix / count($babyList))*100, 2),
                '3500-3999'  => number_format(($bCountseven / count($babyList))*100, 2),
                '4000-9999'  => number_format(($bCounteight / count($babyList))*100, 2)];
        } else {

             return ['0000-1000' => $bCountone,
                     '1000-1499' => $bCounttwo,
                     '1500-1999' => $bCountthree,
                     '2000-2499' => $bCountfour,
                     '2500-2999' => $bCountfive,
                     '3000-3499' => $bCountsix,
                     '3500-3999' => $bCountseven,
                     '4000-9999' => $bCounteight];
        }  

    }

     private function survivalbirthweightList($babyList, $flage = true) 
     {

         $babyList = collect($babyList);

         $bCountone = $bCounttwo = $bCountthree = $bCountfour = $bCountfive = $bCountsix = $bCountseven = $bCounteight =0;
         
         $totalCountone = $totalCounttwo = $totalCountthree = $totalCountfour = $totalCountfive = $totalCountsix = $totalCountseven = $totalCounteight =0;
           
           

        foreach ($babyList as $key => $value) {

            $tempGestation = $value->BirthWeight;
            $baby_status = trim($value->status);
           
            if ($value->BirthWeight < 1000 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                $bCountone = $bCountone +1;

            } elseif ($value->BirthWeight >= 1001 && $value->BirthWeight <= 1500 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $bCounttwo = $bCounttwo +1;

            } elseif ($value->BirthWeight >= 1501 && $value->BirthWeight <= 2000 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $bCountthree = $bCountthree +1;
                 
            } elseif ($value->BirthWeight >= 2001 && $value->BirthWeight <= 2500 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $bCountfour = $bCountfour +1;
                 
            } elseif ($value->BirthWeight >= 2501 && $value->BirthWeight <= 3000 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                 $bCountfive = $bCountfive +1;

            } elseif ($value->BirthWeight >= 3001 && $value->BirthWeight <= 3500 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                  $bCountsix = $bCountsix + 1; 

            } elseif ($value->BirthWeight >= 3501 && $value->BirthWeight <= 4000 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                  $bCountseven = $bCountseven + 1; 

            } elseif ($value->BirthWeight >= 4001 && $baby_status != 'Died' && $baby_status != 'Died (OCNR)') {

                  $bCounteight = $bCounteight + 1; 

            }   


            if ($value->BirthWeight < 1000) {

                $totalCountone = $totalCountone +1;

            } elseif ($value->BirthWeight >= 1001 && $value->BirthWeight <= 1500) {

                 $totalCounttwo = $totalCounttwo +1;

            } elseif ($value->BirthWeight >= 1501 && $value->BirthWeight <= 2000) {

                 $totalCountthree = $totalCountthree +1;
                 
            } elseif ($value->BirthWeight >= 2001 && $value->BirthWeight <= 2500) {

                 $totalCountfour = $totalCountfour +1;
                 
            } elseif ($value->BirthWeight >= 2501 && $value->BirthWeight <= 3000) {

                 $totalCountfive = $totalCountfive +1;

            } elseif ($value->BirthWeight >= 3001 && $value->BirthWeight <= 3500) {

                  $totalCountsix = $totalCountsix + 1; 

            } elseif ($value->BirthWeight >= 3501 && $value->BirthWeight <= 4000) {

                  $totalCountseven = $totalCountseven + 1; 

            } elseif ($value->BirthWeight >= 4001) {

                  $totalCounteight = $totalCounteight + 1; 

            }  

        }


       if ($flage && count($babyList)!=0) {

        return ['1000'  => ($totalCountone !=0) ? round(($bCountone / $totalCountone)*100) : 0,
                '1000-1499'    => ($totalCounttwo!=0)? round(($bCounttwo / $totalCounttwo)*100) : 0,
                '1500-1999'    => ($totalCountthree!=0) ? round(($bCountthree / $totalCountthree)*100) : 0,
                '2000-2499'    => ($totalCountfour!=0) ?  round(($bCountfour / $totalCountfour)*100): 0,
                '2500-2999'    => ($totalCountfive!=0) ?  round(($bCountfive /  $totalCountfive)*100): 0,
                '3000-3499'    => ($totalCountsix !=0) ?  round(($bCountsix / $totalCountsix)*100): 0,
                '3500-3999'    => ($totalCountseven!=0) ? round(($bCountseven / $totalCountseven)*100) : 0,
                '4000'         => ($totalCounteight!=0) ? round(($bCounteight / $totalCounteight)*100) :0];
        } else {

             return ['1000' => $bCountone,
                     '1000-1499'   => $bCounttwo,
                     '1500-1999'   => $bCountthree,
                     '2000-2499'   => $bCountfour,
                     '2500-2999'   => $bCountfive,
                     '3000-3499'   => $bCountsix,
                     '3500-3999'   => $bCountseven,
                     '4000'        => $bCounteight];
        }  

    }

    private function inbornOutbornadmission($babyList, $flage = true) 
    {

        $babyList   = collect($babyList);

        if ($flage && count($babyList)!=0) {
            return ['Inborn'    => number_format(($babyList->where('BirthStatus', 'Inborn')->count()/count($babyList))*100, 2),
                    'Outborn'   => number_format(($babyList->where('BirthStatus', 'Outborn')->count()/count($babyList))*100, 2)];
        } else {
            return ['Inborn'    => $babyList->where('BirthStatus', 'Inborn')->count(),
                    'Outborn'   => $babyList->where('BirthStatus', 'Outborn')->count()];
        }  

    }


    private function inbornNicuadmission($babyList, $flage = true) 
    {


        $babyList   = collect($babyList);

        if ($flage && count($babyList)!=0) {
            return ['intensive_care'  => number_format(($babyList->where('TypeOfCare', 'Intensive Care')->count()/count($babyList))*100, 2),
                    'special_care'    => number_format(($babyList->where('TypeOfCare', 'Special Care')->count()/count($babyList))*100, 2),
                    'high_dependancy_care' => number_format(($babyList->where('TypeOfCare', 'High Dependancy Care')->count()/count($babyList))*100, 2)];
        } else {
            return ['intensive_care'        => $babyList->where('TypeOfCare', 'Intensive Care')->count(),
                    'special_care'          => $babyList->where('TypeOfCare', 'Special Care')->count(),
                    'high_dependancy_care'  => $babyList->where('TypeOfCare', 'High Dependancy Care')->count()];
        }  


    }

    private function patientDays($daycareList, $flage = true) 
    {

         $daycareList = collect($daycareList);

         if ($flage && count($daycareList)!=0) {

             return ['patient_days'=>  number_format(($daycareList->count()/365)*100, 2)];

         } else {

             return ['patient_days'=>  $daycareList->count()];

         }    


    }

    private function chronicLungdiseaseList($daycareList, $nicuList) 
    {

        $modeOfventilation  =  $dayoflifeFio2 = $cgaFio2 = $result =  array();

        $nicuList = collect($nicuList);


        foreach ($daycareList as $key => $value) {
            $gestation= json_decode($value->Gestation);

            if (!empty(trim($value->Ventilation_choose)) && trim($value->Ventilation_choose) != 'Spontaneouslyventilating' && $gestation->g_weeks > 32 && (int)$value->DayOfLife  >= 28 & !empty($value->FiO2) && trim((int)$value->FiO2) > 21) {

               $modeOfventilation[] =['babyId'=>$value->BabyId, 'dayofLife'=>(int)$value->DayOfLife];


            }
            $cga = json_decode($value->CGA);

              if (isset($value->chronic_lung) && $value->chronic_lung == 2) {

                 $dayoflifeFio2[] = ['babyId'=>$value->BabyId, 'dayofLife'=>(int)$value->DayOfLife];

               }

           $gestation = (array)json_decode($value->Gestation);

            

           if (isset($gestation['g_weeks']) && !empty(trim($gestation['g_weeks'])) && (int)$gestation['g_weeks'] >= 36 && trim((int)$value->FiO2) > 21) {

              $cgaFio2[] = ['babyId'=>$value->BabyId, 'dayofLife'=>(int)$value->DayOfLife];

           }

        }

         $result['o2_requirement_day_28']  = count(\SiteHelpers::unique_multidim_array($modeOfventilation, 'babyId')); 
         $result['o2_requirement_week_36'] = count(\SiteHelpers::unique_multidim_array($dayoflifeFio2, 'babyId'));
         $result['homeOxygen']             = $nicuList->where('HomeOxygen', 'Yes')->count();
        
         return $result ;

    }


    private function respiratoryTherapy($daycareList, $nicuList) 
    {

        $nicuList    = collect($nicuList);

        $daycareList = collect($daycareList);

        $results['surfactant']                = $nicuList->where('SurfactantGiven', 'Yes')->count(); 

        $results['Invasive_ventilation_days'] = $daycareList->where('InvasiveVentilation', 'Yes')->count(); 
   
        $results['CPAP']                      = $daycareList->where('InvasiveVentilation', 'No')->where('Ventilation_choose', 'NonInvasiveVentilation')->where('NonInvasiveVentilation', 'CPAP')->count(); 

        $results['NIPPV']                     = $daycareList->where('InvasiveVentilation', 'No')->where('Ventilation_choose', 'NonInvasiveVentilation')->where('NonInvasiveVentilation', 'NIMV/NIPPV')->count();

        $results['HHHFNC']                    = $daycareList->where('InvasiveVentilation', 'No')->where('Ventilation_choose', 'NonInvasiveVentilation')->where('NonInvasiveVentilation', 'HHHFNC')->count();

        $results['nasal_prongs']              = $daycareList->where('InvasiveVentilation', 'No')->where('Ventilation_choose', 'OtherRespiratorySupport')->where('OtherRespiratorySupport', 'NPO2')->count();
        
        $results['head_box']                  = $daycareList->where('InvasiveVentilation', 'No')->where('Ventilation_choose', 'OtherRespiratorySupport')->where('OtherRespiratorySupport', 'HBO2')->count();

        return $results;



    }


    private function surfactantTherapy($daycareList) 
    {

       $daycareList = collect($daycareList);
       $daycareList = $daycareList->where('Surfactant_therapy_nicu', 'Yes');

       $baby = array();
       $respiratory = \SiteHelpers::create_mas_object('RespiratoryIndication');
       $respiratoryNames = $respiratory->getFieldvalue();

        // fetch  the unique indication based on baby
        foreach ($daycareList as $dayKey => $daycareSheet) {
            if (array_key_exists($daycareSheet->BabyId, $baby)) {
                $tempsuf = (!empty($daycareList->surfactant_indication)) ? unserialize($daycareSheet->surfactant_indication) : array();

                $baby[$daycareSheet->BabyId] = array_merge($baby[$daycareSheet->BabyId], $tempsuf);

            } else {

                 $baby[$daycareSheet->BabyId] = (!empty($daycareSheet->surfactant_indication)) ? unserialize($daycareSheet->surfactant_indication): array();
            }  


            $baby[$daycareSheet->BabyId] = array_unique($baby[$daycareSheet->BabyId]);
        }

        $indicationList = array();

       foreach ($baby as $babyKey => $indicationGroup) {

          foreach ($indicationGroup as $indicationKey => $indicationValue) {
             if (!empty($indicationValue)) {  
                 if (array_key_exists($indicationValue, $indicationList)) {
                        array_push($indicationList[$respiratoryNames[$indicationValue]], $babyKey);
                 } else {
                   // echo "<pre>";print_r($indicationValue);exit;

                    $indicationList[str_replace(' ', '_', trim($respiratoryNames[$indicationValue]))][] = $babyKey;
                 }
              }   
          }
          
       }
       foreach ($indicationList as $key => $value) {
          $indicationList[$key] = count($value); 
       }

       return $indicationList;

    }

    private function cardiovascularMorbidites($daycareList) 
    {

        $daycareList =  collect($daycareList);

        $results['inotropes']    = $daycareList->where('Inotropes', 'Yes')->count();
        $results['medical_pda']  = $daycareList->where('PDA', 'Yes')->where('PDATreatment', 'Medical')->count(); 
        $results['surgical_pda'] = $daycareList->where('PDA', 'Yes')->where('PDATreatment', 'Surgical')->count();  
        $results['pphn']         = $daycareList->where('pphn', 'Yes')->count(); 


       return $results;
    }

    private function gastrointestinalMorbidites($daycareList) 
    {

        $daycareList = collect($daycareList);
        $results['Nec'] =  $results['Tpn'] = 0;

         foreach ($daycareList as $key => $value) {
            
            if (trim($value->NEC) == "Yes") {
              $results['Nec'] = $results['Nec'] + 1;
            }
            if (trim($value->Tpn) == "Yes") {

               $results['Tpn'] = $results['Tpn'] + 1;
            }


         }

       
        return $results;
    }
    private function retinopathyPrematurity($nicuList) 
    {
         $nicuList =  collect($nicuList);

         $results['rop_screening'] = $nicuList->where('RopScreening', 'Performed')->count();

         $results['rop_treatment'] = $nicuList->where('ROPTreatment', 'Yes')->count();

         $results['rop_findings'] = 0;

         foreach ($nicuList as $key => $value) {

            if (trim($value->Rop) == "Plus disease" ||trim($value->Rop) == "Stage1 ROP" || trim($value->Rop) == "Stage2 ROP" || trim($value->Rop) == "Stage3 ROP" || trim($value->Rop) == "Stage4 ROP" || trim($value->Rop) == "Aggressive Posterior ROP") {
                $results['rop_findings'] = $results['rop_findings']+1; 
            }

         } 

         return $results;
    }

    private function diedBabyList($babyList)
    {

        $results = array();

        foreach ($babyList as $key => $value) {

            $start    = strpos($value->Problems, '<ol>');
            $end      = strpos($value->Problems, '</ol>');

            $problems = substr($value->Problems, $start, $end-$start);
            $problems = str_replace('</li>', ',', $problems);
            $problems = strip_tags($problems);
            $results[]  = array('gestation'    => \SiteHelpers::decode_gestation($value->Gestation),
                                'birthweight'  => $value->BirthWeight,
                                'causeofdeath' => $problems);

        }

        return $results;


    }

    private function proceduresList($differenceDates)
    {


 
        $intubationBaby = $intercostalBaby = $uacBaby = $uvcBaby = $pacBaby = $piccBaby = array();


        foreach ($differenceDates as $key => $value) {

           $daycareList = $this->annualreports->getProceduredaycarelist($value['start_date'], $value['end_date']);

            foreach ($daycareList as $babyList) {

                if ($babyList->InvasiveVentilation == 'Yes' || $babyList->EtTube == 'Yes') {

                    $intubationBaby[$babyList->BabyId][] =['dayoflife'=>$babyList->DayOfLife]; 
                }  
                if ($babyList->intercostaldrain == 2) {

                    $intercostalBaby[$babyList->BabyId][] =['dayoflife'=>$babyList->DayOfLife]; 
                }
                if ($babyList->Uac == 'Yes') {

                    $uacBaby[$babyList->BabyId][] = ['dayoflife'=>$babyList->DayOfLife]; 
                }

                if ($babyList->Uvc == 'Yes') {

                    $uvcBaby[$babyList->BabyId][] = ['dayoflife'=>$babyList->DayOfLife]; 
                }

                if ($babyList->Pac == 'Yes') {

                    $pacBaby[$babyList->BabyId][] = ['dayoflife'=>$babyList->DayOfLife];
                }

                if ($babyList->Picc == 'Yes') {

                     $piccBaby[$babyList->BabyId][] = ['dayoflife'=>$babyList->DayOfLife];
                }



            }
            $nicuBabylist       = $this->annualreports->inoutbornNicubabylist($value['start_date'], $value['end_date']); 
            $nicuBabylist       = collect($nicuBabylist); 
            $dates[]            = date('M-Y', strtotime($value['start_date']));
            $daycareList        = collect($daycareList);

            $results['Endotracheal_intubation'][]                        = $this->getProcedurecount($intubationBaby); 
            $results['Intercostal_tube_insertion'][]                     = $this->getProcedurecount($intercostalBaby); 
            $results['Lumbar_puncture'][]                                = $daycareList->where('lumbar_puncture', 'Performed')->count();
            $results['Umbilical_arterial_catheterization'][]             = $this->getProcedurecount($uacBaby); 
            $results['Umbilical_venous_catheterization '][]              = $this->getProcedurecount($uvcBaby);
            $results['Peripheral_arterial_catheterization'][]            = $this->getProcedurecount($pacBaby);
            $results['Percutaneously_inserte_central_venous_catheter'][] = $this->getProcedurecount($piccBaby);
            $results['USG_abdomen'][]                                    = $daycareList->where('ultrasoundabdominal', 2)->count();
            $results['USG_KUB'][]                                        = $daycareList->where('renalultrasound', 2)->count();
            $results['USG_Spine'][]                                      = $daycareList->where('ultrasound_spine', 2)->count();
            $results['Echocardiogram'][]                                 = $daycareList->where('echo_status', 'Yes')->count();
            $results['EEG'][]                                            = $daycareList->where('eeg_cfm', 2)->count();
            $results['Double_volume_exchange_transfusion'][]             = $daycareList->where('NNJTreatment', 'Exchange transfusion')->count();
            $results['Chest_and_Abdominal_X_ray'][]                      = $nicuBabylist->where('InitialXray', 'Performed')->count(); 
            $results['Pericardiocentesis'][]                             = $daycareList->where('needlethoracentesis', 2)->count();
            $results['MRI'][]                                            = $daycareList->where('mrict_brain_status', 2)->count();


        }

         $results['dates'] = $dates;

         return $results;

    }

    protected function getProcedurecount($daycareBaby)
    {

        $daycareBaby = array_sort_recursive($daycareBaby);

        $daycount = 0 ;

        foreach ($daycareBaby as $babyList) {
            $daycount +=1;
            foreach ($babyList as $subKey => $sublist) {
           
                if ($subKey != 0) {
                    $prekey = $subKey - 1 ; 
                    if (isset($babyList[$prekey]['dayoflife']) && ($babyList[$subKey]['dayoflife']-$babyList[$prekey]['dayoflife'])>1) {
                       $daycount +=1 ; 
                    }     
                }
            }
        }

       return $daycount;
    }

    private function getOrganizam($daycareBaby)
    {

        $daycareBaby   = collect($daycareBaby);
        $temp_organism = $temp_organism_group =  array(); 

        foreach ($daycareBaby as $key => $value) {

             if (!empty(trim($value->Organism)) && \SiteHelpers::is_serialized($value->Organism) && count(unserialize($value->Organism)) > 0 && !empty(unserialize($value->Organism)[0])) {
                $temp_organism[$value->BabyId][] =['dayoflife'=>$value->DayOfLife,'organizam'=> unserialize($value->Organism)];
                $temp_organism_group[$value->BabyId][$value->DayOfLife] = unserialize($value->Organism);

             }

        }
        
        $temp_organism_group  = array_collapse($temp_organism_group);
        $temp_organism_group  = array_unique(array_collapse($temp_organism_group));
        $temp_organism_titles = array();

        foreach ($temp_organism_group as $key => $value) {

            if (!empty($value)) {

              $temp_organism_titles[$value] = 0;

            }   
        }
        $temp_organism = array_sort_recursive($temp_organism);

        foreach ($temp_organism as $primaryKey => $temp_organism_count) {

            foreach ($temp_organism_count as $secoundaryKey => $temp_organism_count_value) {

                foreach ($temp_organism_titles as $title => $titleName) {
                   
                    if ($secoundaryKey != 0 && in_array($title, $temp_organism_count_value['organizam'])) {
                      
                        $prekey = $secoundaryKey - 1 ; 
                       
                        if (isset($temp_organism_count[$prekey]['dayoflife']) && ($temp_organism_count[$secoundaryKey]['dayoflife']-$temp_organism_count[$prekey]['dayoflife']) >= 2) {
                          
                           $temp_organism_titles[$title] +=1 ; 
                       
                        }     

                    } elseif ($secoundaryKey == 0 && in_array($title, $temp_organism_count_value['organizam'])) {
                            
                            $temp_organism_titles[$title] +=1 ; 

                    }
                }            
            }
        }

        return $temp_organism_titles;
    }

     /**
     * print a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function printData($startdate, $enddate)
    {

          
    }

   
 
}
