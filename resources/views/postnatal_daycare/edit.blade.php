@extends('app')
@section('content')
<!-- @php 
if(!isset($_COOKIE['postnataldaycare'])) {
$_COOKIE['postnataldaycare'] = 'generalform';
}   
@endphp -->
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <a href="{{ url('/') }}"><i class="fa fa-home"></i></a>
        </li>
        <li class="">
            <a title="" href="{{ action('Admission\PostnatalDaycareController@index') }}">Postnatal Daycare</a>
        </li>
        <li class="">
            <a title="" href="{{ action('Admission\PostnatalDaycareController@postnatalSublist',SiteHelpers::encrypt_id($results->BabyId ))}}">Admission List</a>
        </li>
        <li class="">
            <a title="" href="{{ url('postnatal-daycare-daywiselist/'.SiteHelpers::encrypt_id($results->AdmissionId.'-'.$results->BabyId)) }}">Day List</a>
        </li>
        <li class="current">
            <a title="">Edit @if(isset($results->BabyName) && !empty($results->BabyName)) For {{ $results->BabyName }} @endif</a>
        </li>                        
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12">
        @include('errors.list')

        {!! Form::model($results,['method' => 'PATCH','url' => action('Admission\PostnatalDaycareController@update',$results->PDayId),'id' => 'postnatal_daycare_form']) !!}
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <!-- <li role="presentation" @if($_COOKIE['postnataldaycare'] == 'generalform') class="active" @endif> -->
                <li role="presentation" class="active">
                    <a href="#generalform" role="tab" data-toggle="tab">General Information</a>
                </li>
                <!-- <li role="presentation" @if($_COOKIE['postnataldaycare'] == 'otherform') class="active" @endif> -->
                <li role="presentation">
                    <a href="#otherform" role="tab" data-toggle="tab">Others</a>
                </li>
                <!-- <li role="presentation" @if($_COOKIE['postnataldaycare'] == 'planform') class="active" @endif> -->
                <li role="presentation">
                    <a href="#planform"  role="tab" data-toggle="tab"> Plan</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow">
                <!-- General Form -->
                <!-- <div role="tabpanel" class="tab-pane @if($_COOKIE['postnataldaycare'] == 'generalform') active @endif" id="generalform"> -->
                <div role="tabpanel" class="tab-pane active" id="generalform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                {!! Form::hidden('MotherId') !!}
                                {!! Form::hidden('BabyId') !!}  
                                {!! Form::hidden('AdmissionId') !!}                          
                                {!! Form::hidden('NeonatalId') !!}                             
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BabyName','Baby Name:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BabyName',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BMrNo', Lang::get('home.mrn').':') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BMrNo',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>                            
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DOB','DOB:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DOB',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Sex','Sex:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('SeenBy','Seen By:', ['class'=>'required-label']) !!}
                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Seen By" data-destination_elements="SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Seen By"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('SeenBy',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>   
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Background','Background:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('Background',null,['class'=>'form-control','rows'=>5]) !!}
                                    </div>
                                </div>                                                          
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DayDate','Date:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DayDate',null,['class'=>'form-control daycare-date', 'readonly']) !!}
                                    </div>   
                                </div> 
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('DayTime','Time:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <small>(Hour)</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <small>(Minute)</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <small>(Session)</small>
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('Dayhours',$prepare_time['time'],null,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('Daymins',$prepare_time['mins'],null,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('Dayam_pm',$prepare_time['session'],null,['class'=>'form-control']) !!}
                                            </div>
                                            <div><label for="Dayhours" generated="true" class="error help-block"></label></div>
                                            <div><label for="Daymins" generated="true" class="error help-block"></label></div>
                                            <div><label for="Dayam_pm" generated="true" class="error help-block"></label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DayOfLife','Day Of Life:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DayOfLife',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>                              
                               <!--  <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CurrentProblems','Current Problems:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('CurrentProblems',null,['class'=>'form-control','rows'=>5]) !!}
                                    </div>
                                </div>      
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PreviousProblems','Previous Problems:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('PreviousProblems',null,['class'=>'form-control','rows'=>4]) !!}
                                    </div>
                                </div>    -->   
                                <div class="form-group row mx-0 problems-container">
                                        <div class="col-md-12">
                                            {!! Form::label('CurrentProblems','Current Problems:') !!}
                                            <a href="javascript:void(0)" class="btn btn-success btn-view" id="add_cur_problem"><i class="fa fa-plus"></i></a>
                                            <!-- NOTE ====== DON'T GIVE Any SPACES IN THIS LIST -->
                                            <input type="hidden" name="CurrentProblems" id="hidden_current_problem" value="{{ $results->CurrentProblems }}">
                                            <div class="water-mark">Add Current Problem</div>
                                            <ul class="connected-sortable droppable-area1">
                                                @if(isset($results->CurrentProblems) && !empty($results->CurrentProblems))
                                                <?php 
                                                $cur_problem = explode('||', $results->CurrentProblems);
                                                if (count($cur_problem) != 0) {
                                                    foreach ($cur_problem as $key => $cur_prob_value) {

                                                        echo '<li class="draggable-item">'.$cur_prob_value.'<a class="btn btn-default btn-view"><i class="fas fa-arrows-alt"></i></a><a class="btn btn-info btn-view edit_problem"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-view remove_problems"><i class="fa fa-trash"></i></a></li>';
                                                    }
                                                }
                                                ?>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- NOTE ====== DON'T GIVE Any SPACES IN THIS LIST -->
                                    <div class="form-group row mx-0 problems-container">
                                        <div class="col-md-12">
                                            {!! Form::label('PreviousProblems','Previous Problems:') !!}
                                            <a href="javascript:void(0)" class="btn btn-success btn-view" id="add_prev_problem"><i class="fa fa-plus"></i></a>
                                            <input type="hidden" name="PreviousProblems" id="hidden_prev_problem" value="{{ $results->PreviousProblems }}">
                                            <div class="water-mark">Add Previous Problem</div>
                                            <ul class="connected-sortable droppable-area2">
                                                @if(isset($results->PreviousProblems) && !empty($results->PreviousProblems))
                                                <?php 
                                                $prev_problem = explode('||', $results->PreviousProblems);
                                                if (count($prev_problem) != 0) {
                                                    foreach ($prev_problem as $prob_key => $prev_prob_value) {

                                                        echo '<li class="draggable-item">'.$prev_prob_value.'<a class="btn btn-default btn-view"><i class="fas fa-arrows-alt"></i></a><a class="btn btn-info btn-view edit_problem"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-view remove_problems"><i class="fa fa-trash"></i></a></li>';
                                                    }
                                                }
                                                ?>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>                                               
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Central Form -->
                <!-- <div role="tabpanel" class="tab-pane @if($_COOKIE['postnataldaycare'] == 'otherform') active @endif" id="otherform"> -->
                <div role="tabpanel" class="tab-pane" id="otherform">
                    <div class="col-md-11 ">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('differentialdiagnosis','Differential Diagnosis:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::Select('differentialdiagnosis[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">  
                        <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('additional_diagnosis','Additional Diagnosis:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <table class="additional_diagnosis table table-add-more full-width-fix">
                                            <thead>                                    
                                                <tr class="master-add-header">
                                                    <th class="full-width">
                                                        <i class="fa fa-reorder"></i>Add More
                                                    </th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view additional_diagnosis_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(is_array($results->additional_diagnosis) && count($results->additional_diagnosis) != 0)
                                                @foreach($results->additional_diagnosis as $key => $diagnosis)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="additional_diagnosis[{{$key}}]" value="{{ $diagnosis }}" class="form-control full-width">
                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove-additional-diagnosis"></span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else 
                                                <tr>
                                                    <td>
                                                        <input type="text" name="additional_diagnosis[]" value="" class="form-control full-width">
                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove-additional-diagnosis"></span>
                                                    </td>
                                                </tr>    
                                                @endif 
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label>Birth Weight (grams):</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input class="form-control valid" type="text" id="birth_weight" value="{{ @$results->BirthWeight }}" readonly />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="PreviousWt">Previous Weight (grams):</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input class="form-control valid" name="PreviousWt" type="text" value="{{ $results->PreviousWt }}" id="PreviousWt">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="CurrentWt">Current Weight (grams):</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input class="form-control valid" name="CurrentWt" type="text" value="{{ $results->CurrentWt }}" id="CurrentWt">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="WtChange">Weight Change from Birth (grams):</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input class="form-control valid" name="WtChangeBirth" type="text" value="{{ $results->WtChangeBirth }}" id="WtChangeFromBirth">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="WtChange">Weight Change from Previous (grams):</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input class="form-control valid" name="WtChange" type="text" value="{{ $results->WtChange }}" id="WtChange">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="hb">HB :</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input class="form-control" name="hb" type="text" value="{{ $results->hb }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('examination_normal','Rest of the examination is normal ?:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="examination_normal" name="examination_normal" <?php echo ($results->examination_normal == true) ?  'checked' : '' ; ?>  data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('AnteriorFontanelle','Anterior Fontanelle:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('AnteriorFontanelle',[''=>'N/A','Normal' => "Normal","Depressed"=>"Depressed","Bulging"=>"Bulging"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AnteriorFontanelle',3)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Activity','Activity:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Activity',[''=>'N/A',"Normal" => "Normal","Comatosed"=>"Comatosed","Decreased"=>"Decreased","Increased"=>"Increased","Irritable"=>"Irritable"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('Cephalhematoma','Cephalhematoma') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cephalhematoma',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Cephalhematoma',3)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('Color','Color:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Color',['Pink'=>'Pink','Yellow'=>'Yellow','Blue'=>'Blue','Pale'=>'Pale'],null,['class'=>'form-control','id'=>'Colour','data-color'=>ValuelistHelpers::setColorvalue('colour',3)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('EyeInfection','Eye Infection:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('EyeInfection',[''=>'N/A',"Yes"=>"Yes",'No' => "No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default',3)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('RespiratoryDistress','Respiratory Distress:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('RespiratoryDistress',[''=>'N/A',"Yes"=>"Yes",'No' => "No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default',3)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('CardiacMurmur','Cardiac Murmur:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('CardiacMurmur',[''=>'N/A',"Yes"=>"Yes",'No' => "No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default',3)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('Femorals','Femorals:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Femorals',[''=>'N/A',"Normal"=>"Normal",'Abnormal' => "Abnormal"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('normal',3)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('UmbilicalInfection','Umbilical Infection:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('UmbilicalInfection',[''=>'N/A',"Yes"=>"Yes",'No' => "No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default',3)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('Genitalia','Genitalia:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Genitalia',[''=>'N/A',"Normal"=>"Normal",'Abnormal' => "Abnormal"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('normal',3)]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6"> 
                        <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control md-mt-50">
                                {!! Form::label('NeonatalJaundice','Neonatal Jaundice:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('NeonatalJaundice',[''=>'N/A',"Yes"=>"Yes",'No' => "No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default',3)]) !!}
                            </div>
                        </div>    
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control md-mt-50">
                                {!! Form::label('Hips','Hips:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('Hips',[''=>'N/A',"Normal"=>"Normal",'Abnormal' => "Abnormal"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('normal',3)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control md-mt-50">
                                {!! Form::label('PassedUrine','Passed Urine:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('PassedUrine',[''=>'N/A',"Yes"=>"Yes",'No' => "No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('normal',3)]) !!}
                            </div>
                        </div>    
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control md-mt-50">
                                {!! Form::label('BowelsOpen','Bowels Open:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('BowelsOpen',[''=>'N/A',"Yes"=>"Yes",'No' => "No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('normal',3)]) !!}
                            </div>
                        </div>   
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('TCB','TcB mg/dl:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('TCB',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('TSB','TSB mg/dl:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('TSB',null,['class'=>'form-control']) !!}
                            </div>
                        </div>    
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control md-mt-50">
                                {!! Form::label('Phototherapy','Phototherapy:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('Phototherapy',[''=>'N/A',"Yes"=>"Yes",'No' => "No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default',3)]) !!}
                            </div>
                        </div> 
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control md-mt-50">
                                {!! Form::label('OtherFindings','Other Findings:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::textarea('OtherFindings',null,['class'=>'form-control','rows'=>6]) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('postnatal_sepsis','Sepsis:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('postnatal_sepsis',[''=>'N/A', 'No sepsis'=>'No sepsis', 'Suspect'=>'Suspect','Probable'=>'Probable', 'Proven'=>'Proven', 'Severe'=>'Severe'],null,['class'=>'form-control']) !!} 
                            </div>
                        </div>
                        <div class="hidden">
                         {!! Form::select('temp_antibiotic',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>'']) !!}
                     </div>
                     <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <table class="antibiotic table table-add-more full-width-fix">
                                <thead>
                                    <tr class="master-add-header">
                                        <th>
                                            {!! Form::label('postnatal_antiboitic','Antibiotic') !!}
                                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="temp_antibiotic,postnatal_antiboitic[]" data-option_value="id" data-option_text="generic_pharmacological_name" data-mas_table="mas_drugivfluid" data-drug_type="antibiotic">
                                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                            </a>
                                        </th>
                                        <th>
                                            {!! Form::label('postnatal_antiboitic_day','Day') !!}
                                        </th>
                                        <th>
                                            <span>
                                                <a class="btn btn-success btn-view post_antibiotic_add btn_add" href="javascript:void(0);">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($results->postnatal_antiboitic) && !is_null($results->postnatal_antiboitic) && count(json_decode($results->postnatal_antiboitic)) > 0)
                                    @php $i = 0; @endphp
                                    @foreach (json_decode($results->postnatal_antiboitic) as $key => $data)
                                    <tr>
                                        <td class="full-width">
                                            {!! Form::select('postnatal_antiboitic['.$key.']',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),$data->postnatal_antiboitic,['class'=>"full-width postnatal_antiboitic", 'id'=>"antibiotic-sepsis-".$i]) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('postnatal_antiboitic_day['.$key.']',$data->postnatal_antiboitic_day,['class'=>'form-control input-width-mini']) !!}
                                        </td>
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="full-width">
                                            {!! Form::select('postnatal_antiboitic[]',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>"full-width postnatal_antiboitic",'id'=>'antibiotic-sepsis-0']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('postnatal_antiboitic_day[]',null,['class'=>'form-control input-width-mini']) !!}
                                        </td>
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('postnatal_other_drugs','Drugs:') !!}
                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="a_nonantibiotic_temp,postnatal_other_drugs[]" data-option_value="id" data-option_text="generic_pharmacological_name" data-mas_table="mas_drugivfluid">
                                            <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                        </a>
                        </div>
                                    <div class="hidden">
                                     {!! Form::select('a_nonantibiotic_temp',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsNonAntibiotic(),'',['class'=>"input-width-medium  form-control"]) !!}
                                 </div>
                        <div class="col-md-9 custom-input">
                            <table class="sep_drugs table table-add-more full-width-fix">
                                <thead>                                    
                                    <tr class="master-add-header">
                                        <th class="full-width">
                                            <i class="fa fa-reorder"></i>Add More
                                        </th>
                                        <th>
                                            <span>
                                                <a class="btn btn-success btn-view post_sep_drugs_add btn_add" href="javascript:void(0);">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($results->postnatal_other_drugs) && !is_null($results->postnatal_other_drugs) && count(json_decode($results->postnatal_other_drugs)) > 0)
                                    @foreach (json_decode($results->postnatal_other_drugs) as $key => $postnatal_drugs)
                                    @if (preg_match('/[a-zA-Z]/', $postnatal_drugs))
                                    <tr>
                                        <td class="full-width">
                                            {!! Form::text('postnatal_other_drugs['.$key.']',$postnatal_drugs,['class'=>'form-control full-width sepsis-non-antibiotic']) !!}
                                        </td>
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td class="full-width">{!! Form::select('postnatal_other_drugs['.$key.']',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsNonAntibiotic(),$postnatal_drugs,['class'=>"form-control sepsis-non-antibiotic"]) !!}</td>
                                        <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="full-width">
                                        </td>{!! Form::select('postnatal_other_drugs[]',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsNonAntibiotic(),$postnatal_drugs,['class'=>"form-control sepsis-non-antibiotic"]) !!}
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('blood_culture','Blood Culture:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('blood_culture',[''=>'N/A','Not sent' => "Not sent","Awaited"=>"Awaited","Negative"=>"Negative","Positive"=>"Positive"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BloodCulture')]) !!}
                        </div>   
                    </div> 
                    <div class="hidden">
                        {!! Form::select('temp_organism',ValuelistHelpers::organizam(),null,['class'=>'form-control']) !!}
                    </div>                            
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Organism','Organism:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <table class="postnatal-organizam table table-add-more full-width-fix">
                                <thead>                                    
                                    <tr class="master-add-header">
                                        <th class="full-width">
                                            <i class="fa fa-reorder"></i>Add More
                                        </th>
                                        <th>
                                            <span>
                                                <a class="btn btn-success btn-view postnatal_organizam_add btn_add" href="javascript:void(0);">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($results->postnatal_organism) && count(json_decode($results->postnatal_organism)))
                                    @foreach(json_decode($results->postnatal_organism) as $key => $organizam)
                                    <tr>
                                        <td class="full-width">
                                            {!! Form::select('postnatal_organism['.$key.']',ValuelistHelpers::organizam(),$organizam,['class'=>'form-control full-width']) !!}
                                        </td>
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="full-width">
                                            {!! Form::select('postnatal_organism[]',ValuelistHelpers::organizam(),null,['class'=>'form-control full-width']) !!}
                                        </td>
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table> 
                        </div>
                    </div>                     
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notes Form -->
            <!-- <div role="tabpanel" class="tab-pane @if($_COOKIE['postnataldaycare'] == 'planform') active @endif" id="planform"> -->
            <div role="tabpanel" class="tab-pane" id="planform">
                <div class="col-md-8 col-md-offset-1">
                    <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Notes','Notes:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('Notes',null,['class'=>'form-control','rows'=>6]) !!}
                                </div>
                            </div>    
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Plan','PLAN:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('Plan',null,['class'=>'form-control','rows'=>6]) !!}
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-11 col-sm-12">
                <input type="hidden" name="print_flag" value="0" id="print_flag" />
                @if(!Session::has('registration_start'))
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block btn-info save-next save-button-shadow form-control">
                        <i class="fa fa-floppy-o"></i>
                        <span>@if($_COOKIE['postnataldaycare'] != 'planform') Update & Next @else Finish @endif</span>
                    </button>
                </div> 
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block save-button-shadow btn-primary form-control post-daycare-save-btn" data-flag="0"><i class="fa fa-floppy-o"></i> <span>{!! $SubmitButtonText !!}</span></button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block btn-primary save-button-shadow form-control post-daycare-save-btn"  onclick="$('#print_flag').val('1'); $(form).submit();"><i class="fa fa-print"></i> <span>{!! $printButtontext !!}</span></button>
                </div>  
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ action('Admission\PostnatalDaycareController@index') }}" class="btn btn-block btn-default save-button-shadow form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>{!! $cancelButton !!}</span></a>
                </div>
                @else 
                <div class="col-md-3 col-sm-4 set-column col-xs-12">
                    <button type="button" class="btn btn-block btn-info save-next save-button-shadow form-control">
                        <i class="fa fa-floppy-o"></i>
                        <span>@if($_COOKIE['postnataldaycare'] != 'planform') Next @else Finish @endif</span>
                    </button>
                </div>
                <div class=" @if($_COOKIE['postnataldaycare'] == 'planform') col-md-3 col-sm-4 col-xs-12  @else hide @endif print-tag">
                    <button type="button"  onclick="$('#print_flag').val('1'); $(form).submit();" class="btn btn-block btn-info  save-button-shadow form-control">
                        <i class="fa fa-print"></i>                              
                        <span> Print</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-4 set-column col-xs-12">
                    <a href="{{ action('Admission\PostnatalDaycareController@index') }}" class="btn btn-default btn-block save-button-shadow form-control" onclick="$('form')[0].reset();">
                        <i class="fa fa-exclamation-circle"></i> 
                        <span>Cancel</span>
                    </a>
                </div>
                @endif
            </div>    
        </div>
    </div>
    {!! Form::close() !!}
</div>
</div>                                      

@endsection
@section('scripts')
<script type="text/javascript">
    /* PLUGIN USED FOR FORM LOCAL STORAGE */
    $("form").sisyphus({customKeySuffix: "postnatal_day", locationBased: true});

    $('.postnatal_antiboitic').each(function() {

       var id = $('#'+$(this).attr('id')).select2({
        allowClear: true,
        dropdownAutoWidth : false,
        width: 'resolve' 
    }); 

   });

    @if(!Session::has('registration_start'))

    $('.nav-tabs li a').click(function() {
        if ($("#postnatal_daycare_form").valid() === false) {
          $("#postnatal_daycare_form").valid();
            return false;
        }
        submitForm();
        // $.cookie('postnataldaycare', $(this).attr('href').replace('#',''));
    });

    @else
    $('.nav-tabs li a').click(function() {
        if ($("#postnatal_daycare_form").valid() === false) {
          $("#postnatal_daycare_form").valid();
            return false;
        }
       setactiveMenu($(this).attr('href').replace('#',''));
       setFinish($(this).attr('href').replace('#',''));
       setprintOption($(this).attr('href').replace('#',''));
   }); 

    function setactiveMenu(menu) {
        // $.cookie('postnataldaycare', menu);
    }


  function setprintOption(menu) {

    if (menu == 'planform') {
     $('.print-tag').addClass('col-md-3').removeClass('hide');
     $('.set-column').removeClass('col-md-6').addClass('col-md-3')
 } else {
     $('.print-tag').removeClass('col-md-3').addClass('hide');
     $('.set-column').removeClass('col-md-3').addClass('col-md-6');
 }

}  


@endif

    function setFinish(daycareId) {
        if (daycareId =='planform') {
          $('.save-next span').text('Finish');
          $('input[name="print_flag"]').val(4);
      } else {
          $('.save-next span').text('Next');
          $('input[name="print_flag"]').val(0);
      }
  }
$('.save-next').click(function() {
    var currentMenu = $('.tabbable li[class="active"]').children('a').attr('href').replace('#','');
    if (currentMenu != 'planform') {
        var daycareId = $('.tabbable li[class="active"]').next('li').children('a').attr('href').replace('#','');
        // setactiveMenu(daycareId);
    } else {
        setFinish(currentMenu);
        $('#postnatal_daycare_form').submit();
    }
        var current_clicked_element = $(this);
    submitForm(current_clicked_element);
});

@if(isset($already_filled_days) && !empty($already_filled_days))

var exclude = [<?php echo '"'.implode('","',  $already_filled_days ).'"' ?>];

@else

var exclude = [];
@endif
function unavailable(date) {
    var tempoMonth = (date.getMonth()+1);
    var tempoDate = (date.getDate());
    if (tempoMonth < 10) tempoMonth = '0' + tempoMonth;
    if (tempoDate < 10) tempoDate = '0' + tempoDate;
    var dmy = date.getFullYear() + '-' + tempoMonth + '-' + tempoDate;
    if ($.inArray(dmy, exclude) == -1) {
        return [true, ""];
    } else {
        return [false, "", "Unavailable"];
    }
}


$('.daycare-date').datepicker({
    beforeShowDay: unavailable,
    dateFormat: 'dd-mm-yy',
    yearRange: "-01:+00",
    changeMonth : true,
    changeYear : true,  
    maxDate:'+0M',
    minDate:'-12M'
});
$(document).on('click', '.post-daycare-save-btn', function(e){
        e.preventDefault();
        var current_clicked_element = $(this);
    submitForm(current_clicked_element);
});
function submitForm(current_clicked_element = false)
{
    if ($('#postnatal_daycare_form').valid() === true) {
        var print_flag = $(this).data('flag');
        $('#print_flag').val(print_flag);

        $('.post-daycare-save-btn').prop('disabled', true);
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#postnatal_daycare_form input, #postnatal_daycare_form select, #postnatal_daycare_form textarea').serialize(),
            url: "{{ action('Admission\PostnatalDaycareController@update', $results->PDayId) }}",
            success: function (response) {
                if (print_flag == 1) {
                    Showalert('success', 'Postnatal daycare details updated successfully');
                    window.location.href = response.print_url;
                }
                else if(print_flag == 2)
                {
                    Showalert('success', 'Postnatal daycare details updated successfully');
                    window.location.href = response.list_url;
                }
                else
                {

                    if (current_clicked_element != false) {
                        Showalert('success', 'Postnatal daycare details updated successfully');
                    }

                    $('.post-daycare-save-btn').prop('disabled', false);

                    if (current_clicked_element != false && current_clicked_element.hasClass('save-next')) {

                        // current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update</span>');
                        var next_tab = $('.nav-tabs > .active').next('li').find('a');
                        if(next_tab.length>0){
                            if (next_tab.attr('href') == '#planform') {
                                current_clicked_element.find('span').html('Finish');
                            }
                            next_tab.trigger('click');
                        }

                    }
                }
            },
            error: function()
            {
                Showalert('error', 'Something went wrong, Please try again later...!');
            }
        });
    }
} 


$( drag_init );

function drag_init() {
  $( ".droppable-area1, .droppable-area2" ).sortable({
      connectWith: ".connected-sortable",
      stack: '.connected-sortable ul',
      update: function( event, ui ) {
        update_problems();            
    },
});
  $( ".droppable-area1, .droppable-area2" ).disableSelection();
} 
function update_problems()
{
    // var cur_problems = [];
    var cur_problems = $('.droppable-area1').find('li').filter(function() {
        return $(this).find('ul').length === 0;
    }).map(function(i, e) {
        return $(this).text().replace('\n', '');
    }).get().join('||');
    $('#hidden_current_problem').val(cur_problems);

    var prev_problems = $('.droppable-area2').find('li').filter(function() {
        return $(this).find('ul').length === 0;
    }).map(function(i, e) {
        return $(this).text().replace('\n', '');
    }).get().join('||');
    $('#hidden_prev_problem').val(prev_problems);


}

$("#add_cur_problem").click(function() {
    var cur_prob = prompt("Enter Current Problem:");
    if (cur_prob) {
        var $delete_cur_prob = $("<a />", {"class": "btn btn-danger btn-view remove_problems"})
        .html("<i class='fa fa-trash'>")
        .click(deleteHandler);
        var $drag_cur_prob = $("<a />", {"class": "btn btn-default btn-view"}).html("<i class='fas fa-arrows-alt'></i>");

        var $edit_cur_prob = $("<a />", {"class": "btn btn-info btn-view edit_problem"}).html("<i class='fa fa-edit'></i>");


        $("<li />", {"class": "draggable-item"})
        .text(cur_prob)
        .append($delete_cur_prob)
        .append($edit_cur_prob)
        .append($drag_cur_prob)
        .appendTo(".droppable-area1");
    }
    
    update_problems();            
    return false;
});
$("#add_prev_problem").click(function() {
    var cur_prob = prompt("Enter Previous Problem:");
    if (cur_prob) {
        var $delete_cur_prob = $("<a />", {"class": "btn btn-danger btn-view remove_problems"})
        .html("<i class='fa fa-trash'>")
        .click(deleteHandler);
        var $drag_cur_prob = $("<a />", {"class": "btn btn-default btn-view"}).html("<i class='fas fa-arrows-alt'></i>");
        
        var $edit_cur_prob = $("<a />", {"class": "btn btn-info btn-view edit_problem"}).html("<i class='fa fa-edit'></i>");

        $("<li />", {"class": "draggable-item"})
        .text(cur_prob)
        .append($delete_cur_prob)
        .append($edit_cur_prob)
        .append($drag_cur_prob)
        .appendTo(".droppable-area2");
    }
    
    update_problems();            
    return false;
});
function deleteHandler() {

}
$(document).on('click', '.remove_problems', function()
{
    var element = $(this);
    var yes =  confirm("Are you confirm to delete this problem ?");
    if(yes)
    {
        element.parent().remove();
        update_problems();            
    }
});

$(document).on('click', '.edit_problem', function()
{
    var element = $(this).parent().text();

    var cur_prob = prompt("Enter Previous Problem:", element);

    if (cur_prob) {
        var prob = $(this).parent().html();
        prob = prob.replace(element, cur_prob);
        $(this).parent().html(prob);
            update_problems();            
    }
});
var input  = $('[name="PreviousWt"], [name="CurrentWt"]'),
input1 = $('[name="PreviousWt"]'),
input2 = $('[name="CurrentWt"]'),
input3 = $('[name="WtChange"]'),
input5 = $('#birth_weight'),
input6 = $('[name="WtChangeBirth"]');
input.change(function () {
    input6.val('');
    input3.val('');
    if(input2.val().trim() != '' && input1.val().trim()!=''){ 
        var WeightChange = parseInt(input2.val())-parseInt(input1.val());
        input3.val(WeightChange);
    }

    if(input2.val().trim() != '' && input5.val().trim()!=''){ 
        var WeightChange = parseInt(input2.val())-parseInt(input5.val());
        input6.val(WeightChange);
    }    
});
</script>
@include('postnatal_daycare.postnatal_daycare_scripts')

@endsection
