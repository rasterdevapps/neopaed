
<style type="text/css">
  .form-group.search-button {
    margin-top: 23px;
    margin-left: -27px;
}
.error-message{
    color:red;
}
</style>
<?php $site_url = url('/').'/public';$write_permission = session('write_permission'); ?>
@php $bmrno = isset($_COOKIE["babyMrn"]) ? $_COOKIE["babyMrn"] : ''; @endphp
@if(isset($ipNumber) && !empty($ipNumber))
@php $baby_ip = $ipNumber; @endphp
@elseif(isset($_COOKIE["babyIpNumber"]))
@php $baby_ip = $_COOKIE["babyIpNumber"]; @endphp
@else
@php $baby_ip = 'IP/'; @endphp
@endif
<!-- <div class="row">
    <div class="@if($sitesetting->mirthIntegration == 2 &&  Request::segment(3) != 'edit') col-md-9 col-xs-8 @else col-md-12 @endif">
        <div class="form-group">
            {!! Form::label('BMrNo','Baby\'s MRN.:') !!}
            @if (isset($setting->OverwriteBabyMR) && $setting->OverwriteBabyMR === 1)
            {!! Form::text('BMrNo',$bmrno,['class'=>'form-control input-fields-shadow','maxlength'=>6]) !!}
            @else
            {!! Form::text('BMrNo',$bmrno,['class'=>'form-control input-fields-shadow','maxlength'=>6]) !!}
            @endif
            <span id="mr_no_error" class="error-message display-none"></span>
        </div>
    </div>
    @if($sitesetting->mirthIntegration == 2 &&  Request::segment(3)!='edit')
    <div class="col-md-3 col-xs-4">
        <div class="form-group search-button">
            <button class="btn btn-primary btn-basic-shadow" id="search-baby-by-mr">
            <i class="fa fa-search"></i> <span>Search</span>
            </button>
        </div>
    </div>
    @endif    
</div> -->
<div class="row">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> Baby Details</h4>
            </div>
            <div class="widget-content row mx-0">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-3 col-md-2 text-right label-control">
                            {!! Form::label('BMrNo','Baby\'s '.Lang::get('home.mrn').'.:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 col-sm-12 custom-input">
                            <div class="col-md-7 col-sm-8">
                                {!! Form::text('BMrNo',$bmrno,['class'=>'form-control input-fields-shadow', 'id'=>'BMrNo']) !!}
                                <label id="mrn_no_error" style="display: none; color: red"></label>
                            </div>
                            <div class="col-md-5 col-sm-4">
                                <a class="btn btn-primary btn-basic-shadow" id="search-baby-by-mr" disabled="true">
                                    <i class="fa fa-search"></i> <span>Search</span>
                                </a>
                                <br>
                                <label id="search_mrn_no_error" style="display: none; color: red"></label>
                            </div>
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
                                        {!! Form::label('admission_date','Admission Date:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('admission_date',null,['class'=>'form-control baby-dob', 'readonly']) !!}
                                    </div>
                                </div>
                                {!! Form::hidden('visit_type', 'IP', ['id'=>'visit_type']) !!}
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('ip_number', Lang::get('home.ip')) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('ip_number', $baby_ip, ['class'=>'form-control','maxlength'=>10]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BabyName','Baby Name:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BabyName',$babyname,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DOB','DOB:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DOB',null,['class'=>'form-control baby-dob', 'readonly']) !!}
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
                                                {!! Form::select('TOB_TIME',$tob['time'],$results['TOB_TIME'],['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('TOB_MINS',$tob['mins'],$results['TOB_MINS'],['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('TOB_AM',$tob['session'],$results['TOB_AM'],['class'=>'form-control ']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('MultiplePregnancy','Multiple Pregnancy:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('MultiplePregnancy',['No'=>'No','Yes'=>'Yes'],$multiple_pregnancy,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row" id="MultiplePregnancyTypeDiv" {!! $displaystyle !!}>
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('MultiplePregnancyType','Multiple Pregnancy Type:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('MultiplePregnancyType',['' => '--Select--']+ValuelistHelpers::getPreganancytype(),$MultiplePregnancyType,['class'=>'form-control']) !!}
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
                                        @php  $MultiplePregnancyType = (isset($MultiplePregnancyType) && $MultiplePregnancyType != '') ? $MultiplePregnancyType : @$results->MultiplePregnancyType;  @endphp
                                        {!! Form::select('BirthOrder',[''=>'--Select--']+ValuelistHelpers::mptypeNobabies($MultiplePregnancyType),null,['class'=>'form-control']) !!}
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
                                    {!! Form::label('BirthStatus','Birth Status:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
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
                                            {!! Form::input('text','BirthWeight',null,['class'=>'form-control', 'id' => 'BirthWeight']) !!}
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
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('neonatal_consultant','Neonatal Consultant:', ['class'=>'required-label']) !!}
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
                                                <td>
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
                                            <tr>
                                                <td>
                                                    {!! Form::select('neonatal_consultant[]',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control full-width']) !!}
                                                </td>
                                            </tr>
                                            @endif 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 col-sm-3 text-right label-control mt-0">
                                    {!! Form::label('obstetric_consultant','Referred Doctor:') !!}
                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Referred Doctor" data-destination_elements="obstetric_consultant" data-option_value="id" data-option_text="doctor_name,hospital_name" data-mas_table="mas_referral">
                                        <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Referred Doctor"></i>
                                    </a>
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select('obstetric_consultant',[''=>'N/A']+ValuelistHelpers::mas_referral_list(),null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('paediatric_surgeon','Paediatric Surgeon:') !!}
                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Paediatric Surgeon" data-destination_elements="neonatal_consultant_temp,neonatal_consultant[],paediatric_surgeon" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                        <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Paediatric Surgeon"></i>
                                    </a>
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select('paediatric_surgeon',[''=>'N/A']+ValuelistHelpers::get_surgeons_lists(),null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('ward_name', 'Ward Name:', ['class'=>'required-label']) !!}
                                </div>
                                <div class="col-md-9 custom-input">

                                    @if(isset($bed_logs->ward_id) && !empty($bed_logs->ward_id))
                                    {!! Form::select('ward_name', [''=>'N/A']+$ward_list, $bed_logs->ward_id, ['class'=>'form-control ward-name', 'readonly']) !!}
                                    @elseif(isset($_COOKIE['add_ward_id']) && !empty($_COOKIE['add_ward_id']))
                                    {!! Form::select('ward_name', [''=>'N/A']+$ward_list, $_COOKIE['add_ward_id'], ['class'=>'form-control ward-name', 'readonly']) !!}
                                    @else
                                    {!! Form::select('ward_name', [''=>'N/A']+$ward_list, null, ['class'=>'form-control ward-name']) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('room_no', 'Room No:', ['class'=>'required-label']) !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    @if(isset($bed_logs->room_id) && !empty($bed_logs->room_id))
                                    @php
                                    $room_number = \SiteHelpers::getWardData('room', $bed_logs->room_id);
                                    @endphp
                                    {!! Form::select('room_no',$room_number , $bed_logs->room_id, ['class'=>'form-control', 'readonly']) !!}
                                    @elseif(isset($_COOKIE['add_room_id']) && !empty($_COOKIE['add_room_id']))
                                    @php
                                        $room_number = \SiteHelpers::getWardData('room', $_COOKIE['add_room_id']);
                                    @endphp
                                    {!! Form::select('room_no',$room_number , $_COOKIE['add_room_id'], ['class'=>'form-control', 'readonly']) !!}
                                    @else
                                    {!! Form::select('room_no',[''=>'N/A']+$room_list ,null, ['class'=>'form-control room-name']) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('bed_no', 'Bed No:', ['class'=>'required-label']) !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    @if(isset($bed_logs->bed_id) && !empty($bed_logs->bed_id))
                                    @php
                                    $bed_number = \SiteHelpers::getWardData('bed', $bed_logs->bed_id);
                                    @endphp
                                    {!! Form::select('bed_no', $bed_number, $bed_logs->bed_id,['class'=>'form-control', 'readonly']) !!}
                                    @elseif(isset($_COOKIE['add_bed_id']) && !empty($_COOKIE['add_bed_id']))
                                    @php
                                        $bed_number = \SiteHelpers::getWardData('bed', $_COOKIE['add_bed_id']);
                                    @endphp
                                    {!! Form::select('bed_no', $bed_number, $_COOKIE['add_bed_id'],['class'=>'form-control', 'readonly']) !!}
                                    @else
                                    {!! Form::select('bed_no',[''=>'N/A']+$bed_list, null,['class'=>'form-control bed-name']) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 mtb-20">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <button type="submit" id="baby-form-data" class="btn btn-primary btn-block  save-button-shadow multiple-baby-admission form-control">
                            <i class="fa fa-floppy-o"></i> 
                            <span>{{ $SubmitButtonText }}</span>
                        </button>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <a href="{{ action('HomeController@index') }}" class="btn save-button-shadow   btn-default btn-block form-control" onclick="$('form')[0].reset();">
                            <i class="fa fa-exclamation-circle"></i>
                            <span>Cancel</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script type="text/javascript">
    @if(isset($_COOKIE['babyCurrentBed']) && !empty($_COOKIE['babyCurrentBed']) && isset($_COOKIE['babyCurrentWard']) && !empty($_COOKIE['babyCurrentWard']) && isset($_COOKIE['babyCurrentRoom']) && !empty($_COOKIE['babyCurrentRoom']))


    $('.ward-name').attr('disabled', 'true');
    $('.room-name').attr('disabled', 'true');
    $('.bed-name').attr('disabled', 'true');

    var url  = "{{ url('baby-bed-details') }}";
    var ward_id = "{{$_COOKIE['babyCurrentWard']}}";
    var room_id = "{{$_COOKIE['babyCurrentRoom']}}";
    var bed_id = "{{$_COOKIE['babyCurrentBed']}}";
    $('.ward-name').val(ward_id).change();
    var ward_input = '<input type="hidden" name="ward_name" value="'+ward_id+'" />';
    $(ward_input).insertAfter('.ward-name');
    $.ajax({
      type    :"GET",
      url     :url+'/'+ward_id+'/ROOMLIST',
      success : function(response) {

        var wardOption = '<option value="">N/A</option>';
        $.each(response.results, function(index, value) {
          if (value.id == room_id) {

            wardOption += '<option value="'+value.id+'" selected="selected">'+value.name+'</option>';
        }
        else{
            wardOption += '<option value="'+value.id+'">'+value.name+'</option>';
        }
    });

        $('.room-name').html(wardOption);
        var room_input = '<input type="hidden" name="room_no" value="'+room_id+'" />';
        $(room_input).insertAfter('.room-name');

    },
    complete: function(response) {

    }
});

    $.ajax({
      type    :"GET",
      url     :url+'/'+room_id+'/BEDLIST/all',
      success : function(response) {

        var wardOption = '<option value="">N/A</option>';
        $.each(response.results, function(index, value) {
          if (value.id == bed_id) {

            wardOption += '<option value="'+value.id+'" selected="selected">'+value.name+'</option>';
        }
        else{
            wardOption += '<option value="'+value.id+'">'+value.name+'</option>';
        }
    });
        var bed_input = '<input type="hidden" name="bed_no" value="'+bed_id+'" />';
        $('.bed-name').html(wardOption);
        $(bed_input).insertAfter('.bed-name');
    },
    complete: function(response) {

    }
});

    @endif


    $('.ward-name, .room-name').change(function() {

      var uri  = "{{ url('baby-bed-details') }}";
      var id   = $(this).val();
      var name = $(this).attr('name');
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



});

    @if(Request::segment(3) =='edit')
    $('#BirthOrder').val('{{ $results->BirthOrder}}');
    @endif

    jQuery('#BirthWeight').keyup(function () {
      this.value = this.value.replace(/[^0-9]/g,'');

      $( "#birth_weight" ).empty();
      var birth_weight = $( '#BirthWeight' ).val()/1000;
      $( '#birth_weight' ).val(  birth_weight );
  });
    jQuery('#Gestation').keyup(function () {
      this.value = this.value.replace(/[^0-9.+]/g,'');
  });
    $("#baby_reg_form").validate({
      rules:{
          BabyName:{
              characterwithslash:true
          },
          DOB: {
            required: true
        },
        MultiplePregnancyType:{
          required:function(element){
           if($('#MultiplePregnancy').val()=='Yes'){
            return true;
        }else{
            return false;
        }  
    },
},
Noofbabies:{
    required: function(element){
       if($('#MultiplePregnancy').val()=='Yes'){
        return true;
    }else{
        return false;
    }  
},
max: function(element){
  return MptypeNobabies(false);
},   
},
BirthOrder:{
  required:function(element){
   if($('#MultiplePregnancy').val()=='Yes'){

      return true;

  }else{

      return false;

  }  

} 
},
Sex:{
    required: true
},
'neonatal_consultant[]':{
  required:true,
},
BirthWeight:{
  digits:true, 
  maxlength:4,
  minlength:3,
  required: true
},
g_weeks:{
    max:43,
    min:23,
    required:true
},
g_days:{
    max:6,
    min:0,
            // required:true
        },
        ward_name:{
            required: true
        },
        room_no:{
            required: true
        },
        bed_no:{
            required: true
        }

    },
    messages:{
      BabyName:{
          characterwithslash:'Enter only alpha numeric and special character "/" '
      },
      MultiplePregnancyType:{
         required:'Select multiple pregnancy type !'
     },
     Noofbabies:{
         required:'Enter no of babies admitted !',
         max:'Enter the value based on multiple pregnancy type !',
     },
     BirthOrder:{
         required:'Select a birth order !'
     },
     'neonatal_consultant[]':{
         required:'Select a consultant !'
     },
     BirthWeight:{
         digits:'Enter birth weight in digits !',
         maxlength:'Enter no more than 4 digits !',
         minlength:'Enter at least 3 digits !'

     },

 },
 showErrors: function (errorMap, errorList) {

  if (typeof errorList[0] != "undefined") {
      var position = $(errorList[0].element).position().top;
      $('html, body').animate({
          scrollTop: position
      }, 300);
  }

  this.defaultShowErrors();
}

});

</script>
@endsection
