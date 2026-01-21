@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
@if(Session::has('slug-nav'))
{{ Session::forget('slug-nav') }}
@endif
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }} ">{{ Lang::get('home.nicu_sub_admission_dashboard') }}</a>
        </li>
        <li>
            <a href="{{ action('Admission\NicuController@index') }}">{{ Lang::get('home.nicu_sub_admission') }} </a>
        </li>
        <li class="current">
            <a href="javascript:void(0);">{{ Lang::get('home.nicu_sub_admission_history') }} {{ $babyName or '' }}  {{ $babyMrno or '' }}</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>{{ Lang::get('home.nicu_sub_admission_history1') }}</h4>
                @if(in_array('NICU_FORM',$write_permission))
                <a href="{{ action('Admission\NicuController@chooseBaby') }}" title="" class="btn create-btn-spacing btn-basic-shadow btn-info pull-right"><i class="fa fa-plus "></i> <span>{{ Lang::get('home.nicu_sub_admission_create')}}</span></a>       
                @endif                         
            </div>
            <div class="widget-content inherittable">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                    </div>
                </div>
                <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
                    <thead>
                        <tr>
                            <th>{{ Lang::get('home.nicu_sub_admission_sno')}}</th>
                            <th>{{ Lang::get('home.nicu_sub_admission_admission')}}</th>
                            <th>{{ Lang::get('home.ip')}}</th>
                            <th class="hidden-xs">{{ Lang::get('home.nicu_sub_admission_doa') }}</th>
                            <th class="hidden-xs">{{ Lang::get('home.nicu_sub_admission_dod') }}</th>
                            <th class="hidden-xs">Neonatal Problems</th>
                            <th class="hidden-xs">
                                Print 
                            </th>
                            <th class="hidden-xs hide">
                                Edited Print
                            </th>
                            @if(in_array('NICU_FORM',$delete_permission))
                            <th class="hidden-xs">
                                {{ Lang::get('home.nicu_sub_admission_delete') }}
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php( $i =0 )
                        @foreach($results as $res_key => $result)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                <a class="pull-left input-width-small icon @if(!in_array('NICU_FORM',$write_permission)) permission-denied @endif" href="@if(in_array('NICU_FORM',$write_permission)) {{ action('Admission\NicuController@edit',SiteHelpers::encrypt_id($result->NicuId)) }} @else javascript:void(0); @endif">
                                {{ $result->episodes }}
                                </a>
                                <span class="pull-left">
                                    @if (isset($file_list[$result->NicuId]))
                                        @foreach($file_list[$result->NicuId] as $type => $count)
                                           @include('registration.media_list')
                                        @endforeach
                                    @endif
                                </span>
                            </td>
                            <td>{{  $result->ip_number }}</td>
                            <td class="hidden-xs">
                                @if(date('Y',strtotime($result->AdmissionDate)) > 1970) 
                                {{  date('d-m-Y',strtotime($result->AdmissionDate)) }}
                                @endif
                            </td>
                            <td class="hidden-xs">
                                @if(date('Y',strtotime($result->DischargeDate)) > 1970) 
                                {{  date('d-m-Y',strtotime($result->DischargeDate)) }}
                                @endif
                            </td>
                            </td>
                            <!-- <td class="center-align-phone hidden-xs">
                                </td> -->
                            <td class="hidden-xs">
                                <a class="btn btn-success btn-view" href="{{ url('problem-systems-episodes/'.SiteHelpers::encrypt_id($result->BabyId.'-'.$result->AdmissionId)) }}">
                                <i class="fas fa-notes-medical"></i>
                                </a>
                            </td>
                            <td class="center-align-phone hidden-xs">
                                <a class="btn btn-warning btn-view" href="{{ action('Admission\NicuController@printData',SiteHelpers::encrypt_id($result->NicuId)) }}" title="Generated Print">
                                <i class="fa fa-print"></i> 
                                </a>
                            </td>
                            @if(in_array('NICU_FORM',$delete_permission))
                            <td class="center-align-phone hidden-xs">
                                <a class="btn btn-danger btn-view mr-10" href="javascript:void(0);" onclick="DeleteData({{$result->NicuId}}, {{$result->hasDaycare}})">
                                <i class="fa fa-trash"></i> 
                                </a>
                            </td>
                            @endif
                            <td class="center-align-phone hidden-xs hide">
                                @if ($result->edited)
                                <a class="btn btn-default btn-view open-doc-editor"  href="{{ action('Admission\NicuController@getAbbreviatedsummaryShow',$result->NicuId) }}" title="Final Print">
                                <i class="fa fa-file-word-o"></i> 
                                </a>
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
<div class="row">
    <div class="col-md-12">
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-fixed">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 id="myModalLabel" class="modal-title color-white">Baby Details</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-7">Date:</label>
                            <span class="col-date col-md-5"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-7">Time:</label>
                            <span class="col-time col-md-5"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-7">Name:</label>
                            <span class="col-name col-md-5"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-7">Blood Group:</label>
                            <span class="col-bloodgroup col-md-5"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-7">DOB:</label>
                            <span class="col-dob col-md-5"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-7">Sex:</label>
                            <span class="col-sex col-md-5"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-7">{{ Lang::get('home.mrn')}}:</label>
                            <span class="col-bmrno col-md-5"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-7">Type of Care:</label>
                            <span class="col-typeofcare col-md-5"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-7">Readmission:</label>
                            <span class="col-readmission col-md-5"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-7">Age On Admission in days:</label>
                            <span class="col-admissionage col-md-5"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-7">Birth Weight(Gms):</label>
                            <span class="col-birthweight col-md-5"></span>                   
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-7">Admission Weight:</label>
                            <span class="col-admissionweight col-md-5"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-7">Gestation :</label>
                            <span class="col-gestation col-md-5"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-7">Corrected Gestational Age:</label>
                            <span class="col-correctedgestation col-md-5"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-7">Referred From:</label>
                            <span class="col-referredby col-md-5"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-7">Referral Reason:</label>
                            <span class="col-referralreason col-md-5"></span>
                        </div>
                    </div>
                    <div class="row modal-fixed">
                        <div class="modal-footer" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function ShowModal(id,url1){
      $.ajax({
        type    :"GET",
        url     : url1,
        data    :{ id:id },
        success :function(response){
          Datas = JSON.parse(response);
          EditLink = '';    
          @if(in_array('NICU_FORM',$write_permission))
          EditLink = '<a href="/nicu-admission/'+id+'/edit" class=""><i class="fa fa-pencil"></i></a>';
          @endif
          PrintLink = '<a href="/nicu-admission/'+id+'/printdata" class=""><i class="fa fa-print"></i></a>';
          $(".modal-title").html(Datas['BabyName']+' '+EditLink + ' '+PrintLink);
          
          $(".col-name").html(Datas['BabyName']);
          $(".col-bmrno").html(Datas['BMrNo']);
          $(".col-sex").html(Datas['Sex']);
          $(".col-bloodgroup").html(Datas['BabyBloodGroup']);                                                               
          $(".col-birthweight").html(Datas['BirthWeight']);                                                             
          $(".col-dob").html(Datas['DOB']);                                                                                             
          
          $(".col-gestation").html(Datas['Gestation']);                                                             
          $(".col-correctedgestation").html(Datas['CorrectedGestation']);                                                                                 
          $(".col-date").html(Datas['AdmissionDate']);                                                              
          $(".col-time").html(Datas['AdmissionTime']);                                                                              
          
          $(".col-admissionweight").html(Datas['AdmissionWt']);                                                             
          $(".col-admissionage").html(Datas['AgeOnAdmissioninDays']);                                                                                 
          
          $(".col-typeofcare").html(Datas['TypeOfCare']);                                                                                                                                 
          $(".col-referredby").html(Datas['ReferredBy']);
          $(".col-referralreason").html(Datas['ReferralReason']);                                                               
          
        },
        complete: function(){
          $('#basicModal').modal('show');
        }
      });
    }
    function DeleteData(id, hasDaycare){
      console.log(hasDaycare);
      if (hasDaycare == true) {
        
        Showalert('warning', 'Access denied : This nicu admission has daycare sheet !');
        
      } else {
        
        bootbox.confirm("Are you sure?",function(confirmed){
          if(confirmed){
            $("#DeleteForm").attr('action',"{{ action('Admission\NicuController@index') }}/"+id);
            $("#DeleteForm").submit();
          }
        });
        
      }
      
    }
    $( "#search" ).click(function() {
      $( "#search-form" ).submit();
    });
    
    $('.sorting_by').click(function(e){
      e.preventDefault();
      $('#sortby').val($(this).data('field'));
      if($('#sortorder').val()=='desc'){
        $('#sortorder').val('asc');
      }else{
        $('#sortorder').val('desc');
      }
      $('#limit-form').submit();
      
    });
    
    $('.sort_with_page').click(function(e){
      e.preventDefault();
      var sorting_param=$('#limit-form').serialize();
      var link =$(this).attr('href');
      window.location=link+'&'+sorting_param;
      
      
    });
    $(document).ready(function(){
      
      $('.dataTables_paginate .pagination').addClass('table-view-shadow');
      
      var dataTableresponseive = ['.dataTables_header .col-md-6','.dataTables_footer .col-md-6'];
      
      $.each(dataTableresponseive,function(dataTableclassindex,dataTableclassvalue){
        
        $(dataTableclassvalue).each(function(dataTablechildindex,dataTablechildvalue){
          if(dataTablechildindex == 0){
            $(this).addClass('col-xs-4');
          }
          if(dataTablechildindex == 1){
            $(this).addClass('col-xs-8');
          }
          
        });
        
      });
      
    });
</script>
@endsection
