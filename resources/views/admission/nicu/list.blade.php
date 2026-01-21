@extends('app')
@section('content')
@php
$write_permission = session('write_permission'); 
@endphp 
@if(Session::has('slug-nav'))
{{ Session::forget('slug-nav') }}
@endif
@php
Session::put('nicu-create-slug',1);
$hide='true'; 
@endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
   <ul id="breadcrumbs" class="breadcrumb">
      <li>
         <i class="icon-home"></i>
         <a href="{{ url('/') }} ">{{ Lang::get('home.nicu_admission_dashboard') }}</a>
      </li>
      <li class="current">
         <a href="{{ action('Admission\NicuController@index') }}">{{ Lang::get('home.nicu_admission_proforma')}}</a>
      </li>
   </ul>
   <ul class="pull-right nicu-list discharge-color-code list-none mr-15 pl-0">
      <li><span class="info-tick info"></span> <b class="mb-2">{{ Lang::get('home.nicu_admission_inpatient')}}</b></li>
      <li><span class="tick success"></span>  <b class="mb-2">{{ Lang::get('home.nicu_admission_discharged')}}</b></li>
   </ul>
   <ul class="pull-right nicu-list discharge-color-code1 list-none hidden-xs hidden-sm">
      <li><a class='btn btn-info btn-basic-shadow search-btn' href="{{ action('Search\NicuController@create').'?module=admission' }}">
         <i class="fa fa-search"></i>  
         <span>{{ Lang::get('home.nicu_admission_advanced_search')}}</span></a>
      </li>
   </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
   <div class="col-md-12">
      <div class="widget box table-view-shadow">
         <div class="widget-header">
            <h4>{{ Lang::get('home.nicu_registerd_patient') }}</h4>
            @include('admission_filter')
            @if(in_array('MOTHER_REG',$write_permission))
            <div class="pull-right">
               <a href="{{ action('Search\NicuController@create').'?module=admission' }}" class='btn btn-info btn-basic-shadow visible-xs visible-sm ptb-7 btn-spacing-right search-btn'><span>
               <i class="fa fa-search"></i> 
               {{ Lang::get('home.nicu_admission_advanced_search')}}</span></a>
               <a href="{{ action('Admission\NicuController@chooseBaby') }}" title="create new" class="btn btn-info btn-basic-shadow create-btn-spacing create-btn"><i class="fa fa-plus"></i> <span>{{ Lang::get('home.nicu_admission_create_new')}}</span></a>      
            </div>
            @endif
         </div>
         <div class="widget-content">
            <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
               <div class="row">
                  <div class="dataTables_header clearfix" >
                     <div class="col-xs-4 col-sm-6 col-md-6">
                        <div id="data-list_length" class="dataTables_length ">
                           <label class="data_limit">
                           {!! Form::open(['url' => action('Admission\NicuController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                           <select name="limit"  size="1" aria-controls="data-list">
                           <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                           <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                           <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                           <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                           <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                           </select><span class="hidden-xs">{{ Lang::get('home.nicu_admission_records') }}</span>
                           {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                           {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                           {!! Form::close() !!}
                           </label>
                        </div>
                     </div>
                     {!! Form::open(['url' => action('Admission\NicuController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                     <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                        <div class="input-group">
                           <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                           <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ $search['search_txt'] }}" placeholder="Search">
                           <a href="{{ action('Admission\NicuController@index') }}" class="input-group-addon" id="search-reset"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                     </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>
            <table class="table  table-bordered table-responsive"  id="data-list">
               <thead>
                  <tr>
                     <th>S.No.</th>
                     <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}">{{ Lang::get('home.nicu_admission_baby_name')}}</th>
                     <th class="sorting_by sorting_icon @if($order['sortby'] == 'baby.BMrNo') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('baby.BMrNo') }}" data-hide="phone,tablet">{{ Lang::get('home.mrn')}}</th>
                     <th class="sorting_by sorting_icon @if($order['sortby'] == 'baby.DOB') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('baby.DOB') }}">{{ Lang::get('home.nicu_admission_dob')}}</th>
                     <th>{{ Lang::get('home.nicu_admission_doa')}}</th>
                     @if($hide=='false')
                     <th class="sorting_by sorting_icon @if($order['sortby'] == 'AdmissionDate') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('AdmissionDate') }}">Date</th>
                     @if(in_array('NICU_FORM',$write_permission))
                     <th>Edit</th>
                     <th class="hidden-xs">Delete</th>
                     @endif
                     <th>Preview</th>
                     <th data-hide="phone">Print</th>
                     @endif   
                  </tr>
               </thead>
               <tbody>
                  @if(count($results) > 0)
                  @for ($i = 0; $i <  @count($results); $i++)
                  <tr class="{{ $results[$i]->rowcolor }}">
                     <td>{{ $i+1 }}</td>
                     <td class="text-captialize">
                        @if (isset($results[$i]->NeonatalId))
                        <a href="{{ url('nicu-admission/sub-nicu-list/'.SiteHelpers::encrypt_id($results[$i]->BabyId))}}" class="check-neonatal" data-neonatal-id="{{$results[$i]->NeonatalId}}" data-baby-id="{{SiteHelpers::encrypt_id($results[$i]->BabyId)}}">
                        {{  $results[$i]->BabyName }}
                        </a>
                        @else
                        <a class="check-neonatal" data-neonatal-id="{{$results[$i]->NeonatalId}}" data-baby-id="{{SiteHelpers::encrypt_id($results[$i]->BabyId)}}">
                        {{  $results[$i]->BabyName }}
                        </a>
                        @endif
                     </td>
                     <td class="hidden-xs">{{  $results[$i]->BMrNo }}</td>
                     <td>
                        @if(date('Y',strtotime($results[$i]->DOB)) > 1970) {{  date('d-m-Y',strtotime($results[$i]->DOB)) }} @endif
                     </td>
                     <td>
                        @php $admissondate = ''; @endphp
                        @if(isset($AdmissionDatelist[$results[$i]->BMrNo]))    
                        @foreach($AdmissionDatelist[$results[$i]->BMrNo] as $admission)
                        @php $admissondate .= $admission->episodes.'  :  '.date('d-m-Y',strtotime($admission->AdmissionDate)).'<br/>' ;@endphp
                        @endforeach
                        @endif  
                        <i class="fa fa-calendar bs-tooltip admission-date" data-placement="left" data-original-title="{!! $admissondate !!}" aria-hidden="true"></i>
                     </td>
                     @if($hide=='false')
                     <td>{{  date('d-m-Y',strtotime($results[$i]->AdmissionDate)) }}</td>
                     @if(in_array('NICU_FORM',$write_permission))
                     <td class="">
                        <a class="icon" href="{{ action('Admission\NicuController@edit',$results[$i]->NicuId) }}">
                        <i class="fa fa-pencil"></i> 
                        <span class="hidden-phone">Edit</span>
                        </a>
                     </td>
                     <td class="hidden-xs">
                        <a class="icon" href="javascript:void(0);" onclick="DeleteData({{$results[$i]->NicuId}})">
                        <i class="fa fa-remove"></i> 
                        <span class="hidden-phone">Delete</span>
                        </a>
                     </td>
                     @endif
                     <td  class="hidden-xs">
                        <a class="icon view-button" href="javascript:void(0);" onclick="ShowModal({!!  $results[$i]->NicuId !!},'{{ action('Admission\NicuController@getData',$results[$i]->NicuId) }}')" >
                        <i class="fa fa-eye"></i> 
                        <span class="hidden-phone">View</span>
                        </a>
                     </td>
                     <td  class="center-align-phone">
                        <a class="icon" href="{{ action('Admission\NicuController@printData',$results[$i]->NicuId) }}">
                        <i class="fa fa-print"></i> 
                        <span class="hidden-phone">Print</span>
                        </a>
                     </td>
                     @endif 
                  </tr>
                  @endfor
                  @else
                  <tr>
                     <td colspan="5" class="text-center"><span>No Record Found</span></td>
                  </tr>
                  @endif 
               </tbody>
            </table>
            <div class="row">
               <div class="col-md-12">
                  <div class="dataTables_footer clearfix">
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                           {{ Lang::get('home.nicu_admission_showing')}} {{$pagination['limit'][0]}} {{ Lang::get('home.nicu_admission_to')}} {{$pagination['limit'][1]}} {{Lang::get('home.nicu_admission_of')}} {{$pagination['total']}} {{ Lang::get('home.nicu_admission_entries')}} {{ $search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="dataTables_paginate paging_bootstrap pagination_footer">
                           <ul class="pagination">
                              <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                                 <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('nicu-admission?page='.$pagination['previous']) }}@endif">&#8592; {{ Lang::get('home.nicu_admission_previous')}}</a>
                              </li>
                              @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                              <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                 <a class='sort_with_page' href="{{ url('nicu-admission?page='.$i) }}">{{$i}}</a>
                              </li>
                              @endfor
                              <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                 <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('nicu-admission?page='.$pagination['next']) }}@endif">{{ Lang::get('home.nicu_admission_next')}} &#8594; </a>  
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
<div class="modal fade bs-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 id="myModalLabel" class="modal-title">Baby Details</h4>
         </div>
                     
         <div class="modal-body">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <p>Date: <span class="col-date"></span></p>
                  </div>
                  <div class="col-md-6">
                     <p>Time: <span class="col-time"></span></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <p>Name: <span class="col-name"></span></p>
                  </div>
                  <div class="col-md-6">
                     <p>Blood Group: <span class="col-bloodgroup"></span></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <p>DOB: <span class="col-dob"></span></p>
                  </div>
                  <div class="col-md-6">
                     <p>Sex: <span class="col-sex"></span></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <p>{{ Lang::get('home.mrn')}}: <span class="col-bmrno"></span></p>
                  </div>
                  <div class="col-md-6">
                     <p>Type of Care: <span class="col-typeofcare"></span></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <p>Birth Weight(Gms): <span class="col-birthweight"></span></p>
                  </div>
                  <div class="col-md-6">
                     <p>Admission Weight: <span class="col-admissionweight"></span></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <p>Gestation : <span class="col-gestation"></span></p>
                  </div>
                  <div class="col-md-6">
                     <p>Corrected Gestational Age: <span class="col-correctedgestation"></span></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <p>Referred From: <span class="col-referredby"></span></p>
                  </div>
                  <div class="col-md-6">
                     <p>Referral Reason: <span class="col-referralreason"></span></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <p>Age On Admission in days: <span class="col-admissionage"></span></p>
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
   function DeleteData(id){
    bootbox.confirm("Are you sure?",function(confirmed){
     if(confirmed){
      $("#DeleteForm").attr('action',"{{ action('Admission\NicuController@index') }}/"+id);
      $("#DeleteForm").submit();
    }
   });
   }
   $('.admission-date').tooltip({ html: true });
   
   // $('#search').click(function() {
   // $('#search-form').submit();
   // });
   
   // $('.sorting_by').on('click', function(e) {
   // e.preventDefault();
   // var sortby       = $(this).data('field');
   // pagination(sortby);
   // });
   
   // $('.sort_with_page').click(function(e){
   // e.preventDefault();
   // var sorting_param = $('#limit-form').serialize();
   // var link      = $(this).attr('href');
   // var searchText    = $('input[name="search_txt"]').val();
   // window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
   // });
   
   // $('select[name="limit"]').on('change',function(e) {
   // e.preventDefault();
   // pagination();
   // });
   
   // function pagination(sortby) {
   // var pagination_url = $('#limit-form').attr('action');
   // var limit          = $('select[name="limit"] option:selected').val();
   // var searchText     = $('input[name="search_txt"]').val();    
   // var sorting_param  = $('#limit-form').serialize();
   // var sorting_param1 = sorting_param.split('&sortorder=')[0];
   // var sorting_param2 = sorting_param.split('&sortorder=')[1];
   
   // if (sortby) {
   //   $('#sortby').val(sortby);
   //   if (sorting_param2 == 'desc') {
   //     var sortorder = 'asc';
   //     $('#sortorder').val(sortorder);
   //   } else {
   //     var sortorder = 'desc';
   //     $('#sortorder').val(sortorder);
   //   }
   //   window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
   // } else {
   //   window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
   // }
   
   // }
   
   $(document).on('click', '.check-neonatal', function(e) {
   var neonatal_id = $(this).attr('data-neonatal-id');
   var baby_id = $(this).attr('data-baby-id');
   if (neonatal_id == '') {    
     e.preventDefault();
     // bootbox.confirm("Please, complete the 'Neonatal Performa'.",function(confirmed){
     //   if(confirmed){
     //     window.location = "{{ action('Registration\NeonatalController@create')}}/"+baby_id;
     //   }
     // });
     bootbox.dialog({
       message: "Please, complete the 'Neonatal Performa'.",
       buttons: {
         ok: {
           label: "Later",
           className: "btn-danger"
         },
         confirm: {
           label: "Go To Neonatal Performa",
           className: "btn-success",
           callback: function() {
             window.location = "{{ action('Registration\NeonatalController@create')}}/"+baby_id;
           }
         }
       }
     });
   }
   });
   
</script>
@endsection
