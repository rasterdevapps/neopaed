@extends('app')
@section('content')

<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Settings\UsergroupController@index') }}">Usergroups</a>
        </li>
        <li class="current">
            <a title="">Create</a>
        </li>                        
    </ul>
</div>
<!-- /Breadcrumbs line -->

<div class="row row-spacing usergroups mb-15">
    <div class="col-md-12">
        {!! Form::open(['url' => action('Settings\UsergroupController@store'), 'id'=>'user-group-form']) !!}
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('RoleName','User Group Name:') !!}
                {!! Form::text('RoleName',null,['class'=>'form-control input-fields-shadow']) !!}
            </div>            
            <input type="hidden" name="Status" value="Active" />            
        </div>
        <div class="col-md-12">
            <div class="mt-10 widget box row mx-0">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <table class="col-md-12 full-width form-group">
                        <thead>
                            <tr>
                                <th><b>Top Level</b></th>
                                <th><b>Module</b></th>
                                <th><input type="checkbox" name="select_read" id="select_read" /> <span>Read</span></th>
                                <th><input type="checkbox" name="select_write" id="select_write" /> <span>Write</span></th>                                                                        
                                <th><input type="checkbox" name="select_delete" id="select_delete" /> <span>Delete</span></th>                                                                        
                            </tr>       
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ Lang::get('menu.side_menu_registartion') }}</td>
                                <td>{{ Lang::get('menu.side_menu_mother_registartion') }}</td>
                                <td><input type="checkbox" name="read_permission[MOTHER_REG]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MOTHER_REG]" class="write"/></td>             
                                <td><input type="checkbox" name="delete_permission[MOTHER_REG]" class="delete"/></td>           	
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_baby_registartion') }}</td>
                                <td><input type="checkbox" name="read_permission[BABY_REG]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[BABY_REG]" class="write"/></td>           	
                                <td><input type="checkbox" name="delete_permission[BABY_REG]" class="delete"/></td>               
                            </tr>    

                            <tr>
                                <td>Neonatal</td>
                                <td>{{ Lang::get('menu.side_menu_neonatal_proforma') }}</td>
                                <td><input type="checkbox" name="read_permission[NEONATAL]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NEONATAL]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[NEONATAL]" class="delete"/></td>               
                            </tr>      

                            <tr>
                                <td>{{ Lang::get('menu.side_menu_nicu_admission') }}</td>
                                <td>{{ Lang::get('menu.side_menu_nicu_admission_proforma') }}</td>
                                <td><input type="checkbox" name="read_permission[NICU_FORM]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NICU_FORM]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[NICU_FORM]" class="delete"/></td>               
                            </tr>                                                         
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_nicu_daycare') }}</td>
                                <td><input type="checkbox" name="read_permission[NICU_DAY]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NICU_DAY]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[NICU_DAY]" class="delete"/></td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_nicu_discharge_summary') }}</td>
                                <td><input type="checkbox" name="read_permission[NICU_PROBLEM_DAY]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NICU_PROBLEM_DAY]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[NICU_PROBLEM_DAY]" class="delete"/></td>               
                            </tr>                                                          
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_nicu_discharge_details') }}</td>
                                <td><input type="checkbox" name="read_permission[NICU_DISCHARGE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NICU_DISCHARGE]" class="write" /></td>                                      
                                <td>-</td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_nicu_problem_summary') }}</td>
                                <td><input type="checkbox" name="read_permission[NICU_PROBLEM_DISCHARGE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NICU_PROBLEM_DISCHARGE]" class="write" /></td>                                      
                                <td>-</td>               
                            </tr> 
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_nicu_clinical_events') }}</td>
                                <td><input type="checkbox" name="read_permission[CLINICAL_EVENT]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[CLINICAL_EVENT]" class="write" /></td>                                      
                                <td>-</td>               
                            </tr> 

                            <tr>
                                <td>Nurse</td>
                                <td>{{ Lang::get('menu.side_menu_nurse_daycare') }}</td>
                                <td><input type="checkbox" name="read_permission[NICU_NURSE_DAY]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NICU_NURSE_DAY]" class="write" /></td> 
                                <td><input type="checkbox" name="delete_permission[NICU_NURSE_DAY]" class="delete"/></td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_nurse_hourly_sheet') }}</td>
                                <td><input type="checkbox" name="read_permission[NICU_MODULE_SHEET]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NICU_MODULE_SHEET]" class="write" /></td> 
                                <td><input type="checkbox" name="delete_permission[NICU_MODULE_SHEET]" class="delete"/></td>               
                            </tr>
                                
                            <tr>
                                <td>Pediatric Admission</td>
                                <td></td>
                                <td><input type="checkbox" name="read_permission[PEDI_FORM]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[PEDI_FORM]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[PEDI_FORM]" class="delete"/></td>               
                            </tr>   

                            <tr>
                                <td>{{ Lang::get('menu.side_menu_postnatal_admission') }}</td>
                                <td>{{ Lang::get('menu.side_menu_postnatal_admission') }}</td>
                                <td><input type="checkbox" name="read_permission[POST_FORM]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[POST_FORM]" class="write" /></td>                                     
                                <td><input type="checkbox" name="delete_permission[POST_FORM]" class="delete"/></td>               
                            </tr>                                                         
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_postnatal_daycare') }}</td>
                                <td><input type="checkbox" name="read_permission[POST_DAY]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[POST_DAY]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[POST_DAY]" class="delete"/></td>               
                            </tr> 
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_postnatal_problem') }}</td>
                                <td><input type="checkbox" name="read_permission[POST_PROBLEM_SYSTEM]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[POST_PROBLEM_SYSTEM]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[POST_PROBLEM_SYSTEM]" class="delete"/></td>               
                            </tr>                                                           
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_postnatal_summary') }}</td>
                                <td><input type="checkbox" name="read_permission[POST_DISCHARGE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[POST_DISCHARGE]" class="write" /></td>                                     
                                <td>-</td>               
                            </tr>

                            <tr>
                                <td>OP</td>
                                <td>{{ Lang::get('menu.side_menu_op_registration') }}</td>
                                <td><input type="checkbox" name="read_permission[OP_REG]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[OP_REG]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[OP_REG]" class="delete"/></td>               
                            </tr>    
                            
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_pediatrics_op_registration') }}</td>
                                <td><input type="checkbox" name="read_permission[PEDIATRICS_OP_REG]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[PEDIATRICS_OP_REG]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[PEDIATRICS_OP_REG]" class="delete"/></td>               
                            </tr>
                             <tr>
                                <td>OP</td>
                                <td>{{ Lang::get('menu.side_menu_op') }}</td>
                                <td><input type="checkbox" name="read_permission[OP_NEONATAL]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[OP_NEONATAL]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[OP_NEONATAL]" class="delete"/></td>               
                            </tr>     
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_op_neonatal') }}</td>
                                <td><input type="checkbox" name="read_permission[NEONATAL_OP_BASIC]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NEONATAL_OP_BASIC]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[NEONATAL_OP_BASIC]" class="delete"/></td>               
                            </tr> 
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_neuro') }}</td>
                                <td><input type="checkbox" name="read_permission[NEURO_DEVELOPMENT]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NEURO_DEVELOPMENT]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[NEURO_DEVELOPMENT]" class="delete"/></td>               
                            </tr>
                              <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_neuro_basic') }}</td>
                                <td><input type="checkbox" name="read_permission[NEURO_DEVELOPMENT_BASIC]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NEURO_DEVELOPMENT_BASIC]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[NEURO_DEVELOPMENT_BASIC]" class="delete"/></td>               
                            </tr>
                              <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_neuro_screening') }}</td>
                                <td><input type="checkbox" name="read_permission[SCREENING_ASSESSMENT]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_ASSESSMENT]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_ASSESSMENT]" class="delete"/></td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_hnne') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_HNNE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_HNNE]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_HNNE]" class="delete"/></td>               
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_hine') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_HINE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_HINE]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_HINE]" class="delete"/></td>               
                            </tr> 
                             <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_m_chat') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_M_CHAT]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_M_CHAT]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_M_CHAT]" class="delete"/></td>               
                            </tr> 
                             <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_dasii') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_DASII]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_DASII]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_DASII]" class="delete"/></td>               
                            </tr> 
                             <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_ddst') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_DDST]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_DDST]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_DDST]" class="delete"/></td>               
                            </tr> 
                             <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_cbcl') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_CBCL]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_CBCL]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_CBCL]" class="delete"/></td>               
                            </tr>
                             <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_bayley') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_BAYLEY]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_BAYLEY]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_BAYLEY]" class="delete"/></td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_shortcode') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_SHORTCODE]" class="read"/></td>
                                <td><input type="checkbox" name="write_permission[MAS_SHORTCODE]" class="write"/></td>
                                <td><input type="checkbox" name="delete_permission[MAS_SHORTCODE]" class="delete"/></td>               
                            </tr>
                             <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_issa') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_ISSA]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_ISSA]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_ISSA]" class="delete"/></td>               
                            </tr> 
                             <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_cars') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_CARS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_CARS]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_CARS]" class="delete"/></td>               
                            </tr> 
                             <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_infants') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_INFANTS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_INFANTS]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_INFANTS]" class="delete"/></td>               
                            </tr> 
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_preschoolers') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_PRESCHOOLERS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_PRESCHOOLERS]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_PRESCHOOLERS]" class="delete"/></td>               
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_pep3') }}</td> 
                                <td><input type="checkbox" name="read_permission[SCREENING_PEP3]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[SCREENING_PEP3]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[SCREENING_PEP3]" class="delete"/></td>               
                            </tr>

                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_feeding') }}</td>
                                <td><input type="checkbox" name="read_permission[FEEDING]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[FEEDING]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[FEEDING]" class="delete"/></td>               
                            </tr>               

                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_bayley_scale') }}</td>
                                <td><input type="checkbox" name="read_permission[BAYLEY_SCALE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[BAYLEY_SCALE]" class="write" /></td>            
                                <td><input type="checkbox" name="delete_permission[BAYLEY_SCALE]" class="delete"/></td>               
                            </tr>                                                 

                            <tr>
                                <td>{{ Lang::get('menu.side_menu_reports') }}</td>
                                <td>{{ Lang::get('menu.side_menu_inpatient_report') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_INPATIENT]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_nicu_report') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_NICU]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>                                                         
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_op_report') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_OP]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>                                                         
                           <!--  <tr>
                                <td></td>
                                <td>Pediatric Reports</td>
                                <td><input type="checkbox" name="read_permission[REPORT_PEDI]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>  --> 
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_newborn_report') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_NEWBORN]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>    
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_live_birth_report') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_BIRTH]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>      
                            <tr>
                                <td></td>
                                <td>Tag Printing</td>
                                <td><input type="checkbox" name="read_permission[REPORT_BABY]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>    
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_echo_report') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_ECHO]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr> 
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_cranial_report') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_CRANIAL]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>                                                     
                            <tr>
                                <td></td>
                                <td>Culture Report</td>
                                <td><input type="checkbox" name="read_permission[REPORT_CULTURE]" class="read" /></td>
                                <td>-</td>               
                                <td>-</td> 
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_op_activity_report') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_OP_ACTIVITY]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr> 
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_annual_reports') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_ANNUAL]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>     
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_usage_tracker') }}</td>
                                <td><input type="checkbox" name="read_permission[USAGE_TRACKER]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>     
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_nnf') }}</td>
                                <td><input type="checkbox" name="read_permission[REPORT_NNF]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>   

                            <tr>
                                <td>{{ Lang::get('menu.side_menu_tests') }}</td>
                                <td>{{ Lang::get('menu.side_menu_test_echocardiography') }}</td>
                                <td><input type="checkbox" name="read_permission[TEST_ECHO]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[TEST_ECHO]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[TEST_ECHO]" class="delete"/></td>               
                            </tr>                                                         
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_test_cranial_ultrasonography') }}</td>
                                <td><input type="checkbox" name="read_permission[TEST_ULTRA]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[TEST_ULTRA]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[TEST_ULTRA]" class="delete"/></td>               
                            </tr>                                                         
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.side_menu_test_culture_registry') }}</td>
                                <td><input type="checkbox" name="read_permission[TEST_CULTURE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[TEST_CULTURE]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[TEST_CULTURE]" class="delete"/></td>               
                            </tr>  

                            <tr>
                                <td>Growth Chart</td>
                                <td>{{ Lang::get('menu.side_menu_growth_chart') }}</td>
                                <td><input type="checkbox" name="read_permission[GROWTH_CHART]" class="read" /></td>
                                <td>-</td>
                                <td>-</td>               
                            </tr>  

                            <tr>
                                <td>Quality Indicators</td>
                                <td>{{ Lang::get('menu.side_menu_quality_indicator') }}</td>
                                <td><input type="checkbox" name="read_permission[QUALITY_INDICATORS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[QUALITY_INDICATORS]" class="write" /></td>                                     
                                <td><input type="checkbox" name="delete_permission[QUALITY_INDICATORS]" class="delete"/></td>               
                            </tr>  

                            <tr>
                                <td>Ward Management</td>
                                <td>{{ Lang::get('menu.card_ward_mangagement') }}</td>
                                <td><input type="checkbox" name="read_permission[WARD_MANAGEMENT]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[WARD_MANAGEMENT]" class="write" /></td>                                     
                                <td>-</td>               
                            </tr>  

                            <tr>
                                <td>HeRo</td>
                                <td>{{ Lang::get('menu.card_hero') }}</td>
                                <td><input type="checkbox" name="read_permission[HERO]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[HERO]" class="write" /></td>                                     
                                <td>-</td>               
                            </tr> 

                            <tr>
                                <td>nSOFA</td>
                                <td>{{ Lang::get('menu.card_nsofa_score') }}</td>
                                <td><input type="checkbox" name="read_permission[NSOFA]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NSOFA]" class="write" /></td>                                     
                                <td>-</td>               
                            </tr>  

                            <tr>
                                <td>MSNS</td>
                                <td>{{ Lang::get('menu.card_msns_score') }}</td>
                                <td><input type="checkbox" name="read_permission[MSNS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MSNS]" class="write" /></td>                                     
                                <td>-</td>               
                            </tr> 

                            <tr>
                                <td>NICU Timeline</td>
                                <td>{{ Lang::get('menu.card_nicu_time_line') }}</td>
                                <td><input type="checkbox" name="read_permission[NICU_TIME_LINE]" class="read" /></td>
                                <td>-</td>               
                                <td>-</td>               
                            </tr> 

                            <tr>
                                <td>Nutrition Chart</td>
                                <td>{{ Lang::get('menu.card_nutrition_chart') }}</td>
                                <td><input type="checkbox" name="read_permission[NUTRITION_CHART]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[NUTRITION_CHART]" class="write" /></td>                                     
                                <td>-</td>               
                            </tr> 



                            <!-- <tr>
                                <td></td>
                                <td>Lab Request</td>
                                <td><input type="checkbox" name="read_permission[LABREQUEST]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[LABREQUEST]" class="write" /></td>                                      
                                <td>-</td>               
                            </tr> -->

                            <tr>
                                <td>Prescription</td>
                                <td>{{ Lang::get('menu.side_menu_prescription') }}</td>
                                <td><input type="checkbox" name="read_permission[PRESCRIPTION]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[PRESCRIPTION]" class="write" /></td>                                      
                                <td>-</td>               
                            </tr>      

                            <tr>
                                <td>Calculators</td>
                                <td>{{ Lang::get('menu.side_menu_calculators') }}</td>
                                <td><input type="checkbox" name="read_permission[CALCULATOR]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[CALCULATOR]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[CALCULATOR]" class="delete"/></td>               
                            </tr>      

                            <tr>
                                <td>{{ Lang::get('menu.card_home_calendar') }}</td>
                                <td></td>
                                <td><input type="checkbox" name="read_permission[CALENDAR]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[CALENDAR]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[CALENDAR]" class="delete"/></td>               
                            </tr>  

                            <tr>
                                <td>Approval</td>
                                <td>{{ Lang::get('menu.side_menu_delete_approvals') }}</td>
                                <td><input type="checkbox" name="read_permission[DELETE_ACCESS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[DELETE_ACCESS]" class="write" /></td>                                      
                                <td>-</td>               
                            </tr>        

                            <tr class="hide">
                                <td>{{ Lang::get('menu.top_menu_antibiotics') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_ANTIBIOTICS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_ANTIBIOTICS]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_ANTIBIOTICS]" class="delete"/></td>               
                            </tr>                                                         
                            <tr>
                                <td>{{ Lang::get('menu.top_menu_masters') }}</td>
                                <td>{{ Lang::get('menu.top_menu_complications') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_COMPLICATIONS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_COMPLICATIONS]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_COMPLICATIONS]" class="delete"/></td>               
                            </tr>                                                         
                           <!--  <tr>
                                <td></td>
                                <td>Drugs</td>
                                <td><input type="checkbox" name="read_permission[MAS_DRUGS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_DRUGS]" class="write" /></td>                                     
                                <td><input type="checkbox" name="delete_permission[MAS_DRUGS]" class="delete"/></td>               
                            </tr>   -->
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_medical_problems') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_M_PROBLEM]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_M_PROBLEM]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_M_PROBLEM]" class="delete"/></td>               
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_procedures') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_B_PROCEDUURE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_B_PROCEDUURE]" class="write" /></td>                                     
                                <td><input type="checkbox" name="delete_permission[MAS_B_PROCEDUURE]" class="delete"/></td>               
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_problems') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_B_PROBLEM]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_B_PROBLEM]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_B_PROBLEM]" class="delete"/></td>               
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_vaccines') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_VACCINE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_VACCINE]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_VACCINE]" class="delete"/></td>               
                            </tr>   
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_vaccine_age') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_VACCINE_AGE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_VACCINE_AGE]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_VACCINE_AGE]" class="delete"/></td>               
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_indication') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_INDICATION]" class="read"/></td>
                                <td><input type="checkbox" name="write_permission[MAS_INDICATION]" class="write"/></td>
                                <td><input type="checkbox" name="delete_permission[MAS_INDICATION]" class="delete"/></td>               
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_vaccine_generic_name') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_VACCINE_GENERIC]" class="read"/></td>
                                <td><input type="checkbox" name="write_permission[MAS_VACCINE_GENERIC]" class="write"/></td>
                                <td><input type="checkbox" name="delete_permission[MAS_VACCINE_GENERIC]" class="delete"/></td>               
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_doctors_surgeons') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_DOCTORS]" class="read"/></td>
                                <td><input type="checkbox" name="write_permission[MAS_DOCTORS]" class="write"/></td>
                                <td><input type="checkbox" name="delete_permission[MAS_DOCTORS]" class="delete"/></td>               
                            </tr>  
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_admission_mode') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_ADMISSIONMODE]" class="read"/></td>
                                <td><input type="checkbox" name="write_permission[MAS_ADMISSIONMODE]" class="write"/></td>
                                <td><input type="checkbox" name="delete_permission[MAS_ADMISSIONMODE]" class="delete"/></td>               
                            </tr> 
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_respiratory_indication') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_RESPIRATORYINDICATION]" class="read"/></td>
                                <td><input type="checkbox" name="write_permission[MAS_RESPIRATORYINDICATION]" class="write"/></td>
                                <td><input type="checkbox" name="delete_permission[MAS_RESPIRATORYINDICATION]" class="delete"/></td>               
                            </tr>
                            <!-- <tr>
                                <td></td>
                                <td>Staff List </td>
                                <td><input type="checkbox" name="read_permission[MAS_STAFF]" class="read"/></td>
                                <td><input type="checkbox" name="write_permission[MAS_STAFF]" class="write"/></td>
                                <td><input type="checkbox" name="delete_permission[MAS_STAFF]" class="delete"/></td>               
                            </tr>  --> 
                          <!--   <tr>
                                <td></td>
                                <td>IV Fluids</td>
                                <td><input type="checkbox" name="read_permission[MAS_IVFLUIDS]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_IVFLUIDS]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_IVFLUIDS]" class="delete"/></td>               
                            </tr> -->
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_nurse_master') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_NURSE_LIST]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_NURSE_LIST]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_NURSE_LIST]" class="delete"/></td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_referral') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_REFERRAL]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_REFERRAL]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_REFERRAL]" class="delete"/></td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_ward') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_WARD]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_WARD]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_WARD]" class="delete"/></td>               
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Lang::get('menu.top_menu_bed') }}</td>
                                <td><input type="checkbox" name="read_permission[MAS_BED]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_BED]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_BED]" class="delete"/></td>               
                            </tr>
                            <!-- <tr>
                                <td></td>
                                <td>Collection Method Master</td>
                                <td><input type="checkbox" name="read_permission[MAS_COLLECTION_METHOD]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_COLLECTION_METHOD]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_COLLECTION_METHOD]" class="delete"/></td>               
                            </tr>

                            <tr>
                                <td></td>
                                <td>Collection Site Master</td>
                                <td><input type="checkbox" name="read_permission[MAS_COLLECTION_SITE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_COLLECTION_SITE]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_COLLECTION_SITE]" class="delete"/></td>               
                            </tr> -->

                          <!--   <tr>
                                <td></td>
                                <td>Drug And Infusion</td>
                                <td><input type="checkbox" name="read_permission[MAS_DRUGS_AND_INFUSION]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[MAS_DRUGS_AND_INFUSION]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[MAS_DRUGS_AND_INFUSION]" class="delete"/></td>               
                            </tr> -->
                           <!--  <tr>
                                <td></td>
                                <td>Department</td>
                                <td><input type="checkbox" name="read_permission[MAS_DEPARTMENT]" class="read"></td>
                                <td><input type="checkbox" name="write_permission[MAS_DEPARTMENT]" class="write"></td>
                                <td><input type="checkbox" name="delete_permission[MAS_DEPARTMENT]" class="delete"/></td>               
                            </tr> -->

                        <!--     <tr>
                                <td></td>
                                <td>Investigation</td>
                                <td><input type="checkbox" name="read_permission[MAS_INVESTIGATION]" class="read"></td>
                                <td><input type="checkbox" name="write_permission[MAS_INVESTIGATION]" class="write"></td>
                                <td><input type="checkbox" name="delete_permission[MAS_INVESTIGATION]" class="delete"/></td>               
                            </tr>
                        -->
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_freq') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_FREQUENCY]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_FREQUENCY]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_FREQUENCY]" class="delete"/></td>               
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_dose') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_DOSE]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_DOSE]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_DOSE]" class="delete"/></td>               
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_drugivfluid') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_DRUG_IVFLUID]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_DRUG_IVFLUID]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_DRUG_IVFLUID]" class="delete"/></td>               
                        </tr>                            
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_prescriptiontype') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_PRESCRIPTION_TYPE]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_PRESCRIPTION_TYPE]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_PRESCRIPTION_TYPE]" class="delete"/></td>               
                        </tr>                       
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_investigations') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_INVESTIGATIONS]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_INVESTIGATIONS]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_INVESTIGATIONS]" class="delete"/></td>               
                        </tr>                  
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_m_chat_r_questions') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_M_CHAT_R_QUESTIONS]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_M_CHAT_R_QUESTIONS]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_M_CHAT_R_QUESTIONS]" class="delete"/></td>               
                        </tr>            
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_m_chat_r_followup_questions') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_M_CHAT_R_FOLLOWUP_QUESTIONS]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_M_CHAT_R_FOLLOWUP_QUESTIONS]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_M_CHAT_R_FOLLOWUP_QUESTIONS]" class="delete"/></td>               
                        </tr>            
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_dasii_questions') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_DASII_QUESTIONS]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_DASII_QUESTIONS]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_DASII_QUESTIONS]" class="delete"/></td>               
                        </tr>              
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_cbcl_questions') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_CBCL_QUESTIONS]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_CBCL_QUESTIONS]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_CBCL_QUESTIONS]" class="delete"/></td>               
                        </tr>          
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_ddst_questions') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_DDST]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_DDST]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_DDST]" class="delete"/></td>               
                        </tr>       
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_bayley_scale') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_BAYLEY_SCALE]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_BAYLEY_SCALE]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_BAYLEY_SCALE]" class="delete"/></td>               
                        </tr>        
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_issa_questions') }}</td>
                            <td><input type="checkbox" name="read_permission[MAS_ISSA_QUESTIONS]" class="read"></td>
                            <td><input type="checkbox" name="write_permission[MAS_ISSA_QUESTIONS]" class="write"></td>
                            <td><input type="checkbox" name="delete_permission[MAS_ISSA_QUESTIONS]" class="delete"/></td>               
                        </tr>


                        <tr>
                            <td>{{ Lang::get('menu.top_menu_settings') }}</td>
                            <td>{{ Lang::get('menu.top_menu_usergroups') }}</td>
                            <td><input type="checkbox" name="read_permission[USER_GROUPS]" class="read" /></td>
                            <td><input type="checkbox" name="write_permission[USER_GROUPS]" class="write" /></td>                                      
                            <td><input type="checkbox" name="delete_permission[USER_GROUPS]" class="delete"/></td>               
                        </tr>                                     
                        <tr>
                            <td></td>
                            <td>{{ Lang::get('menu.top_menu_users') }}</td>
                            <td><input type="checkbox" name="read_permission[USERS]" class="read" /></td>
                            <td><input type="checkbox" name="write_permission[USERS]" class="write" /></td>                                      
                            <td>-</td>               
                        </tr>          
                                <!-- <tr>
                                    <td></td>
                                    <td>Site Config</td>
                                    <td><input type="checkbox" name="read_permission[SITE_CONFIG]" class="read" /></td>
                                    <td><input type="checkbox" name="write_permission[SITE_CONFIG]" class="write" /></td> 
                                    <td>-</td>               
                                </tr> -->    
                                <tr>
                                    <td></td>
                                    <td>{{ Lang::get('menu.top_menu_site_settings') }}</td>
                                    <td><input type="checkbox" name="read_permission[SITESETTING]" class="read" /></td>
                                    <td><input type="checkbox" name="write_permission[SITESETTING]" class="write" /></td> 
                                    <td>-</td>               
                                </tr>
                                <!-- <tr>
                                    <td></td>
                                    <td>Interface Log</td>
                                    <td><input type="checkbox" name="read_permission[INTERFACE_LOG]" class="read" /></td>
                                    <td><input type="checkbox" name="write_permission[INTERFACE_LOG]" class="write" /></td> 
                                    <td>-</td>               
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Fhir Formate Values</td>
                                    <td><input type="checkbox" name="read_permission[FHIR_FORMATE_VALUES]" class="read"></td>
                                    <td><input type="checkbox" name="write_permission[FHIR_FORMATE_VALUES]" class="write"></td>
                                    <td>-</td>               
                                </tr> -->
                               <!--  <tr>
                                    <td></td>
                                    <td>Snomed CT</td>
                                    <td><input type="checkbox" name="read_permission[SNOMED_CODE]" class="read"></td>
                                    <td><input type="checkbox" name="write_permission[SNOMED_CODE]" class="write"></td>
                                    <td>-</td>               
                                </tr> -->
                                <tr>
                                    <td>Module</td>
                                    <td>{{ Lang::get('menu.top_menu_psite_settings') }}</td>
                                    <td><input type="checkbox" name="read_permission[MAS_PROBLEM_SETTING]" class="read" /></td>
                                    <td><input type="checkbox" name="write_permission[MAS_PROBLEM_SETTING]" class="write" /></td> 
                                    <td><input type="checkbox" name="delete_permission[MAS_PROBLEM_SETTING]" class="delete"/></td>               
                                </tr>
                                
                           <!--  <tr>
                                <td>Pediatric Admission</td>
                                <td>Admission Proforma</td>
                                <td><input type="checkbox" name="read_permission[PEDI_FORM]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[PEDI_FORM]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[PEDI_FORM]" class="delete"/></td>               
                            </tr>                                                         
                            <tr>
                                <td></td>
                                <td>Daycare</td>
                                <td><input type="checkbox" name="read_permission[PEDI_DAY]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[PEDI_DAY]" class="write" /></td>                                      
                                <td><input type="checkbox" name="delete_permission[PEDI_DAY]" class="delete"/></td>               
                            </tr>                                                         
                            <tr>
                                <td></td>
                                <td>Discharge Summary</td>
                                <td><input type="checkbox" name="read_permission[PEDI_DISCHARGE]" class="read" /></td>
                                <td><input type="checkbox" name="write_permission[PEDI_DISCHARGE]" class="write" /></td>                                      
                                <td>-</td>               
                            </tr>    -->


                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <button type="submit" class="btn btn-primary btn-basic-shadow form-control btn-block"><i class="fa fa-floppy-o"></i> <span>Save</span></button>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <a href="{{ action('Settings\UsergroupController@index') }}" class="btn btn-default btn-basic-shadow form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        @include('errors.list')
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $("#select_write").on('click',function(){
     val = $(this).is(":checked");
     if(val){
      $(".write").prop('checked', true);
  }
  else{
      $(".write").prop('checked', false);
  }
});
    $("#select_read").on('click',function(){
     val = $(this).is(":checked");
     if(val){
      $(".read").prop('checked', true);
  }
  else{
      $(".read").prop('checked', false);
  }
});
    $("#select_delete").on('click',function(){
        val = $(this).is(":checked");
        if(val){
            $(".delete").prop('checked', true);
        }
        else{
            $(".delete").prop('checked', false);
        }
    });

    $(document).ready(function() {
        $('#user-group-form').validate({
            rules: {
                RoleName: {
                    required: true
                }
            }
        });
    });

    $(document).on('click', '#user-group-form button[type="submit"]', function(e){
        e.preventDefault();
        if ($('#user-group-form').valid() === true) {
            $(this).prop('disabled', true);

            $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            $('#user-group-form').submit();
        }
    });
</script>
@endsection
