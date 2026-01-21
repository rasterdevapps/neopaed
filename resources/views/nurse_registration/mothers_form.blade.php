<?php $write_permission = session('write_permission'); ?>

<!-- <style type="text/css">
.form-group.search-button-mrno {
     margin-top: 23px;
     margin-left: -27px;
}
.error-message{
      color:red;
}

</style> -->

<script type="text/javascript">
    function checkuniqemr() {
        @if(Request::segment(3) =='edit')
            return true;
        @else
            return "{{ url('mother-mrnumber-check') }}";
        @endif
      
    }
</script>
@php $mmrno = isset($_COOKIE["motherMrn"]) ? $_COOKIE["motherMrn"]: ''; @endphp
<div class="row">
    <div class="col-md-12">
       <!--  <div class="@if($sitesetting->mirthIntegration == 2 && Request::segment(3) != 'edit')col-md-9 col-xs-8 @else col-md-12 @endif">
            <div class="form-group">
                {!! Form::label('MMrNo','Mother\'s MRN.:') !!}
                @if ( isset($setting->OverwriteMotherMR ) && $setting->OverwriteMotherMR === 1)
                    {!! Form::text('MMrNo',$mmrno,['class'=>'form-control input-fields-shadow']) !!}
                @else
                    {!! Form::text('MMrNo',$mmrno,['class'=>'form-control input-fields-shadow']) !!}
                @endif
                 <span id="mr_no_error" class="error-message display-none"></span>
            </div>
        </div>    
        @if($sitesetting->mirthIntegration == 2 && Request::segment(3)!='edit')
            <div class="col-md-3 col-xs-4">
                <div class="form-group search-button-mrno">
                      <button class="btn btn-primary btn-basic-shadow" id="search"><i class="fa fa-search"></i> <span>Search</span>
                     </button>
                </div>
            </div>    
        @endif  -->
        
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12 label-control">
                            {!! Form::label('MMrNo','Mother\'s '.Lang::get('home.mrn').'.:') !!}
                        </div>
                        <div class="col-md-10 custom-input">
                            {!! Form::text('MMrNo',$mmrno,['class'=>'form-control input-fields-shadow']) !!}
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-primary btn-basic-shadow" id="search-mother-by-mr" disabled="true">
                                <i class="fa fa-search"></i> <span>Search</span>
                            </a>
                            <br>
                            <label id="search_mrn_no_error" style="display: none; color: red"></label>
                        </div>
                    </div>
                </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="widget box ">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> Mother Details</h4>
            </div>
            <div class="widget-content">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('MotherTitle','Title:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('MotherTitle',[''=>'N/A','Ms.'=>'Ms.','Mrs.'=>'Mrs.','Miss.'=>'Miss.','Dr.'=>'Dr.'],null,['class'=>'form-control','tabindex'=>'1']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('MotherInitial','Initial:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('MotherInitial',null,['class'=>'form-control text-convertion-upper','tabindex'=>'2']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('MotherName','First Name:',['class'=>'required-label']) !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('MotherName',null,['class'=>'form-control text-convertion-title','tabindex'=>'3']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('MotherLastName','Last Name:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('MotherLastName',null,['class'=>'form-control text-convertion-title','tabindex'=>'4']) !!}
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('MotherDOB','DOB:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('MotherDOB',null,['class'=>'form-control parents-dob','readonly'=>true,'tabindex'=>'5']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('MothercYear','Completed Years:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('MothercYear',null,['class'=>'form-control','tabindex'=>'6']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('education_status','Mother\'s Education Level:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control','tabindex'=>'7']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('Occupation','Occupation Type:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Occupation',null,['class'=>'form-control text-convertion-title','tabindex'=>'8']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('occupation_status','Current Occupation Status:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control','tabindex'=>'9']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('Mobile','Contact No 1 :') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Mobile',null,['class'=>'form-control','tabindex'=>'10']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('LandLine','Contact No 2 :') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('LandLine',null,['class'=>'form-control','tabindex'=>'11']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('MotherEmail','Email :') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('MotherEmail',null,['class'=>'form-control','tabindex'=>'12']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('MotherSpokenLanguages','Mother Spoken Languages:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('MotherSpokenLanguages',null,['class'=>'form-control text-convertion-title','tabindex'=>'13']) !!}
                    </div>
                </div> 
                 <div class="form-group">
                    <p class="divider">&nbsp;</p>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="widget box ">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> Partner Details</h4>
            </div>
            <div class="widget-content">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('PartnerTitle','Title:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('PartnerTitle',[''=>'N/A','Mr.'=>'Mr.','Dr.'=>'Dr.'],null,['class'=>'form-control','tabindex'=>'19']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('PartnerInitial','Initial:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('PartnerInitial',null,['class'=>'form-control text-convertion-upper','tabindex'=>'20']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('PartnerName','First Name:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('PartnerName',null,['class'=>'form-control text-convertion-title','tabindex'=>'21']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('PartnerLastName','Last Name:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('PartnerLastName',null,['class'=>'form-control text-convertion-title','tabindex'=>'22']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('PartnerDOB','DOB:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('PartnerDOB',null,['class'=>'form-control parents-dob','readonly'=>'true','tabindex'=>'23']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('PartnercYear','Completed Years:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('PartnercYear',null,['class'=>'form-control','tabindex'=>'24']) !!}
                    </div>
                </div>
                 <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('partner_education_status','Father\'s Education Level:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('partner_education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control','tabindex'=>'25']) !!}
                    </div>
                </div>
                 <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('PartnerOccupation','Occupation Type:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('PartnerOccupation',null,['class'=>'form-control','tabindex'=>'26']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('partner_occupation_status','Current Occupation Status:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('partner_occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control','tabindex'=>'27']) !!}
                    </div>
                </div>
            
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('PartnerContact','Contact No 1:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('PartnerContact',null,['class'=>'form-control','tabindex'=>'28']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('PartnerMobile','Contact No 2 :') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('PartnerMobile',null,['class'=>'form-control','tabindex'=>'29']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('Email','Email:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Email',null,['class'=>'form-control','tabindex'=>'30']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                    {!! Form::label('FatherSpokenLanguages','Father Spoken Languages:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('FatherSpokenLanguages',null,['class'=>'form-control','tabindex'=>'31']) !!}
                </div>
                </div>
                <div class="form-group">
                    {!! Form::checkbox('samecontacts', 1, null, ['class' => 'field samecontacts']) !!}
                    {!! Form::label('samecontacts','Same as mother\'s contact details including languages') !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /Validation Example 2 -->
</div>


<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="widget box ">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> Current Address</h4>
            </div>
            <div class="widget-content">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('Address1','Address Line 1 (Door/Flat No./Home Name) :') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Address1',null,['class'=>'form-control','tabindex'=>'14']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('Address2','Address Line 2 (Street Name/Building Name):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Address2',null,['class'=>'form-control','tabindex'=>'15']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('Address3','Address Line 3 (City):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Address3',null,['class'=>'form-control','tabindex'=>'16']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('Address4','Address Line 4 (Pin code/Zip code):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Address4',null,['class'=>'form-control','tabindex'=>'17']) !!}
                    </div>
                </div>
                 <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('Address5','Address Line 5 (Country):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Address5',null,['class'=>'form-control','tabindex'=>'18']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <p class="divider">&nbsp;</p>
                </div>


            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="widget box ">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> Mailing Address</h4>
            </div>
            <div class="widget-content">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('FatherAddress1','Address Line 1 (Door/Flat No./Home Name):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('FatherAddress1',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('FatherAddress2','Address Line 2 (Street Name/Building Name):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('FatherAddress2',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('City','Address Line 3 (City):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('City',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('Postcode','Address Line 4 (Pin code/Zip code):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Postcode',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                 <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('Country','Address Line 5 (Country):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Country',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::checkbox('sameasmailaddress', 1, null, ['class' => 'field sameasmailaddress']) !!}
                    {!! Form::label('sameasmailaddress','Same as Current Address') !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /Validation Example 2 -->
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
      @if(in_array('BABY_REG',$write_permission)) 
       <div class="col-md-6 col-sm-6 col-xs-12 text-center">
             <button type="submit"  value="babycreate" name="babycreate" class="btn save-button-shadow btn-info btn-block  form-control save-btn">
                <i class="fa fa-child"></i> 
                <span>{!! $createBaby !!}</span>
             </button>
        </div>
      @endif
      <div class="col-md-6 col-sm-6 col-xs-12 text-center">
            <a href="{{ action('Registration\MotherController@index') }}" class="btn save-button-shadow btn-default btn-block canceled-flow form-control" onclick="$('form')[0].reset();">
                <i class="fa fa-exclamation-circle"></i> 
                <span>Cancel</span>
            </a>
      </div>
</div>

</div>
<br><br>

<script type="text/javascript">
 $(document).ready(function () {

    $('#MotherDOB').change(function () {
        caluclateAge('MotherDOB','MothercYear');
    });

    $('#PartnerDOB').change(function () {
        caluclateAge('PartnerDOB','PartnercYear');
    });

    $('.samecontacts').click(function(){
         if($('.samecontacts').is(':checked')){

            $('#PartnerContact').val($('#Mobile').val());
            $('#PartnerMobile').val($('#LandLine').val());
            $('#Email').val($('#MotherEmail').val());
            $('#FatherSpokenLanguages').val($('#MotherSpokenLanguages').val());

         } else {

            $('#PartnerContact').val('');
            $('#PartnerMobile').val('');
            $('#Email').val('');
            $('#FatherSpokenLanguages').val('');

         }
    });

    $('.sameasmailaddress').click(function () {
            if ($('.sameasmailaddress').is(':checked')) {

                $('#FatherAddress1').val($('#Address1').val());
                $('#FatherAddress2').val($('#Address2').val());
                $('#City').val($('#Address3').val());
                $('#Postcode').val($('#Address4').val());
				$('#Country').val($('#Address5').val());

            } else {

                $('#FatherAddress1').val("");
                $('#City').val("");
                $('#FatherAddress2').val("");
                $('#Country').val("");
                $('#Postcode').val("");
            }
            

    });
    $('.sameascurrentaddress').click(function () {
            if ($('.sameascurrentaddress').is(':checked')) {

                $('#Address1').val($('#City').val());
                $('#Address2').val($('#State').val());
                $('#Address3').val($('#Country').val());
                $('#Address4').val($('#Postcode').val());

            } else {

                $('#Address1').val("");
                $('#Address2').val("");
                $('#Address3').val("");
                $('#Address4').val("");
                
            }
            

    });
});


</script>

