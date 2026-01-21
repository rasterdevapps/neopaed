@extends('app')
@section('content')
    <!-- Breadcrumbs line -->
    <div class="crumbs bread-crumbs-shadow">
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="/">Dashboard</a>
            </li>
            <li>
                <a href="{{ action('Reports\NicuDischargeController@index') }}">NICU Discharge Summary</a>
            </li>
        </ul>
        <!-- <ul class="crumb-buttons">
           <li><a href="javascript:void(0);" title="">Note: If you want edit Note please click Edit Notes</a></li>
        </ul> -->
       
    </div>
    <!-- /Breadcrumbs line -->

    <!-- Page Header -->
    <div class="page-header">
        <!--					<div class="page-title">
                                <h3>Dashboard</h3>
                            </div>-->
    </div>
    <!-- /Page Header -->

    <!--=== Page Content ===-->
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['url' => action('Reports\NicuDischargeController@index'),'id'=>'discharge-form']) !!}
            <div class="col-md-5 ">
                <div class="form-group">
                    {!! Form::hidden('flag',1) !!}
                    {!! Form::label('BabyId','Baby:') !!}
                    {!! Form::Select('BabyId',$babies,null,['class'=>'select2-select-00 full-width-fix','required']) !!}
                </div>
                {!! Form::hidden('id',null) !!}

                <div class="form-group">
                    {!! Form::label('NameoftheConsultant','Name of the Consultant Designation:') !!}
                    {!! Form::text('NameoftheConsultant',null,['class'=>'form-control','required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('Birth','Birth:') !!}
                    {!! Form::textarea('Birth',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Problems','Problems:') !!}
                    {!! Form::textarea('Problems',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('RespiratorySystem','Respiratory System:') !!}
                    {!! Form::textarea('RespiratorySystem',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('CardiovascularSystem','Cardiovascular System:') !!}
                    {!! Form::textarea('CardiovascularSystem',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('GastrointestinalSystem','Gastrointestinal System:') !!}
                    {!! Form::textarea('GastrointestinalSystem',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Communicationwithparents','Communication with parents:') !!}
                    {!! Form::textarea('Communicationwithparents',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Investigations','Investigations:') !!}
                    {!! Form::textarea('Investigations',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('DischargeInstructions','Discharge Instructions:') !!}
                    {!! Form::textarea('DischargeInstructions',null,['class'=>'form-control','rows'=>5]) !!}
                </div>

            </div>
            <div class="col-md-offset-1 col-md-5">


                <div class="form-group">
                    {!! Form::label('Procedures ','Procedures:') !!}
                    {!! Form::text('Procedures',null,['class'=>'form-control','id'=>'Procedures']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('AntenatalUltrasoundScanFindings','Antenatal Ultrasound scan findings:') !!}
                    {!! Form::textarea('AntenatalUltrasoundScanFindings',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('CentralNervousSystem','Central nervous system:') !!}
                    {!! Form::textarea('CentralNervousSystem',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Sepsis','Sepsis:') !!}
                    {!! Form::textarea('Sepsis',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Ophthalmology','Ophthalmology:') !!}
                    {!! Form::textarea('Ophthalmology',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Hematology','Hematology, electrolytes, Glucose and Jaundice:') !!}
                    {!! Form::textarea('Hematology',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('NewbornScreening','Newborn Screening:') !!}
                    {!! Form::textarea('NewbornScreening',null,['class'=>'form-control','rows'=>5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Followup','Follow up:') !!}
                    {!! Form::textarea('Followup',null,['class'=>'form-control','rows'=>5]) !!}
                </div>


            </div>
            <div class="button-row">
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary form-control report-preview"><i class="fa fa-filter"></i> <span>{!! $SubmitButtonText !!}</span>
                    </button>

                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary form-control report-save"><i class="fa fa-floppy-o" aria-hidden="true"></i> <span>{!! $SaveButton !!}</span>
                    </button>

                </div>
                <div class="col-md-2">
                    <a href="javascript:void(0);" class="btn btn-default form-control" onclick="$('form')[0].reset();"><i
                                class="fa fa-exclamation-circle"></i><span>Clear</span></a></div>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.col-md-12 -->
    </div> <!-- /.row -->
    <!-- /Page Content -->
@endsection
@section('scripts')

<script type="text/javascript">

  // $('#BabyId').change(function(){

  //     var url    = "{{ url('nicu-discharge')}}";

  //     var babyId = $(this).val();

  //     if(babyId!=0){

  //       getDischargedetails(babyId,url);

  //     }else{

  //       $('input[name="NameoftheConsultant"],input[name="Procedures"],textarea').val('');

  //     }  
  
  // });
  // $('.edit-enable').click(function(){

  //   var babyId=$('#BabyId').val();

  //    bootbox.confirm("If you enabled 'Edit Notes' ,'Neonatal Intensive Care Unit - Summary Of Stay' last modification will be lost . Are you sure want enable notes ?",function(confirmed){

  //             if(confirmed){

  //                   $.ajax({
  //                         type    :"GET",
  //                         url     : '{{ url("nicu-discharge-status") }}',
  //                         data    :{ babyId:babyId },
  //                         dataType: "json",
  //                         success:function(response){

  //                            $('input[name="NameoftheConsultant"],input[name="Procedures"],textarea').removeAttr('readonly');

  //                            Showalert('success','Record Changed as editable!');

  //                            $('.report-save').parent().removeClass('hide');

  //                         },
  //                         error: function(response) {

  //                            Showalert('success','Record Changes Made !');

  //                            $('.report-save').parent().addClass('hide');

  //                         }
                         
  //                   });
  //             }
  //     });          

  // });

  $('.report-preview').click(function(e){
       e.preventDefault();

       url= "{{ url('nicu-discharge-summary') }}";

       $('#discharge-form').attr('action',url).submit();


  });

 $('.report-save').click(function(e){
      e.preventDefault();

      url= "{{ url('nicu-discharge-reports') }}";

      $('#discharge-form').attr('action',url).submit();

 }); 
</script>
@endsection











