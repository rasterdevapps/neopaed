@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="current">
            <a href="{{ action('Registration\BabyController@index') }}">Baby Registration</a>
        </li>
    </ul>
    <ul class="pull-right list-none mtb-10">
        <li class=" display-inline-block"><span class="btn btn-warning btn-view mt-0"><i class="fa fa-file-o"></i></span><span class="color-black">&nbsp;Create New Proforma</span></li>
        <li class=" display-inline-block"><span class="btn btn-dark btn-view mt-0"><i class="fa fa-file"></i></span><span class="color-black">&nbsp;View / Edit Proforma</span></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="widget box table-view-shadow">
            <div class="widget-header">
              <h4>{{ Lang::get('home.baby_registration') }}</h4>
        @if(in_array('BABY_REG',$write_permission))
                <a href="{{ action('Registration\BabyController@chooseMother') }}" title="create new"  class="btn btn-basic-shadow btn-info pull-right create-btn-spacing">
              <i class="fa fa-plus "></i> 
              <span>{{ Lang::get('home.baby_create_new') }}</span>
          </a> 
          @if($sitesetting->mirthIntegration == 2)  
            <button type="button" title="Get Record From IHMS" class="btn btn-info pull-right btn-basic-shadow hidden-xs create-btn-spacing btn-spacing-right" data-toggle="modal" data-backdrop="static" data-target="#create_baby">
                <i class="fa fa-plus "></i> 
                <span>Create New Form Ihms</span>
            </button>
          @endif 
        @endif                               
            </div>
      <div class="widget-content">
        <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <div class="row">
            <div class="dataTables_header clearfix">
              <div class="col-xs-4 col-sm-6 col-md-6">
                <div id="data-list_length" class="dataTables_length">
                  <label class="data_limit">
                      {!! Form::open(['url' => action('Registration\BabyController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                      <select name="limit"  size="1" aria-controls="data-list">
                        <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                        <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                        <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                        <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                        <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                      </select><span class="hidden-xs">{{ Lang::get('home.baby_records') }}</span>
                      {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                      {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                      {!! Form::close() !!}
                  </label>
                </div>
              </div>
              {!! Form::open(['url' => action('Registration\BabyController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!}
                <div class="col-xs-8 col-sm-6 col-md-4 pull-right"> 
                  <div class="input-group">
                    <span id="search" class="input-group-addon">
                      <i class="glyphicon glyphicon-search"></i>
                    </span>
                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ @$search['search_txt'] }}" placeholder="{{ Lang::get('home.baby_search') }}"  class="form-control">
                    <a href="{{ action('Registration\BabyController@index') }}" class="input-group-addon">
                      <i class="glyphicon glyphicon-remove"></i>
                    </a>
                  </div>   
                </div>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
                <table class="table table-striped table-bordered table-responsive" id="data-list">
                    <thead>
                        <tr>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}">Baby Name</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BMrNo') }}"data-hide="phone">{{ Lang::get('home.mrn') }}</th>
                            <th class="sorting_by sorting_icon hidden-xs @if($order['sortby'] == 'Sex') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('Sex') }}" data-hide="phone">Sex</th>
                            <th class="visible-xs">More</th>
                            <th class="sorting_by sorting_icon hidden-xs @if($order['sortby'] == 'DOB') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('DOB') }}" data-hide="phone,tablet">DOB</th>
                            <th class="sorting_by sorting_icon hidden-xs @if($order['sortby'] == 'BabyBloodGroup') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyBloodGroup') }}" data-hide="phone,tablet">Blood Group</th>
                            <th class="">Neonatal Proforma</th>
                            <th class="">Preview</th>
                            @if(in_array('BABY_REG',$delete_permission))
                            <th class="">Delete</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($results) > 0)
                        @for ($i = 0; $i <  @count($results); $i++)
                        <tr >
                            <td>              
                                <a class="icon @if(!in_array('BABY_REG',$write_permission)) permission-denied  @endif edit-content-link text-captialize" href="@if(in_array('BABY_REG',$write_permission)) {{ action('Registration\BabyController@edit', SiteHelpers::encrypt_id($results[$i]->BabyId)) }} @else javascript:void(0); @endif">
                                {{  $results[$i]->BabyName }}
                                </a>  
                            </td>
                            <td>{{  $results[$i]->BMrNo }}</td>
                            <td class="hidden-xs">{{  $results[$i]->Sex }}</td>
                            <td class="visible-xs">
                                <a href="#">
                                <span class="fa fa-info-circle hidden-lg" aria-hidden="true"  data-toggle="tooltip" data-original-title="Sex : {!!  $results[$i]->Sex  !!} &#13; Blood Group: {!!   $results[$i]->BabyBloodGroup !!}"></span>
                                </a> 
                            </td>
                            <td class="hidden-xs">{{ (date('Y',strtotime($results[$i]->DOB)) > 1970) ? date('d-m-Y',strtotime($results[$i]->DOB)) : '' }}</td>
                            <td class="hidden-xs">{{  $results[$i]->BabyBloodGroup }}</td>
                            @php  
                            $performa = \SiteHelpers::checkPerforma($results[$i]->BabyId);
                            @endphp
                            @if($performa != 0)
                            <td class="">
                                <a class="btn btn-dark btn-view @if(!in_array('BABY_REG',$write_permission)) permission-denied @endif" href="@if(in_array('BABY_REG',$write_permission)) {{ action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($performa)) }}  @endif" title="View Proforma">
                                <i class="fa fa-file"></i>
                                </a>
                            </td>
                            @else
                            <td class="">
                                <a class="btn btn-warning btn-view @if(!in_array('BABY_REG',$write_permission)) permission-denied @endif" href="@if(in_array('BABY_REG',$write_permission)) {{url('neonatal/create')}}/{{\SiteHelpers::encrypt_id($results[$i]->BabyId)}} @endif" title="Create New Proforma">
                                <i class="fa fa-file-o"></i>
                                </a>
                            </td>
                            @endif
                            <td class="">
                                <a class="icon view-button btn btn-info btn-view" href="javascript:" id="baby-{{$results[$i]->BabyId}}" onclick="ShowModal({!!  $results[$i]->BabyId !!});" title="View Details">
                                <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            @if(in_array('BABY_REG',$delete_permission))
                            <td class="">
                                <a class="icon btn btn-danger btn-remove" href="javascript:" onclick="DeleteData({{ $results[$i]->BabyId}}, {{ $results[$i]->hasChild }})" title="Delete Record">
                                <i class="fa fa-trash"></i> 
                                </a>
                            </td>
                            @endif
                        </tr>
                        @endfor
                        @else
                        <tr>
                            <td colspan="8" style="text-align:center;"> No Record Found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
      <div class="row">
        <div class="col-md-12">
          <div class="dataTables_footer clearfix">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
              {{ Lang::get('home.baby_showing') }} {{$pagination['limit'][0]}} {{ Lang::get('home.baby_to') }} {{$pagination['limit'][1]}} {{ Lang::get('home.baby_of') }} {{$pagination['total']}} {{ Lang::get('home.baby_entries') }} {{ @$search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="dataTables_paginate paging_bootstrap pagination_footer">
                <ul class="pagination">    
                  <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                    <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('baby-registration?page='.$pagination['previous']) }}@endif">&#8592; {{ Lang::get('home.baby_previous') }}</a>
                  </li>
                  @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                    <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                      <a class='sort_with_page' href="{{ url('baby-registration?page='.$i) }}">{{$i}}</a>
                    </li>  
                  @endfor
                  <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                    <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('baby-registration?page='.$pagination['next']) }}@endif">{{ Lang::get('home.baby_next') }} &#8594; </a>  
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.row -->   
    </div>
  </div>
</div>
<!-- /Page Content -->
<!-- DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK -->                    
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}      
<div class="baby-view modal fade bs-example-modal-lg baby-list-modal" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-fixed">
            <div class="modal-header">
                       <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 id="myModalLabel" class="modal-title color-white" style="display: contents;">Baby Details</h4>
            </div>
                  
            <div class="modal-body pt-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Name:</label>
                            <span class="col-name col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Birth Status:</label>
                            <span class="col-birthstatus col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">{{ Lang::get('home.mrn') }}:</label>
                            <span class="col-bmrno col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Mother Name:</label>
                            <span class="col-mothername col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Birth City:</label>
                            <span class="col-city col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Sex:</label>
                            <span class="col-sex col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Birth Weight:</label>
                            <span class="col-birthweight col-md-6"></span>                   
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Birth Order:</label>
                            <span class="col-birthorder col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">DOB:</label>
                            <span class="col-dob col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6 col-md-6">TOB:</label>
                            <span class="col-tob col-md-6"></span>
                        </div>
                    </div>
                   <!--  <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-6">Background Details:</label>
                            <span class="col-background col-md-6"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-6">Confidential Background Details:</label>
                            <span class="col-confident col-md-6"></span>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Baby's Blood Group:</label>
                            <span class="col-bloodgroup col-md-6"></span>
                        </div>
                    </div>
                    <div class="row mgplan modal-fixed">
                        <div class="modal-footer" >
                        </div>
                    </div>
                </div>
            </div>
              
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="create_baby" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 0px solid #e5e5e5;">
                <div class="col-md-10">
                    <h5 class="modal-title float-none">Search baby by {{ Lang::get('home.mrn') }}</h5>
                </div>
                <button type="button" class="close search-modal-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="font-size:25px;">&times;</span>
                </button>  
            </div>
            <div class="modal-body"  style="margin: 25px 0px;">
                {!! Form::open(['url'=>'','method'=>'get','id'=>'Search-Mr']) !!} 
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::text('BMrNo',null,['class'=>'form-control input-fields-shadow','placeholder'=>'Please enter '. Lang::get('home.mrn')]) !!}
                        <span class="mr-number-error" style="color: red; display: none;"></span>
                    </div>
                </div>
                <div class="col-md-6 col-xs-offset-3">
                    <table>
                        <tr class="mirth-search-loader">
                            <td>
                                <button style="margin: 2px;" class="btn save-button-shadow save_btn mirth-search-operation btn-primary btn-block form-control">
                                <i class="fa fa-floppy-o"></i> 
                                <span>Search </span>
                                </button> 
                            </td>
                        </tr>
                    </table>
                </div>
                {!! Form::close() !!}              
            </div>
            <div class="modal-footer" style="border-top: 0 solid #e5e5e5;">
            </div>
        </div>
    </div>
</div>
@include('registration.baby_register_ihms')
@endsection
@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $( "#Search-Mr" ).validate({
      rules: {
        BMrNo: {
          required: true,
        }      
      },
      messages: {
        BMrNo: {
          required: "Please Enter Baby {{ Lang::get('home.mrn') }}!",
        }
      },
      submitHandler: function(form) {
        var BMrNo=$('input[name="BMrNo"]').val();
        var statusFlag = false;
        $.ajax({
          type    :"POST",
          url     :"{{url('baby-Mrcheck')}}",
          data    :{BMrNo:BMrNo},
          datatype:'json',
          beforeSend:function(){
            $('.mirth-search-operation').attr('disabled',true);
            $('.mirth-search-loader').append('<td><i class="fa fa-spinner fa-pulse  fa-2x  mirth-search-loading" aria-hidden="true"></i></td>');
          },
          success:function(responseJSON){
            statusFlag=responseJSON.status;
            if(statusFlag){
             $('.mr-number-error').text(responseJSON.message).fadeOut();
             mirthBind(BMrNo);
           }else{
             $('.mr-number-error').text(responseJSON.message).fadeIn();
             $('.mirth-search-operation').removeAttr('disabled');
             $('.mirth-search-loading').remove();
           }
         }
       });  
      }
    });
    
    
    
    function mirthBind(BMrNo) {
    
     $.ajax({
      type    :"POST",
      url     :"{{ url('patient-details') }}",
      data    :{mr_no:BMrNo},
      complete: sent_mirth(BMrNo),
      success :function(response){
      },
    });
    }
    
    
    function sent_mirth(BMrNo) {
    $.ajax({
      type    :"POST",
      url     :"{{ url('get-patient') }}",
      data    :{mr_no:BMrNo},
      success :function(response){
        $('.mirth-search-operation').removeAttr('disabled');
        $('.mirth-search-loading').remove();
        var overall =JSON.parse(response);
        console.log(overall);
        if(overall.status==true){
          var Details = overall.result;
          $('#create_baby').modal('hide');
          $('#create_baby_details').modal({backdrop: 'static', show: true });
          $('#BabyName').val(Details.Name[0]);
          $('#MotherName').val('M/o'+Details.Name[0]);
          $('#PartnerName').val('F/o'+Details.Name[0]);
          $('#BMrNo').val(BMrNo);
          $("#DOB").datepicker("setDate", Details.Dob);
          $('#Mobile').val(Details.PhoneNumber[1]);
          $('#LandLine').val(Details.PhoneNumber[0])
          $('#Address1').val(Details.Address[0]);
          $('#Address2').val(Details.Address[1] + Details.Address[2]);
          $('#Address3').val(Details.Address[4]);
          $('#Address4').val(Details.Address[5]);
          $('#Address5').val(Details.Address[7]);
          $('#Sex').val(Details.Gender);
        }else{
         $('.mr-number-error').text(overall.message).fadeIn();
       }
    
     }
     
    });
    }  
    
    function ShowModal(id) {
        $("#basicModal").modal({
            backdrop: 'static',
            keyboard: false
        });
    $('#baby-'+id).css({'cursor' : 'not-allowed', 'pointer-events' : 'none', 'opacity' : 0.8});
    $.ajax({
     type    :"GET",
     url     :"{{ url('/baby-registration') }}"+"/"+id,
     data    :{ id:id },
     success :function(response){
      Datas = JSON.parse(response);
          //$(".modal-title").html(Datas['BabyName']);
          $(".col-name").html(Datas['BabyName']);
          $(".col-bmrno").html(Datas['BMrNo']);
          $(".col-birthstatus").html(Datas['BirthStatus']);
          $(".col-sex").html(Datas['Sex']);
          $(".col-city").html(Datas['BirthCity']);
          $(".col-bloodgroup").html(Datas['BabyBloodGroup']);                                     
          $(".col-birthorder").html(Datas['BirthOrder']);                                     
          $(".col-birthweight").html(Datas['BirthWeight']);                                     
          $(".col-fspoken").html(Datas['FatherSpokenLanguages']);                                     
          $(".col-mspoken").html(Datas['MotherSpokenLanguages']);                                     
          $(".col-dob").html(Datas['DOB']);                                                     
          $(".col-tob").html(Datas['TOB']);                                      
          $(".col-background").html(Datas['BackgroundDetails']);              
            $(".col-confident").html(Datas['ConfidentialBackgroundDetails']);
            $(".col-mothername").html(Datas['MotherName']);                 
            
          },
          complete: function(){
            $('#basicModal').modal('show');
          }
        });
    }

    $('#basicModal').on('hidden.bs.modal', function () {
        $('.icon.btn.btn-info.btn-view').css({'cursor' : 'default', 'pointer-events' : 'auto', 'opacity' : 1});
    });
    function DeleteData(id, hasChild) {
    
    if (hasChild == true) {
    Showalert('warning','Access Denied: This baby refered to a neonatal or op record !')
    } else {
    
    bootbox.confirm("Are you sure?",function(confirmed) {
    
      if (confirmed) {
        $("#DeleteForm").attr('action',"{{ action('Registration\BabyController@index') }}/"+id);
        $("#DeleteForm").submit();
      }
    
    });
    
    }
    
    
    
    }

$('#search').click(function() {
    $('#search-form').submit();
});

$('.sorting_by').on('click', function(e) {
    e.preventDefault();
    var sortby       = $(this).data('field');
    pagination(sortby);
});

$('.sort_with_page').click(function(e){
    e.preventDefault();
    var sorting_param = $('#limit-form').serialize();
    var link      = $(this).attr('href');
    var searchText    = $('input[name="search_txt"]').val();
    window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
});

$('select[name="limit"]').on('change',function(e) {
    e.preventDefault();
    pagination();
});

function pagination(sortby) {
  var pagination_url = $('#limit-form').attr('action');
  var limit          = $('select[name="limit"] option:selected').val();
  var searchText     = $('input[name="search_txt"]').val();    
  var sorting_param  = $('#limit-form').serialize();
  var sorting_param1 = sorting_param.split('&sortorder=')[0];
  var sorting_param2 = sorting_param.split('&sortorder=')[1];

  if (sortby) {
    $('#sortby').val(sortby);
    if (sorting_param2 == 'desc') {
      var sortorder = 'asc';
      // $("[data-field='"+ sortby +"']").removeClass('sorting_icon');
      // $("[data-field='"+ sortby +"']").addClass('sorting_asc_icon');
      $('#sortorder').val(sortorder);
    } else {
      var sortorder = 'desc';
      // $("[data-field='"+ sortby +"']").removeClass('sorting_icon');
      // $("[data-field='"+ sortby +"']").addClass('sorting_desc_icon');
      $('#sortorder').val(sortorder);
    }
    window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
  } else {
    window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
  }

}
</script>
@endsection
