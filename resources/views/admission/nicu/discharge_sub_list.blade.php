@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>

@php   

  Session::put('slug-nav','discharge-list');
  $hide='true';

@endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }} ">{{ Lang::get('home.nicu_discharge_sub_dashboard') }}</a>
		</li>
		<li>
			<a href="{{ action('Admission\NicuController@dischargeList') }}/discharged">{{ Lang::get('home.nicu_discharge_sub_details')}}</a>
		</li> 
    <li class="current">
      <a href="javascript::void(0);">{{ Lang::get('home.nicu_discharge_sub_history') }} {{ $BabyName }} {{ $babyMrno or '' }}</a>
    </li>                                                    
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
	 <div class="widget box table-view-shadow">
		<div class="widget-header">
			<h4>{{ Lang::get('home.nicu_discharge_sub_details') }}</h4>
      @if(in_array('NICU_FORM',$write_permission))
			  <a href="{{ action('Admission\NicuController@chooseBaby') }}" title="" class="btn btn-info pull-right hide create-btn-spacing">
          <i class="fa fa-plus"></i> <span>{{ Lang::get('home.nicu_discharge_sub_create') }}</span>
        </a>       
      @endif                         
		</div>
    <div class="widget-content inherittable">
      <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
        <div class="row">         
        </div>
      </div>
      <table class="table table-striped table-bordered table-responsive dataTable datatable"  id="data-list">
      <thead>
        <tr>
          <th>{{ Lang::get('home.nicu_discharge_sub_sno') }}</th>
          <th >{{ Lang::get('home.nicu_discharge_sub_admission') }}</th>
          <th>{{ Lang::get('home.ip') }}</th>
          <th class="hidden-xs">{{ Lang::get('home.nicu_discharge_sub_da') }}</th>
          <th class="hidden-xs">{{ Lang::get('home.nicu_discharge_sub_dd') }}</th>
          

        @if($hide=='true') 
          <!-- <th class="hidden-xs">{{ Lang::get('home.nicu_discharge_sub_preview') }}</th>    -->
          <!-- <th class="hidden-xs">Daycare Summary Print</th>    -->
          <!-- <th class="hidden-xs">Problem Based Summary Print</th>    -->
          <!-- <th class="hidden-xs">Edited Print</th>    -->
          @if(in_array('NICU_FORM',$write_permission))
          <!-- <th class="hidden-xs">{{ Lang::get('home.nicu_discharge_delete') }}</th>  -->
          @endif                              
        @endif 
       </tr>
      </thead>
      <tbody>
        @for ($i = 0; $i <  @count($results); $i++)
          <tr>
             <td>{{ $i+1 }}</td>
             <td>
              <a class="icon edit-discharge @if(!in_array('NICU_FORM',$write_permission)) permission-denied @endif"  href="@if(in_array('NICU_FORM',$write_permission)) {{ action('Admission\NicuController@dischargeedit',\SiteHelpers::encrypt_id($results[$i]->NicuId)) }} @else javascript:void(0);  @endif">
               {{  $results[$i]->episodes }}
              </a> 
             </td>
             <td>{{  $results[$i]->ip_number }}</td>
             <td class="hidden-xs"> 
              @if(date('Y',strtotime($results[$i]->AdmissionDate)) > 1970) 
                {{  date('d-m-Y',strtotime($results[$i]->AdmissionDate)) }}
              @endif  
              </td>
             <td class="hidden-xs">
              @if(date('Y',strtotime($results[$i]->DischargeDate)) > 1970) 
                {{  date('d-m-Y',strtotime($results[$i]->DischargeDate)) }}
              @endif  
             </td>
       @if($hide=='true')    
      <!--   <td  class="center-align-phone hidden-xs">
            <a class="btn btn-warning btn-view" href="{{ action('Reports\NicuDischargeController@index',\SiteHelpers::encrypt_id($results[$i]->BabyId.'-'.$results[$i]->AdmissionId)) }}" title="Generated Print">
                <i class="fa fa-print"></i> 
            </a>
          </td>   
        <td  class="center-align-phone hidden-xs">
            <a class="btn btn-warning btn-view" href="{{ url('problems-discharge-summary/'.SiteHelpers::encrypt_id($results[$i]->BabyId.'-'.$results[$i]->AdmissionId)) }}" title="Generated Print">
                <i class="fa fa-print"></i> 
            </a>
          </td> -->
           <!--  <td  class="center-align-phone hidden-xs">
            <a class="btn btn-default btn-view" href="{{ action('Admission\NicuController@getAbbreviatedsummaryShow',$results[$i]->NicuId) }}" title="Final Print">
                <i class="fa fa-file-word-o"></i> 
            </a>
          </td> -->
          @if(in_array('NICU_FORM',$write_permission))
      
           <!-- <td class="center-align-phone hidden-xs">
               <a class="icon" href="javascript:void(0);" onclick="DeleteData({{$results[$i]->NicuId}})">
                  <i class="fa fa-remove"></i> 
                   <span class="hidden-phone">{{ Lang::get('home.nicu_discharge_delete') }}</span>
                </a>
            </td> -->
          @endif         
        @endif  
        </tr>
     @endfor
    </tbody>
   </table>   
 </div>
</div>
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}

              
@endsection
@section('scripts')
<script type="text/javascript">

function DeleteData(id){
	bootbox.confirm("Are you sure?",function(confirmed){
		if(confirmed){
			$("#DeleteForm").attr('action',"{{ action('Admission\NicuController@dischargeList') }}/discharged/"+id);
			$("#DeleteForm").submit();
		}
	});
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
