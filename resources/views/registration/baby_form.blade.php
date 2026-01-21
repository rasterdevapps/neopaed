<?php 
$site_url = url('/').'/public';
$write_permission = session('write_permission');
?>
<!-- <div class="row">
    <div class="col-md-12 plr-0">
        <div class="@if($sitesetting->mirthIntegration == 2 &&  Request::segment(3) != 'edit') col-md-6 col-md-offset-2 col-xs-8  @else col-md-12 @endif">
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('BMrNo','Baby\'s MRN:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    @if (isset($setting->OverwriteBabyMR) && $setting->OverwriteBabyMR === 1)
                    {!! Form::text('BMrNo',$bmrno,['class'=>'form-control input-fields-shadow']) !!}
                    @else
                    {!! Form::text('BMrNo',$bmrno,['class'=>'form-control input-fields-shadow']) !!}
                    @endif
                    <span id="mr_no_error" class="error-message display-none"></span>
                </div>
            </div>
        </div>
        @if($sitesetting->mirthIntegration == 2 &&  Request::segment(3)!='edit')
        <div class="col-md-3 col-xs-4">
            <div class="form-group search-bmrno-button">
                <button class="btn btn-primary btn-basic-shadow" id="search-baby-by-mr">
                <i class="fa fa-search"></i> <span>Search</span>
                </button>
            </div>
        </div>
        @endif    
    </div>
</div> -->
<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> Baby Details</h4>
            </div>
            <div class="widget-content row mx-0" id="baby-category">                
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-3 col-md-2 text-right label-control">
                            {!! Form::label('BMrNo','Baby\'s '. Lang::get('home.mrn').':', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 col-sm-12 custom-input">
                            <div class="col-md-7 col-sm-8">
                                {!! Form::text('BMrNo',$bmrno,['class'=>'form-control input-fields-shadow']) !!}
                                <label id="mrn_no_error" style="display: none; color: red"></label>
                            </div>
                            <div class="col-md-5 col-sm-4">
                                @if(Session::has('registration_start')) 
                                <a class="btn btn-primary btn-basic-shadow" id="search-baby-by-mr" disabled="true">
                                    <i class="fa fa-search"></i> <span>Search</span>
                                </a>
                                @endif
                                <a class="btn btn-warning btn-basic-shadow" id="generate-mrn" data-mrn-field="BMrNo" data-form-id="baby_reg_form" title="{{Lang::get('home.mrn_generate_btn_title')}}">
                                    <img src="{{$site_url}}/img/saraswathi_logo.png"> <span>{{Lang::get('home.mrn_generate_btn')}}</span>
                                </a>
                                <br>
                                <label id="search_mrn_no_error" style="display: none; color: red"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('BabyName','Baby Name:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <div class="display-flex">
                                                @php 
                                                $default_name = \Config::get('constants.HIS_QUICK_REG_BABY_NAME');
                                                $default_name = strtolower($default_name);
                                                @endphp
                                                {!! Form::text('BabyName',$babyname,['class'=>'form-control']) !!}
                                                @if (str_contains(strtolower($babyname), $default_name))
                                                {!! Form::hidden('old_baby_name', $babyname) !!}
                                                {!! Form::hidden('hms_call') !!}
                                                <span class="text-danger call-hms-2 pl-15 pt-5" title="Get data from HMS"><i class="fa fa-refresh"></i></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('DOB','DOB:', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('DOB',null,['class'=>'form-control baby-dob', 'readonly'=>'true']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                            {!! Form::label('TOB','Time Of Birth:') !!}
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
                                                    {!! Form::select('TOB_TIME',$tob['time'],null,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('TOB_MINS',$tob['mins'],null,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('TOB_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control ']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('MultiplePregnancy','Multiple Pregnancy:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            @if(isset($multiple_pregnancy_type) && !empty($multiple_pregnancy_type))
                                            {!! Form::select('MultiplePregnancy',['No'=>'No','Yes'=>'Yes'],'Yes',['class'=>'form-control']) !!}
                                            @else
                                            {!! Form::select('MultiplePregnancy',['No'=>'No','Yes'=>'Yes'],$multiple_pregnancy,['class'=>'form-control']) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row" id="MultiplePregnancyTypeDiv" {!! $displaystyle !!}>  
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('MultiplePregnancyType','Multiple Pregnancy Type:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            @if(isset($multiple_pregnancy_type) && !empty($multiple_pregnancy_type))
                                            {!! Form::select('MultiplePregnancyType',['' => '--Select--']+ValuelistHelpers::getPreganancytype(),$multiple_pregnancy_type,['class'=>'form-control']) !!}
                                            @else
                                            {!! Form::select('MultiplePregnancyType',['' => '--Select--']+ValuelistHelpers::getPreganancytype(),$MultiplePregnancyType,['class'=>'form-control']) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('Noofbabies','No. of babies admitted:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('Noofbabies',$no_of_babies,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('BirthOrder','Birth Order:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            @if(isset($multiple_pregnancy_type) && !empty($multiple_pregnancy_type))
                                            @php  $multiple_pregnancy_type = (isset($multiple_pregnancy_type) && $multiple_pregnancy_type != '') ? $multiple_pregnancy_type : @$results->multiple_pregnancy_type;  @endphp
                                            {!! Form::select('BirthOrder',[''=>'--Select--']+ValuelistHelpers::mptypeNobabies($multiple_pregnancy_type),null,['class'=>'form-control', 'id' => 'birth_order_select']) !!}
                                            @else
                                            @php  $MultiplePregnancyType = (isset($MultiplePregnancyType) && $MultiplePregnancyType != '') ? $MultiplePregnancyType : @$results->MultiplePregnancyType;  @endphp
                                            {!! Form::select('BirthOrder',[''=>'--Select--']+ValuelistHelpers::mptypeNobabies($MultiplePregnancyType),null,['class'=>'form-control']) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <label id="BirthOrder-error" class="error display-none"></label>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Sex','Sex:', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                            {!! Form::label('Gestation','Gestation:', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input clear-xs">
                                            <div class="row col-md-12 display-flex">
                                                <div>
                                                    <small>(In Weeks)</small>
                                                    {!! Form::text('g_weeks',null,['class'=>'form-control']) !!}
                                                    <label class="error help-block" for="g_weeks" generated="true"></label> 
                                                </div>
                                                <div class="inbeween_two_fields">
                                                    <span>+</span>
                                                </div>
                                                <div>
                                                    <small>(In Days)</small>
                                                    {!! Form::text('g_days',null,['class'=>'form-control']) !!}
                                                    <label class="error help-block" for="g_days" generated="true"></label> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <!-- <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                               {!! Form::label('ip_number', 'Ip  Number') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                               {!! Form::text('ip_number', $ip_number, ['class'=>'form-control']) !!}
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Birth Weight','Birth Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input pl-0">
                            <input id="BirthStatus" data-size="small" name="BirthStatus" data-off="Outborn" data-on="Inborn" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->BirthStatus) && $results->BirthStatus == 'Inborn') checked="checked" @endif>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                            {!! Form::label('BirthWeight','Birth Weight:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 custom-input clear-xs">
                            <div class="row">
                                <div class="col-xs-6">
                                    <small>(In Grams)</small>
                                </div>
                                <div class="col-xs-6">
                                    <small>(In Kilo Grams)</small>
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::input('text','BirthWeight',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::input('text','birth_weight',$results['BirthWeight']/1000,['class'=>'form-control','readonly'=>'true', 'id' => 'birth_weight']) !!}
                                </div>
                            </div>
                            <label class="error help-block" for="BirthWeight" generated="true"></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control mt-0">
                            {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('BabyBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="hidden">
                        {!! Form::select('neonatal_consultant_temp',ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 col-sm-3 text-right label-control">
                            {!! Form::label('neonatal_consultant','Neonatal Consultant:', ['class'=>'required-label']) !!}
                            <!-- <a href="{{ action('Masters\DoctorController@index') }}"><i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Neonatal Consultant"></i></a> -->
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Neonatal Consultant" data-destination_elements="neonatal_consultant_temp,neonatal_consultant[],paediatric_surgeon" data-option_value="id" data-option_text="Name,Qualification" data-mas_table="mas_doctors">
                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Neonatal Consultant"></i>
                            </a>
                        </div>
                        <div class="col-md-9 custom-input">
                            <table class="neonatal-consultant-div table table-add-more full-width-fix">
                                <thead>                                    
                                    <tr class="master-add-header">
                                        <th class="full-width">
                                            <i class="fa fa-reorder"></i>Add More
                                        </th>
                                        <th>
                                            <span>
                                                <a class="btn btn-success btn-view neon_add btn_add" href="javascript:void(0);">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($results->neonatal_consultant) && !empty($results->neonatal_consultant) && count($results->neonatal_consultant) > 0)
                                    @foreach($results->neonatal_consultant as $key => $consultant)
                                    <tr>
                                        <td class="full-width">
                                            {!! Form::select('neonatal_consultant['.$key.']',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),$consultant,['class'=>'form-control full-width']) !!}
                                        </td>     
                                        @if ($key > 0)                                             
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove-neon"></span>
                                        </td>
                                        @else
                                        <td></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @else 
                                    <!-- <tr>
                                        <td class="full-width">
                                            {!! Form::select('neonatal_consultant[]',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control full-width']) !!}
                                        </td>                                                  
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove-neon"></span>
                                        </td>
                                    </tr> -->
                                    @php
                                    $res_neonatal_consultant = 'a:4:{i:0;s:1:"8";i:1;s:1:"7";i:2;s:2:"33";i:3;s:3:"100";}';
                                    $neonatal_consultant = unserialize($res_neonatal_consultant);
                                    @endphp
                                    @foreach($neonatal_consultant as $key => $consultant)
                                    <tr data-consultant-id={{$consultant}}>
                                        <td class="full-width">
                                            {!! Form::select('neonatal_consultant[]',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),$consultant,['class'=>'form-control full-width']) !!}
                                        </td>     
                                        @if ($key > 0)                                             
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove-neon"></span>
                                        </td>
                                        @else
                                        <td></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 col-sm-3 text-right label-control mt-0">
                            {!! Form::label('obstetric_consultant','Referring Doctor:') !!}
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Referred Doctor" data-destination_elements="obstetric_consultant" data-option_value="id" data-option_text="doctor_name,hospital_name" data-mas_table="mas_referral">
                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Referred Doctor"></i>
                            </a>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('obstetric_consultant',[''=>'N/A']+ValuelistHelpers::mas_referral_list(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 col-sm-3 text-right label-control mt-0">
                            {!! Form::label('paediatric_surgeon','Paediatric Surgeon:') !!}
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Paediatric Surgeon" data-destination_elements="neonatal_consultant_temp,neonatal_consultant[],paediatric_surgeon" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Paediatric Surgeon"></i>
                            </a>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('paediatric_surgeon',[''=>'N/A']+ValuelistHelpers::get_surgeons_lists(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="print_flag" id="baby_form_print_flag" value="">
        @if(isset($previousNeonatal[0]->NeonatalId) && !empty($previousNeonatal[0]->NeonatalId))
        <input type="hidden" name="neonatal_proforma_id" value="{{ $previousNeonatal[0]->NeonatalId }}" />
        @endif
        @if(isset($flow_wise_register) && !empty($flow_wise_register) && $flow_wise_register == 'from-dashboard')  
        <input type="hidden" name="flow" value="from-dashboard" />
        @endif
        <input type="hidden" name="print_flag" />
        <div class="col-md-12 col-sm-12 col-xs-12 mb-20 baby-reg-form mt-20">
            @if(!isset($flow_wise_register) || empty($flow_wise_register) || $flow_wise_register != 'from-dashboard')  
            @if(!Session::has('registration_start')) 
            <div class="col-md-3 col-xs-12 col-sm-6">
                <button type="button" class="btn btn-primary btn-block save-button-shadow  form-control plr-5 baby_save_btn" data-flag="1">
                    <i class="fa fa-floppy-o"></i> 
                    <span>{!! $SubmitButtonText !!}</span>
                </button>
            </div>
            @if(isset($multiple_pregnancy_type) && !empty($multiple_pregnancy_type) && $pending_babies != 0)
            <div class="col-md-3 col-xs-12 col-sm-6">
                <button type="button" value="savedhere" name="savedhere" class="btn save-button-shadow  btn-success btn-block form-control baby_save_btn" data-flag="2">
                    <i class="fa fa-plus"></i> 
                    <span>Create Siblings</span>
                </button>
            </div>
            @else
            <div class="col-md-3 col-xs-12 col-sm-6">
                <button type="button" value="savedhere" name="savedhere" class="btn save-button-shadow  btn-success btn-block form-control baby_save_btn" data-flag="2">
                    <i class="fa fa-floppy-o"></i> 
                    <span>{!! $SavedhereText !!}</span>
                </button>
            </div>
            @endif  
            @endif  
            @if(in_array('NEONATAL',$write_permission) && isset($previousNeonatal) && count($previousNeonatal) == 0 && Session::get('admission_module') !=  'OP_REGISTARATION')
            <div @if(Session::has('registration_start'))  class="col-md-6 col-xs-12 col-sm-6"  @else class="col-md-3 col-xs-12 col-sm-6" @endif>
                <button type="button" value="createneonate" name="createneonate" class="btn save-button-shadow  btn-info btn-block form-control overflow-ellipsis baby_save_btn" data-flag="3">
                    <i class="fa fa-floppy-o"></i>
                    <span>{!! $neonatalPerforma !!}</span>
                </button>
            </div>
            @elseif(Session::has('registration_start') && !in_array('NEONATAL',$write_permission)) 
            <div   class="col-md-3 col-xs-12 col-sm-6">
                <button type="button" value="createneonate" name="createneonate" class="btn save-button-shadow  btn-info btn-block form-control baby_save_btn" data-flag="4">
                    <i class="fa fa-floppy-o"></i>
                    <span>Finish</span>
                </button>
            </div>
            @endif
            @if(!Session::has('registration_start'))  
            @if(in_array('OP_REG',$write_permission) && Session::get('admission_module') ==  'OP_REGISTARATION')
            <div class="col-md-3 col-xs-12 col-sm-6">
                <button type="button" value="createop" name="createop" class="btn save-button-shadow  btn-info btn-block form-control baby_save_btn" data-flag="5">
                    <i class="fa fa-floppy-o"></i>
                    <span>{!! $opRegister !!}</span>
                </button>
            </div>
            @endif
            @endif
            @else
            <div class="col-md-3 col-xs-12 col-sm-6">
                <button type="button" value="savedhere" name="savedhere" class="btn save-button-shadow btn-success btn-block form-control baby_save_btn" data-flag="2">
                    <i class="fa fa-floppy-o"></i> 
                    <span>{!! $SavedhereText !!}</span>
                </button>
            </div>

            <div  class="col-md-4 col-xs-6 col-sm-6">
                <button type="button" value="createneonate" name="createneonate" class="btn save-button-shadow  btn-info btn-block form-control overflow-ellipsis baby_save_btn" data-flag="3">
                    <i class="fa fa-floppy-o"></i>
                    @if(isset($previousNeonatal) && count($previousNeonatal) == 0)
                    <span>Create Neonatal Proforma</span>
                    @else
                    <span>Edit Neonatal Proforma</span>
                    @endif
                </button>
            </div>

            @endif  
            <div @if(Session::has('registration_start'))  class="col-md-6 col-xs-12 col-sm-6" @else class="col-md-3 col-sm-6 col-xs-12 text-center" @endif>
                <a href="{{ action('Registration\BabyController@index') }}" class="btn save-button-shadow btn-default btn-block form-control cancel-btn-opt" onclick="$('form')[0].reset();">
                    <i class="fa fa-exclamation-circle"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@section('scripts')
<script type="text/javascript">
    $('.ward-name, .room-name').change(function() {

     var uri  = "{{ url('baby-bed-details') }}";
     var id   = $(this).val();
     var name = $(this).attr('name');
     getBedList(uri, id, name);

 });
    
    function getBedList(uri, id, name) {

      var slug;
      var destinationName;
      
      if (name == 'ward_name') {

       slug            = 'ROOMLIST';
       destinationName = 'room_no';

   } else if(name =='room_no') {

       slug = 'BEDLIST';
       destinationName = 'bed_no';

   }


   $.ajax({
      type    :"GET",
      url     :uri+'/'+id+'/'+slug,
      success : function(response) {

        var wardOption = '<option value="">N/A</option>';
        $.each(response.results, function(index, value) {
          wardOption += '<option value="'+value.id+'">'+value.name+'</option>';
      });

        $('select[name="'+destinationName+'"]').html(wardOption);
    },
    complete: function(response) {

    }
});

}  

@if(Request::segment(3) =='edit')
$('#BirthOrder').val('{{ $results->BirthOrder}}');
@endif

jQuery('#BirthWeight').keyup(function () {
    this.value = this.value.replace(/[^0-9]/g,'');
    
    $( "#birth_weight" ).empty();
    var birth_weight = $( '#BirthWeight' ).val()/1000;
    $( '#birth_weight').val(birth_weight );
});
jQuery('#Gestation').keyup(function () {
    this.value = this.value.replace(/[^0-9.+]/g,'');
});

@if(isset($multiple_pregnancy_type) && !empty($multiple_pregnancy_type))
@if(isset($disabled_birthorder) && !empty($disabled_birthorder))
@foreach($disabled_birthorder as $order_key => $order_val)
@if(!empty($order_val))
$('#birth_order_select option[value="{{$order_val}}"]').prop('disabled', true);
@else
@php
$order_value = trim(substr($order_key, strpos($order_key, "-") + 1));  
@endphp
$('#birth_order_select option[value="{{$order_value}}"]').prop('disabled', true);
@endif
@endforeach
@endif
@endif
@if(isset($results->MultiplePregnancyType) && $results->MultiplePregnancyType != 'Singleton')
// $('select[name=BirthOrder]').prop('disabled', true);
// $('select[name=MultiplePregnancy]').prop('disabled', true);
// $('select[name=MultiplePregnancyType]').prop('disabled', true);
$('select[name=MultiplePregnancy]').addClass('custom-disabled').attr('tabindex', -1);
$('select[name=MultiplePregnancy]').parent().addClass('cursor-not-allowed');
$('select[name=MultiplePregnancyType]').addClass('custom-disabled').attr('tabindex', -1);
$('select[name=MultiplePregnancyType]').parent().addClass('cursor-not-allowed');
@endif


</script>
@endsection
