@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
@php $hide='false'; @endphp
{{ Session::put('daycare-create-slug','2') }}
{{ Session::put('daycare-baby-id',$babyId) }}
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">{{ Lang::get('home.daycare_sub_dashboard')}}</a></li>
		<li><a href="{{ action('Admission\DaycareController@index') }}">{{ Lang::get('home.daycare_sub_daycare') }}</a></li>  
    <li class="current"><a href="javascript:void(0);">@if(!empty($babyName)) {{ Lang::get('home.daycare_sub_history') }} {{ $babyName  }}  {{ $bmrno or '' }} @else {{ Lang::get('home.daycare_sub_baby') }} @endif </a></li>                                               
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>{{ Lang::get('home.daycare_sub_history1') }}</h4>
        @if(in_array('NICU_DAY',$write_permission))
					<a href="{{ action('Admission\DaycareController@create') }}" title="Create New" class="btn create-btn-spacing btn-basic-shadow btn-info pull-right"><i class="fa fa-plus "></i> <span>Create New</span></a>  
        @endif                              
			</div>
			<div class="widget-content inherittable">  
        <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <div class="row"></div>
        </div>
	      <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
        <thead>
            <tr>
                <th>  {{ Lang::get('home.daycare_sub_sno') }}</th>
                <th>  {{ Lang::get('home.daycare_sub_admission') }}</th>
                <th>  {{ Lang::get('home.ip') }}</th>
                <th class="hidden-xs">  {{ Lang::get('home.daycare_sub_doa') }}</th>
                <th class="hidden-xs">  {{ Lang::get('home.daycare_sub_dod') }}</th>
              @if($hide=='true')
                @if(in_array('NICU_DAY',$write_permission))
                <th >{{ Lang::get('home.daycare_sub_edit') }}</th>  
                <th class="hidden-xs">{{ Lang::get('home.daycare_sub_delete') }}</th>                            
                @endif   
                <th class="hidden-xs">{{ Lang::get('home.daycare_sub_preview') }}</th>
                <th>{{ Lang::get('home.daycare_sub_print') }}</th>   
              @endif
            </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i <  @count($results); $i++)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>
            <a href="{{ url('daycare-admission/daycare-admission-daylist/'.\SiteHelpers::encrypt_id($results[$i]->AdmissionId)) }}">
                  {{  $results[$i]->episodes }}
            </a>
          </td>
          <td class="hidden-xs">{{  $results[$i]->ip_number }}</td>
          <td class="hidden-xs">
            @if(date('Y',strtotime($results[$i]->AdmissionDate)) > 1970) 
              {{  date('d-m-Y', strtotime($results[$i]->AdmissionDate)) }}
            @endif  
          </td>
          <td>
            @if(date('Y',strtotime($results[$i]->DischargeDate)) > 1970) 
              {{  date('d-m-Y', strtotime($results[$i]->DischargeDate)) }}
            @endif  
          </td>
          @if($hide=='true')
          @if(in_array('NICU_DAY',$write_permission))
          <td  class="center-align-phone">
            <a class="icon" href="{{ action('Admission\DaycareController@edit', $results[$i]->DayId) }}">
              <i class="fa fa-pencil"></i> 
              <span class="hidden-phone">Edit</span>
            </a>
          </td>
          <td  class="center-align-phone hidden-xs">
            <a class="icon" href="javascript:void(0);" onclick="DeleteData({{ $results[$i]->DayId }})">
              <i class="fa fa-remove"></i> 
              <span class="hidden-phone">Delete</span>
            </a>
          </td>
          @endif
          <td  class="center-align-phone hidden-xs">
            <a class="icon" onclick="ShowModal({!!  $results[$i]->DayId !!},'{{ action('Admission\DaycareController@getData',$results[$i]->DayId) }}')" href="javascript:void(0);">
              <i class="fa fa-eye"></i> 
              <span class="hidden-phone">View</span>
            </a>
          </td>          
          <td  class="center-align-phone">
            <a class="icon" href="{{ action('Admission\DaycareController@printData',$results[$i]->DayId) }}">
              <i class="fa fa-print"></i> 
              <span class="hidden-phone">Print</span>
            </a>
          </td>   
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
 
<!--
	DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK 
-->   
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}        
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
				  @if(in_array('NICU_DAY',$write_permission))
				  EditLink = '<a href="/daycare-admission/'+Datas['DayId']+'/edit" class=""><i class="fa fa-pencil"></i></a>';
				  @endif
				 PrintLink = '<a href="/daycare-admission/'+Datas['DayId']+'/printdata" class=""><i class="fa fa-print"></i></a>';
				  $(".modal-title").html(Datas['BabyName']+' '+EditLink + ' '+PrintLink);						  			  
				 
				  $(".col-name").html(Datas['BabyName']);
				  $(".col-bmrno").html(Datas['BMrNo']);
				  $(".col-sex").html(Datas['Sex']);
				  $(".col-cga").html(Datas['CGA']);				  				  				  				
				  $(".col-birthweight").html(Datas['BirthWeight']);				  				  				  				
				  $(".col-dob").html(Datas['DOB']);			
				  $(".col-dayoflife").html(Datas['DayOfLife']);								  
				  $(".col-date").html(Datas['DayDate']);				  				  				  				
				  $(".col-time").html(Datas['DayTime']);	
				  $(".col-admissionage").html(Datas['AgeOnAdmission']);	
				  $(".col-currentprobs").html(Datas['CurrentProblems']);				  				  				  								  				   								  
				  $(".col-previousprobs").html(Datas['PreviousProblems']);
				  $(".col-background").html(Datas['Background']);				  				  				  				
				  
				  },
			  complete: function(){
			  	$('#basicModal').modal('show');
			  }
		});
}
function DeleteData(id){
	  bootbox.confirm("Are you sure?",function(confirmed){
		  if(confirmed){
			  $("#DeleteForm").attr('action',"{{ action('Admission\DaycareController@index') }}/"+id);
			  $("#DeleteForm").submit();
		  }
	  });
}

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
